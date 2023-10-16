<?php
ob_start();  // Start output buffering
?>
    <p class="lead">Using below options create dynamic form.</p>
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-8">
            <form class="needs-validation" id="form-creation-form" novalidate="">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="dynamic-form-name" class="form-label">Form Name</label>
                        <input
                                name="dynamic-form-name"
                                type="text" class="form-control"
                                id="dynamic-form-name"
                                placeholder="e-g: User Registration Form"
                                value=""
                                required
                        >
                        <div class="invalid-feedback">
                            Form Name is required and must be Alpha-numeric
                        </div>
                    </div>
                </div>
                <div id="form-cards" class="g-3">
                    <?php include __DIR__.'/components/card_component.php'; ?>
                </div>
                <br/>
                <div class="row">
                    <div class="col d-flex justify-content-end gap-3">
                        <button class="btn btn-primary" type="button" onclick="addFieldV2()">
                            Add Field
                        </button>
                        <button class="btn btn-success" type="submit">
                            Submit Form
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript">

            // Outside any function, to capture the original .card
            let fieldCount = 1;

            // Function to add a new field to the form creation interface
            async function addFieldV2() {
                // Increment the field count
                fieldCount++;

                // Let's fetch dynamic component.
                const response = await fetch('/forms/component/dynamic-form-input', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `fieldCount=${fieldCount}`
                });

                const cardHTML = await response.text();
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = cardHTML;
                const newCard = tempDiv.querySelector('.card');
                const container = document.getElementById('form-cards');

                // Debugging: Check if both parent and child elements are valid
                console.log('Parent element:', container);
                console.log('Element to append:', newCard);
                // Append the cloned card to the container
                container.appendChild(newCard);
            }

            function validateField(field) {
                let isValid = true;
                const value = field.value;
                const regex = /[^a-zA-Z0-9 ]/g;  // For text input fields only

                if (field.type === 'text' && (regex.test(value) || (field.required && value.trim() === ''))) {
                    isValid = false;
                    field.classList.add('is-invalid');
                } else if (field.tagName.toLowerCase() === 'select' && (field.required && value.trim() === '')) {
                    isValid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }

                return isValid;
            }

            const form = document.getElementById('form-creation-form');
            form.addEventListener('submit', function (e) {
                // Prevent from submitting
                e.preventDefault();


                //Let's first validate all the text inputs.
                // Iterate over all input fields

                let isValid = true;

                // Validate text input fields
                const inputFields = document.querySelectorAll('input[type="text"]');
                inputFields.forEach((field) => {
                    isValid = isValid && validateField(field);
                });

                // Validate select fields
                const selectFields = document.querySelectorAll('select');
                selectFields.forEach((field) => {
                    isValid = isValid && validateField(field);
                });

                // Force form validation to refresh and show custom messages
                form.classList.add('was-validated');

                console.log('isValid', isValid);

                if (isValid) {

                    const formData = new FormData(this);

                    // Log form data for debugging
                    formData.forEach((value, key) => {
                        console.log(`${key}: ${value}`);
                    });

                    console.log('FormData Would Be', formData);

                    fetch('/api/forms/create', {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => response.json())
                        .then(({success, data, message}) => {
                            if (success === true) {
                                // Storing message before redirection
                                localStorage.setItem('successMessage', 'Form Successfully Generated.');
                                if(data?.formID){
                                    localStorage.setItem('newFormID', data.formID);
                                }
                                window.location.href = '<?= getBaseUrl() ?>/forms/list'
                            }
                        });
                } else {
                    console.log('Form is invalid. Not submitting.');
                }

            });

    </script>

<?php
$pageTitle = 'Add New Dynamic Form';
$content = ob_get_clean();  // Store buffered content into $content variable
include 'layouts/default.php';  // Include the default layout
?>