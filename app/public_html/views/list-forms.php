<?php
ob_start();  // Start output buffering

$fetchUrl = getBaseUrl() . "/api/forms/fetch";
$json = file_get_contents($fetchUrl);
$entries = json_decode($json, true);
?>
    <p>Showing List of all the forms</p>
    <div class="alert alert-success" role="alert" id="success-alert" style="display: none;">
        A simple primary alert—check it out!
    </div>
    <div class="table-responsive small">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Email Fields</th>
                <th scope="col">Last Updated</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php

            if ($json === false) {
                echo 'Failed to fetch entries from the API.';
            }

            if (empty($entries)) {
                echo 'No entries found.';
            } else {
                foreach ($entries as $entry) {
                    ?>
                        <tr>
                            <td>
                                <?=$entry['id']?>
                            </td>
                            <td>
                                <?=$entry['name']?>
                            </td>
                            <td>
                                <?=$entry['email_fields']?>
                            </td>
                            <td>
                                <?=$entry['updated_at']?>
                            </td>
                            <td>
                                <a href="/forms/preview/<?= $entry['id'] ?>" class="btn btn-sm btn-primary">
                                    Preview
                                </a>
                            </td>
                        </tr>
                    <?php
                }
            }
            ?>
            </tbody>
        </table>
    </div>

    <script type="text/javascript">
        function clearLocalStorage() {
            localStorage.removeItem('successMessage');
            localStorage.removeItem('formId');
        }

        function previewBtn(formId) {
            return `<a href="/forms/preview/${formId}" class="btn btn-sm btn-primary">
                        Preview
                    </a>`
        }
        const successMessage = localStorage.getItem('successMessage');
        const formId = localStorage.getItem('newFormID');
        if (successMessage) {
            const alertBox = document.getElementById('success-alert');

            if (formId) {
                const prevBtn = previewBtn(formId);
                alertBox.innerHTML = `${successMessage} - ${prevBtn}`
            } else {
                alertBox.innerHTML = successMessage
            }

            alertBox.style.display = 'block';

            //Clear the LocalStorage
            clearLocalStorage();
        }
    </script>


<?php
$pageTitle = 'Available Forms';
$content = ob_get_clean();  // Store buffered content into $content variable
include 'layouts/default.php';  // Include the default layout
?>