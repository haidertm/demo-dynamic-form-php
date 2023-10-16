<?php
// Require header
require_once __DIR__ . '/templates/header.php';

// Fetch form metadata from the API
$form_id = $_GET['id'];
$form_meta = json_decode(file_get_contents('http://your-domain.com/api/view-entry?id=' . $form_id), true);

// Generate and display form
echo '<form id="dynamic-form">';
foreach ($form_meta['fields'] as $field) {
    // ... generate form fields based on field type ...
}
echo '<button type="submit">Submit</button>';
echo '</form>';

// Handle form submission via Ajax
?>
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
// Require footer
require_once __DIR__ . '/templates/footer.php';
?>
