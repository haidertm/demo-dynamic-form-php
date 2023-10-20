let rowCounter = 1; // Initialize row counter

function addOption(buttonElement, fieldCount) {
    // Select the container where rows are held
    const selectOptions = document.getElementById(`select_options_${fieldCount}`);

    // Clone the row that the clicked button belongs to
    const currentRow = buttonElement.closest('.row');
    const newRow = currentRow.cloneNode(true);

    // Remove the Add + button from the current row
    const currentAddButton = currentRow.querySelector('.btn-primary');
    if (currentAddButton) {
        currentAddButton.remove();
    }

    // Update the 'name' and 'id' attributes
    const inputs = newRow.querySelectorAll('input');
    const suffix = ++rowCounter; // Increment the counter

    inputs.forEach(input => {
        const name = input.getAttribute('name');
        const id = input.getAttribute('id');

        if (name) {
            const newName = name.replace(/\[\d+]$/, '[' + suffix + ']');
            input.setAttribute('name', newName);
        }

        if (id) {
            const newId = id.replace(/\d+$/, suffix);
            input.setAttribute('id', newId);
        }

        // Clear the value of the new input fields
        input.value = '';
    });

    // Append the new row to the container
    selectOptions.appendChild(newRow);
}
