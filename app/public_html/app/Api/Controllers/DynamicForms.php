<?php

namespace Haider\Demo\Api\Controllers;

use Haider\Demo\core\classes\Request;
use Haider\Demo\core\classes\Database;

class DynamicForms extends Controller
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function add()
    {
        $this->render('add-form');
    }


    public function preview(Request $request)
    {
        $formID = $request->getRouteParameter('formID');

        $query = "SELECT fields.*, forms.name AS form_name
              FROM fields
              LEFT JOIN forms ON fields.form_id = forms.id
              WHERE forms.id = :formId";

        // Execute the query with the form ID as a named parameter
        $fieldsList = $this->db->fetchAssoc($query, [':formId' => $formID]);

        $pageTitle = 'Dynamic Form # '. $formID;

        if (!empty($fieldsList)) {
            $pageTitle = $fieldsList[0]['form_name'];
        }

        $data = [
            'pageTitle' => $pageTitle,
            'fields' => $fieldsList
        ];

        $this->render('view-entry', $data);
    }



    public function list()
    {
        $this->render('list-forms');
    }

    /**
     * @return string
     * Fetch list of all the forms that were created in JSON format.
     */
    public function fetch()
    {
        $formsList = $this->db->fetchAssoc("SELECT * FROM forms");
        if (!$formsList) {
            die('No Data Found');
        }
        echo json_encode($formsList);
    }

    public function dynamicFormInput()
    {
        echo $this->render('components/card_component');
    }

    public function store(Request $request)
    {
        $formName = $request->get('dynamic-form-name');
        $formDescription = 'Temporary, Can work on it from form later';

        // Insert a new form record into the database
        $stmt = $this->db->query("INSERT INTO forms (name, description) VALUES (?, ?)", [$formName, $formDescription]);

        // Get the ID of the newly inserted form
        $formId = $this->db->getPDO()->lastInsertId();

        if (!$formId) {
            return false;
        }

        $inputFields = $request->get('Card');


        foreach ($inputFields as $key => $field) {
            $fieldName = $field['field-name'];
            $fieldType = $field['field-type'] ?? 'Input';
            $sendViaEmail = isset($field['send-via-email']) ? 1 : 0;
            $fieldValidationRules = [
                'required' => !!($field['is-required'] ?? false),
//                Can have more validations in future when needed.
//                'min_length' => 3,
//                'max_length' => 50
            ];
            // Encode the validation rules to JSON
            $validationRulesJson = json_encode($fieldValidationRules);
            $stmt = $this->db->query("INSERT INTO fields (form_id, field_name, field_type, validation_rules, send_via_email) VALUES (?,?,?,?,?)", [$formId, $fieldName, $fieldType, $validationRulesJson, $sendViaEmail]);
        }

        $this->jsonResponse(
            $success = true,
            $message = 'Form Successfully Generated',
            $data = [
                'formID' => $formId
            ],
            $statusCode = 200
        );
    }
}
