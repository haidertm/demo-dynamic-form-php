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

        $query = "SELECT fields.*, forms.name AS form_name, field_options.option_label, field_options.option_value
              FROM fields
              LEFT JOIN forms ON fields.form_id = forms.id
              LEFT JOIN field_options ON fields.id = field_options.field_id
              WHERE forms.id = :formId";

        // Execute the query with the form ID as a named parameter
        $rows = $this->db->fetchAssoc($query, [':formId' => $formID]);

        $fieldsList = [];
        foreach ($rows as $row) {
            $fieldId = $row['id'];
            if (!isset($fieldsList[$fieldId])) {
                $fieldsList[$fieldId] = [
                    'id' => $fieldId,
                    'field_name' => $row['field_name'],
                    'field_type' => $row['field_type'],
                    'form_name' => $row['form_name'],
                    'options' => []
                ];
            }

            if ($row['option_label'] && $row['option_value']) {
                $fieldsList[$fieldId]['options'][] = [
                    'label' => $row['option_label'],
                    'value' => $row['option_value']
                ];
            }
        }

        $pageTitle = 'Dynamic Form # ' . $formID;

        if (!empty($fieldsList)) {
            $firstField = reset($fieldsList);
            $pageTitle = $firstField['form_name'];
        }

        $data = [
            'pageTitle' => $pageTitle,
            'fields' => array_values($fieldsList) // re-index the array
        ];

        $this->render('view-entry', $data);
    }


    public function dynamicFormsSelectTemplate(Request $request)
    {
        $slug = $request->getRouteParameter('slug');
        $fieldCount = $request->get('fieldCount');
        $this->render("templates/add_forms/{$slug}", compact('fieldCount'));
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
        $formsList = $this->db->fetchAssoc("SELECT * FROM forms ORDER BY id DESC");
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
            $this->jsonResponse(
                $success = false,
                $message = 'Failed to Insert',
                $data = [],
                $statusCode = 500
            );
        }

        $inputFields = $request->get('Card');


        foreach ($inputFields as $key => $field) {
            $fieldName = $field['field-name'];

            /**
             * Available input types are
             * input
             * text_area
             * select_option
             * radio
             * checkbox
             */

            $fieldType = $field['field-type'] ?? 'input';
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

            $fieldId = $this->db->getPDO()->lastInsertId();

            if (!$fieldId) {
                continue; // Skip if the field was not inserted
            }

            // Check if the field type is 'select_option' and insert the options into select_options table
            if ($fieldType === 'select_option') {

                // Check if the current field has options
                if (isset($field['option_label']) && is_array($field['option_label']) && isset($field['option_value']) && is_array($field['option_value'])) {
                    $optionLabels = $field['option_label'];
                    $optionValues = $field['option_value'];

                    // Insert these options into a separate table related to this field
                    foreach ($optionLabels as $index => $label) {
                        $value = $optionValues[$index] ?? null;

                        $this->db->query("INSERT INTO field_options (field_id, option_label, option_value) VALUES (?,?,?)", [$fieldId, $label, $value]);
                    }
                }
            }
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
