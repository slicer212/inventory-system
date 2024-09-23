$(document).on('click', '.accept-request, .reject-request', function () {
    const requestId = $(this).data('id');
    const action = $(this).hasClass('accept-request') ? 'accept' : 'reject';

    const confirmationMessage = action === 'accept' ? 
        'Are you sure you want to accept this borrow request?' : 
        'Are you sure you want to reject this borrow request?';

    if (confirm(confirmationMessage)) {
        $.ajax({
            url: 'process_admin_request.php',
            method: 'POST',
            data: {
                requestId: requestId,
                action: action
            },
            success: function (response) {
                if (response.trim() === 'success') {
                    alert(`Borrow request ${action}ed successfully!`);
                    location.reload();  // Refresh the page to update the borrow request status
                } else {
                    alert(`Error: ${response}`);
                }
            },
            error: function () {
                alert(`Error ${action}ing the borrow request.`);
            }
        });
    }
});