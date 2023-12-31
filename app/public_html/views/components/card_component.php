<?php
$fieldCount = $_POST['fieldCount'] ?? '1';  // Default to '1' if not set

$getFieldId = function($fieldLabel) use ($fieldCount) {
    return "{$fieldLabel}-{$fieldCount}";
};

$getFieldName = function($fieldLabel) use ($fieldCount) {
    return "Card[{$fieldCount}][{$fieldLabel}]";
};

?>

<div class="card mt-3">
    <div class="card">
        <div class="card-header" data-id="<?= $fieldCount ?? 1 ?>">
            Field <?= $fieldCount ?? 1 ?>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-8 col-sm-12">
                    <label for="<?=$getFieldId('field-name')?>" class="form-label">Field Name</label>
                    <input
                            name="<?=$getFieldName('field-name')?>"
                            type="text" class="form-control"
                            id="<?=$getFieldId('field-name')?>"
                            placeholder="Field Name"
                            value=""
                           required
                    >
                    <div class="invalid-feedback">
                        Field Name is required and must be Alpha-numeric
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <label for="<?=$getFieldId('field-type')?>" class="form-label">Field Type</label>
                    <select class="form-select" name="<?=$getFieldName('field-type')?>" id="<?=$getFieldId('field-type')?>" required>
                        <option value="">Select...</option>
                        <option value="input">Input</option>
                        <option value="text_area">Text Area</option>
                        <option value="select_option">Select</option>
                        <option value="radio">Radio</option>
                        <option value="checkbox">Checkbox</option>
                    </select>
                </div>
            </div>
            <div id="template_placeholder_<?= $fieldCount ?? 1 ?>" class="row mt-5" style="display: none;">
            </div>
            <div class="row mt-5">
                <div class="col-md-6">
                    <div class="form-check">
                        <input type="checkbox" name="<?=$getFieldName('send-via-email')?>" class="form-check-input" id="<?=$getFieldId('send-via-email')?>">
                        <label class="form-check-label" for="<?=$getFieldId('send-via-email')?>">Send via email</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <strong>Form Validations</strong>
                    <div class="form-check">
                        <input type="checkbox" name="<?=$getFieldName('is-required')?>" class="form-check-input" id="<?=$getFieldId('is-required')?>">
                        <label class="form-check-label" for="<?=$getFieldId('is-required')?>">is required</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
