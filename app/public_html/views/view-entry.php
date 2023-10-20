<?php

ob_start();  // Start output buffering
?>
    <p class="lead">Following is dynamically generated</p>
<div class="small">

    <div class="row justify-content-center">
        <?php
        if(!isset($data)) {
            echo 'No Data Available';
        } else {
            ?>
            <form class="col-md-8 needs-validation" style="display: inline-block" id="form-creation-form" novalidate="">
                    <?php
                    foreach ($data['fields'] as $key => $field):

                        $fieldId = $field['id'];
                        $fieldType = $field['field_type'];
                        $fieldName = $field['field_name'];
                        $fieldOptions = $field['options'] ?? null;

                        switch ($fieldType):
                            case 'input':
                                include 'components/input.php';
                                break;
                            case 'text_area':
                                include 'components/text_area.php';
                                break;
                            case 'select_option':
                                include 'components/select.php';
                                break;
                            case 'radio':
                                echo 'To work on radio template here';
                                break;
                            case 'checkbox':
                                echo 'To work on checkbox template here';
                                break;
                            default:
                                echo 'Does not have any type';
                        endswitch;

                    endforeach ?>
            </form>

        <?php } ?>
    </div>
</div>

<script>
    document.getElementById('dynamic-form').addEventListener('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        fetch('http://your-domain.com/api/submit-form', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                // ... handle response ...
            });
    });
</script>
<?php
$pageTitle = $data['pageTitle'] ?? 'Dynamic Form';
$content = ob_get_clean();  // Store buffered content into $content variable
include 'layouts/default.php';  // Include the default layout
?>