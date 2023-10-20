<div class="col-md-8 mt-4">
    <label for="dynamic-form-name" class="form-label"><?= $fieldName ?? 'Field Name' ?></label>
    <select
        name="dynamic-form-name"
        type="text" class="form-control"
        id="dynamic-form-name"
        required
    >
        <option value="">Select...</option>
        <?php
        if(isset($fieldOptions)){
            foreach ($fieldOptions as $key => $option) {
                ?>

                <option value="<?= $option['value'] ?? $option['label'] ?>"><?= $option['label'] ?></option>
        <?php
            }
        }
        ?>
    </select>
    <div class="invalid-feedback">
        Form Name is required and must be Alpha-numeric
    </div>
</div>