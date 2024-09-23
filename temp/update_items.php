<div class="modal fade" id="form_items" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Manage items</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <span aria-hidden="true">&times;</span>
      </div>
      <div class="modal-body">
      <form id="update_item_form" onsubmit="return false">
  <div class="form-row">
    <div class="form-group col-md-6">
        <input type="hidden" name="pid" id="value" value=""/>
      <label for>Date</label>
      <input type="text" class="form-control" name="added_date" id="added_date" placeholder="Date" value="<?php echo date("Y-m-d");?>" readonly>
    </div>
    <div class="form-group col-md-6">
      <label for>Item Name</label>
      <input type="text" class="form-control" name="update_item" id="update_item" placeholder="Enter Item Name" required>
    </div>
  </div>
  <div class="form-group">
    <label>Category</label>
    <select class="form-control" name="select_cat" id="select_cat" required></select>
  </div>
  <div class="form-group">
    <label>Quantity</label>
    <input type="text" class="form-control" id="item_qty" name="item_qty" placeholder="Enter Quantity">
  </div>
  <button type="submit" class="btn btn-success">Update Item</button>
  </form>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
  </div>
</div>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
    var DOMAIN = "http://localhost/inventory_system";

    // Fetch categories to populate both dropdowns
    fetch_category();
    function fetch_category(){
        $.ajax({
            url : DOMAIN + "/includes/process.php",
            method : "POST",
            data : {getCategory:1},
            success : function(data){
                var root = "<option value='0'>Root</option>";
                var choose = "<option value=''>Choose Category</option>";
                $("#parent_cat").html(root + data);
                $("#select_cat").html(choose + data);
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
                    $("#item_form")[0].reset();
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
});
</script>