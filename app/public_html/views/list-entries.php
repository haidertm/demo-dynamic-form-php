<?php
ob_start();  // Start output buffering
?>
    <p>Showing List of all the forms</p>
    <div class="table-responsive small">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            // Fetch entries from the API

            $json = file_get_contents('http://localhost/api/list-entries.php');
            $entries = json_decode($json, true);
            if ($json === false) {
                die('Failed to fetch entries from the API.');
            }

            if (empty($entries)) {
                echo 'No entries found.';
            } else {
                echo '<ul>';
                foreach ($entries as $entry) {
                    $meta = json_decode($entry['meta'], true);
                    $title = $meta['title'] ?? 'Untitled Form';
                    echo '<li><a href="view-entry.php?id=' . $entry['id'] . '">' . $title . '</a></li>';
                }
                echo '</ul>';
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