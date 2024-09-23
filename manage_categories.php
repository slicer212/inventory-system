<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Inventory System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="./includes/style.css">
    <script src="./js/manage.js"></script>
    <style>
        .login-card {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        .login-card img {
            margin-bottom: 20px;
        }

        .navbar-custom {
            background-color: #343a40;
        }

        .navbar-custom .navbar-brand, .navbar-custom .nav-link {
            color: #ffffff;
        }

        .navbar-custom .nav-link:hover {
            color: #d4d4d4;
        }

        .profile-card {
            max-width: 20rem;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        .jumbotron-custom {
            background-color: #f8f9fa;
            padding: 2rem 2rem;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }

        .card-custom {
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .card-custom .card-body {
            text-align: center;
        }

        .card-custom .card-body .btn {
            margin-top: 10px;
            width: 100%;
        }
    </style>
</head>
<body>

    <?php
    include_once("./temp/header.php");
    ?>
    <div class="container">
    <table class="table table-hover table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Category</th>
        <th>Parent</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody id="get_category">
      <!--<tr>
        <td>1</td>
        <td>School Equipment</td>
        <td>Root</td>
        <td>
            <a href="#" class="btn btn-danger btn-sm">Delete</a>
            <a href="#" class="btn btn-info btn-sm">Edit</a>
        </td>
      </tr>
      <tr> -->
    </tbody>
  </table>
</div>
</div>

<?php
include_once("./temp/update_category.php")
?>

</body>
</html>

<script>
$(document).ready(function() {
    var DOMAIN = "http://localhost/inventory_system";

    // Manage category pagination and display
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

    // Load first page
    manageCategory(1);

    // Handle pagination clicks
    $("body").delegate(".page-link", "click", function() {
        var pn = $(this).attr("pn");
        manageCategory(pn);
    });

    // Handle Edit Category
    $("body").delegate(".edit_cat", "click", function(){
        var eid = $(this).attr("eid");

        $.ajax({
            url: DOMAIN + "/includes/process.php",
            method: "POST",
            dataType: "json",
            data: {updateCategory: 1, id: eid},
            success: function(data){
                // Populate modal fields
                $("#id").val(data.id);
                $("#update_category").val(data.category_name);
                $("#parent_cat").val(data.parent_cat);
                // Show the modal
                $("#category").modal("show");
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            }
        });
    });

    // Handle Update Category Form Submission
    $("#update_category_form").on("submit",function(){
        var category_name = $("#update_category");
        var error_message = $("#cat_error");
        var status = true;

        if (category_name.val().trim() === "") {
            category_name.addClass("border-danger");
            error_message.html("<span class='text-danger'>Please Enter Category Name</span>").show();
            status = false;
        } else {
            category_name.removeClass("border-danger");
            error_message.html("").hide();
        }
    
        if (status === true) {
            $.ajax({
                url: DOMAIN + "/includes/process.php",
                method: "POST",
                data: $(this).serialize(),
                success: function(data) {
                    if (data === "UPDATED") {
                        alert("Category updated successfully!");
                        $("#category").modal("hide");
                        manageCategory(1);  // Refresh category list
                    } else {
                        alert(data);
                    }
                }
            });
        }
    });
});
</script>