// Borrow button click event for each item
$(document).on('click', '.borrow-btn', function () {
    const row = $(this).closest('tr');
    const itemData = {
        name: row.find('td:nth-child(2)').text(),
        category: row.find('td:nth-child(3)').text(),
        stock: row.find('td:nth-child(4)').text(),
        addedDate: row.find('td:nth-child(5)').text(),
    };

    // Confirmation dialog before borrowing
    if (confirm('Are you sure you want to borrow this item?')) {
        // Send AJAX request to process the borrow request
        $.ajax({
            url: './includes/process.php',
            method: 'POST',
            data: {
                borrowItem: true,
                item: itemData
            },
            success: function (response) {
                alert('Your borrow request has been sent to the admin!');
            },
            error: function () {
                alert('Error sending the borrow request.');
            }
        });
    }
});