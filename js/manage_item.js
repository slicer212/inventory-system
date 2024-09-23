$(document).ready(function() {
    var DOMAIN = "http://localhost/inventory_system";

    manageItem(1);

    function manageItem(pn) {
        $.ajax({
            url: DOMAIN + "/includes/process.php?" + new Date().getTime(),
            method: "POST",
            data: { manageItems: 1, pageno: pn },
            dataType: "json",
            success: function(data) {
                var rows = data.rows;
                var pagination = data.pagination;

                var html = '';
                var startIndex = (pn - 1) * 5;

                $.each(rows, function(index, item) {
                    var statusLabel = (item.item_stock === '0' || item.i_status === '0') ? 
                        '<span class="badge badge-danger">Not Available</span>' : 
                        '<span class="badge badge-success">Available</span>';

                    html += `
                        <tr>
                            <td>${startIndex + index + 1}</td>
                            <td>${item.item_name}</td>
                            <td>${item.category_name}</td>
                            <td>${item.item_stock}</td>
                            <td>${item.added_date}</td>
                            <td>${statusLabel}</td>
                            <td>
                                <a href="#" did="${item.pid}" class="btn btn-danger btn-sm del_item">Delete</a>
                                <a href="#" eid="${item.pid}" data-toggle="modal" data-target="#form_items" class="btn btn-info btn-sm edit_item">Edit</a>
                            </td>
                        </tr>`;
                });

                $("#get_item").html(html);
                $("#pagination").html(pagination);
            },
            error: function(xhr, status, error) {
                console.error("Error: " + status + " " + error);
            }
        });
    }

    // Handle form submission for adding an item
    $("#item_form").on("submit", function(event){
        event.preventDefault();
        
        $.ajax({
            url: DOMAIN + "/includes/process.php",
            method: "POST",
            data: $(this).serialize(),
            success: function(data){
                var response = JSON.parse(data);
                
                if (response.status === "SUCCESS") {
                    alert(response.message);
                    $("#item_form")[0].reset(); // Reset form after success
                    manageItem(1); // Refresh the items list
                } else {
                    alert("Error: " + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + ": " + error);
                alert("An error occurred. Please try again.");
            }
        });
    });

    // Pagination handler
    $("body").on("click", ".page-link", function() {
        var pn = $(this).attr("pn");
        manageItem(pn);
    });
    
    // Delete item handler
    $("body").on("click", ".del_item", function() {
        var did = $(this).attr("did");
        if (confirm("Are you sure you want to delete this item?")) {
            $.ajax({
                url: DOMAIN + "/includes/process.php",
                method: "POST",
                data: { deleteItem: 1, pid: did },
                success: function(data) {
                    if (data.trim() === "DELETED SUCCESSFULLY") {
                        alert("Item deleted successfully");
                        manageItem(1); // Refresh items list after deletion
                    } else {
                        alert("Error: " + data);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error: " + status + " " + error);
                }
            });
        }
    });

    // Edit item handler
    $("body").on("click", ".edit_item", function() {
        var eid = $(this).attr("eid");
        $.ajax({
            url: DOMAIN + "/includes/process.php",
            method: "POST",
            dataType: "json",
            data: { updateItem: 1, id: eid },
            success: function(data) {
                $("#value").val(data.pid);
                $("#update_item").val(data.item_name);
                $("#select_cat").val(data.cid);
                $("#item_qty").val(data.item_stock);
                $("#added_date").val(data.added_date);
            },
            error: function(xhr, status, error) {
                console.error("Error: " + status + " " + error);
            }
        });
    });

    // Update item form submission handler
    $("#update_item_form").on("submit", function(event){
        event.preventDefault();
        $.ajax({
            url: DOMAIN + "/includes/process.php",
            method: "POST",
            data: $(this).serialize(),
            success: function(data){
                if(data.trim() === "UPDATED") {
                    alert("Item updated successfully!");
                    $("#form_items").modal("hide");
                    manageItem(1); // Refresh the items list
                } else {
                    alert("Update failed: " + data);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error: " + status + " " + error);
            }
        });
    });
});