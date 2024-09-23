<div class="modal fade" id="category" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">Edit Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="update_category_form" onsubmit="return false">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="hidden" name="id" id="id" value=""/>
                        <input type="text" class="form-control" id="update_category" name="update_category" placeholder="Enter Category Name">
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
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>