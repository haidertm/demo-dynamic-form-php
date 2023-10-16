<?php

ob_start();  // Start output buffering
?>
    <p class="lead">Following is dynamically generated</p>
<div class="table-responsive small">

    <div class="row justify-content-center">
        <?php
        if(!isset($data)) {
            echo 'No Data Available';
        } else { ?>

            <form class="needs-validation" style="display: inline-block" id="form-creation-form" novalidate="">
<!--                <div class="row g-3">-->
                    <?php
                    foreach ($data['fields'] as $key => $field):

                        $fieldId = $field['id'];
                        $fieldType = $field['field_type'];
                        $fieldName = $field['field_name'];

                    switch ($fieldType):
                        case 'Text Area':
                            include 'components/text_area.php';
                            break;
                        case 'Select':
                            include 'components/select.php';
                            break;
                        default:
                            echo 'Does not have any type';
                    endswitch;

                    endforeach ?>
<!--                </div>-->
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