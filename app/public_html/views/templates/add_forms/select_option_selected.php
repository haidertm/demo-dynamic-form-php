<?php $fieldCount = $fieldCount ?? 1 ?>
<div class="row mt-4">
    <div class="col-lg-12 col-sm-12">
        <label for="<?= getFieldId('placeholder', $fieldCount) ?>" class="form-label">
            Select Options
        </label>
        <div id="select_options_<?= $fieldCount ?>">
            <div class="row mt-2">
                <div class="col-md-5">
                    <input
                            name="<?= getFieldName('option_label', $fieldCount) ?>[1]"
                            type="text" class="form-control"
                            id="<?= getFieldId('option_label', $fieldCount) ?>"
                            placeholder="label here..."
                            value=""
                            required
                    >
                    <div class="invalid-feedback">
                        Field Name is required and must be Alpha-numeric
                    </div>
                </div>
                <div class="col-md-5">
                    <input
                            name="<?= getFieldName('option_value', $fieldCount) ?>[1]"
                            type="text" class="form-control"
                            id="<?= getFieldId('option_value', $fieldCount) ?>"
                            placeholder="value here..."
                            value=""
                    >
                </div>
                <div class="col-md-2">
                    <div class="col d-flex justify-content-start gap-3">
                        <button class="btn btn-primary" type="button" onclick="addOption(this, <?= $fieldCount ?>)">
                            Add +
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>