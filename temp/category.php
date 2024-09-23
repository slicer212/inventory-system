<div class="modal fade" id="category" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">Add New Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="category_form" onsubmit="return false">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Enter Category Name">
                        <small id="cat_error" class="form-text text-muted"></small>

                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Parent Category</label>
                        <select class="form-control" id="parent_cat" name="parent_cat">
                            <option value="0">Root</option>
                            <?php

                            $conn = new mysqli("localhost", "root", "", "inventory_system");

                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            $sql = "SELECT id, category_name FROM categories WHERE parent_cat = 0";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['category_name'] . "</option>";
                                }
                            }

                            $conn->close();
                            ?>
                        </select>  
                    </div>
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    
    $("#category_form").on("submit", function(event) {
    var DOMAIN = "http://localhost/inventory_system";
    event.preventDefault();

    var category_name = $("#category_name");
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
                var response = JSON.parse(data);

                if (response.status === "CATEGORY_ADDED") {
                    error_message.html("<span class='text-success'>Category successfully added</span>").show();
                    $("#category_name").val("");

                    var newOption = "<option value='" + response.new_category.id + "'>" + response.new_category.category_name + "</option>";
                    $("#parent_cat").append(newOption);
                } else if (response.status === "CATEGORY_EXISTS") {
                    error_message.html("<span class='text-danger'>Category already exists</span>").show();
                } else {
                    alert(response.status);
                }
            }
        });
    }
});
</script>