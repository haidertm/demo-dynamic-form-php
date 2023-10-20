<?php $fieldCount = $fieldCount ?? 1 ?>
<div class="col-lg-6 col-md-8 col-sm-12">
    <label for="<?= getFieldId('placeholder', $fieldCount) ?>" class="form-label">
        Text Area Placeholder
    </label>
    <input
        name="<?= getFieldName('placeholder', $fieldCount) ?>"
        type="text" class="form-control"
        id="<?= getFieldId('placeholder', $fieldCount) ?>"
        placeholder="Placeholder text here..."
        value=""
        required
    >
    <div class="invalid-feedback">
        Field Name is required and must be Alpha-numeric
    </div>
</div>