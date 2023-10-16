<?php
ob_start();  // Start output buffering

$fetchUrl = getBaseUrl() . "/api/forms/fetch";
$json = file_get_contents($fetchUrl);
$entries = json_decode($json, true);
?>
    <p>Showing List of all the forms</p>
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
                                <button class="btn btn-sm btn-primary" type="button" onclick="addFieldV2()">
                                    Preview
                                </button>
                            </td>
                        </tr>
                    <?php
                }
            }
            ?>
            </tbody>
        </table>
    </div>


<?php
$pageTitle = 'Available Forms';
$content = ob_get_clean();  // Store buffered content into $content variable
include 'layouts/default.php';  // Include the default layout
?>