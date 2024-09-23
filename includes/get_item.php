<?php
include_once("./database/db.php");
include_once("manages.php");

$pageno = isset($_POST['pageno']) ? (int)$_POST['pageno'] : 1;

$m = new Manage();
$result = $m->manageRecordWithPagination("items", $pageno);
$items = $result["rows"];
$pagination = $result["pagination"];

foreach ($items as $index => $item) {
    $statusLabel = ($item['item_stock'] == '0' || $item['i_status'] == '0') ? 
        '<span class="badge badge-danger">Not Available</span>' : 
        '<span class="badge badge-success">Available</span>';
    
    // Display the items along with a Borrow button
    echo "
    <tr>
        <td>" . ($index + 1) . "</td>
        <td>" . htmlspecialchars($item['item_name']) . "</td>
        <td>" . htmlspecialchars($item['category_name']) . "</td>
        <td>" . htmlspecialchars($item['item_stock']) . "</td>
        <td>" . htmlspecialchars($item['added_date']) . "</td>
        <td>" . $statusLabel . "</td>
        <td>
            <button class='btn btn-primary borrow-btn' " . ($item['item_stock'] == '0' ? 'disabled' : '') . ">Borrow</button>
        </td>
    </tr>";
}
echo "<tr><td colspan='7'>" . $pagination . "</td></tr>";
?>