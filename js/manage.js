$(document).ready(function() {
    var DOMAIN = "http://localhost/inventory_system";

    function manageCategory(pn) {
        $.ajax({
            url: DOMAIN + "/includes/process.php",
            method: "POST",
            data: { manageCategory: 1, pageno: pn },
            success: function(data) {
                $("#get_category").html(data);
            }
        });
    }

    manageCategory(1);

    $("body").delegate(".page-link", "click", function() {
        var pn = $(this).attr("pn");
        manageCategory(pn);
    });

    $("body").delegate(".del_cat", "click", function() {
        var did = $(this).attr("did");
        if (confirm("Are you sure you want to delete this?")) {
            $.ajax({
                url: DOMAIN + "/includes/process.php",
                method: "POST",
                data: { deleteCategory: 1, id: did },
                success: function(data) {
                    if (data === "DEPENDENT CATEGORY") {
                        alert("Sorry, you cannot delete this category.");
                    } else if (data === "CATEGORY DELETED") {
                        alert("Category Deleted Successfully");
                    } else {
                        alert(data);
                    }
                    manageCategory(1);  // Refresh category list
                }
            });
        }
    });
    
});