<?php
session_start();
include 'db_connect.php'; // Database connection include

// Fetch inventory items
$sql = "SELECT * FROM inventory";
$result = mysqli_query($conn, $sql);

// Update stock when item is used
if (isset($_POST['use_item'])) {
    $id = $_POST['id'];
    $quantity_used = $_POST['quantity_used'];
    
    // Get current quantity
    $check_sql = "SELECT quantity FROM inventory WHERE id='$id'";
    $check_result = mysqli_query($conn, $check_sql);
    $row = mysqli_fetch_assoc($check_result);
    $new_quantity = $row['quantity'] - $quantity_used;
    
    if ($new_quantity >= 0) {
        // Update inventory
        $update_sql = "UPDATE inventory SET quantity='$new_quantity', last_updated=NOW() WHERE id='$id'";
        mysqli_query($conn, $update_sql);
        echo "<script>alert('Stock updated successfully!');</script>";
    } else {
        echo "<script>alert('Not enough stock available!');</script>";
    }
}

// Add new inventory item
if (isset($_POST['add_item'])) {
    $item_name = $_POST['item_name'];
    $quantity = $_POST['quantity'];
    $insert_sql = "INSERT INTO inventory (item_name, quantity) VALUES ('$item_name', '$quantity')";
    mysqli_query($conn, $insert_sql);
    echo "<script>alert('Item added successfully!');</script>";
}

// Delete inventory item
if (isset($_POST['delete_item'])) {
    $id = $_POST['id'];
    $delete_sql = "DELETE FROM inventory WHERE id='$id'";
    mysqli_query($conn, $delete_sql);
    echo "<script>alert('Item deleted successfully!');</script>";
}

// Update inventory item
if (isset($_POST['edit_item'])) {
    $id = $_POST['id'];
    $new_item_name = $_POST['new_item_name'];
    $new_quantity = $_POST['new_quantity'];
    $update_sql = "UPDATE inventory SET item_name='$new_item_name', quantity='$new_quantity', last_updated=NOW() WHERE id='$id'";
    mysqli_query($conn, $update_sql);
    echo "<script>alert('Item updated successfully!');</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Track Supplies</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }
        h2 {
            color: #010c3e;
        }
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #010c3e;
            color: white;
        }
        input[type="text"], input[type="number"] {
            padding: 7px;
            width: 40%;
            margin-bottom: 5px;
        }
        input[type="submit"] {
            padding: 8px 15px;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }
        .add-btn {
            background-color: #010c3e;
            color: white;
        }
        .edit-btn {
            background-color: #87d3d7;
            color: black;
        }
        .delete-btn {
            background-color: red;
            color: white;
        }
        .low-stock {
            text-decoration: underline;
            text-decoration-color: red;
            position: relative;
            cursor: pointer;
        }
        .low-stock:hover::after {
            content: "Stock is low!";
            position: absolute;
            background: red;
            color: white;
            padding: 5px;
            border-radius: 5px;
            top: -25px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 12px;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <h2>Track Supplies</h2>
    <form method="post">
        <input type="text" name="item_name" placeholder="Item Name" required>
        <input type="number" name="quantity" placeholder="Quantity" min="1" required>
        <input type="submit" name="add_item" value="Add Item" class="add-btn">
    </form>

    <table>
        <tr>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Use Item</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <?php 
        include 'db_connect.php';
        $sql = "SELECT * FROM inventory";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) { 
            $lowStockClass = ($row['quantity'] <= 10) ? 'low-stock' : '';
        ?>
        <tr>
            <td class="<?php echo $lowStockClass; ?>"><?php echo $row['item_name']; ?></td>
            <td class="<?php echo $lowStockClass; ?>"><?php echo $row['quantity']; ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="number" name="quantity_used" min="1" required>
                    <input type="submit" name="use_item" value="Use" class="add-btn">
                </form>
            </td>
            <td>
                <form method="post">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="text" name="new_item_name" placeholder="New Name" required>
                    <input type="number" name="new_quantity" min="1" required>
                    <input type="submit" name="edit_item" value="Edit" class="edit-btn">
                </form>
            </td>
            <td>
                <form method="post">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="submit" name="delete_item" value="Delete" class="delete-btn" onclick="return confirm('Are you sure?');">
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
