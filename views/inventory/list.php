<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory List</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <?php include '../partials/header.php'; ?>
    
    <div class="container">
        <h1>Inventory List</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Assuming $inventoryItems is an array of inventory items fetched from the database
                foreach ($inventoryItems as $item) {
                    echo "<tr>
                            <td>{$item['id']}</td>
                            <td>{$item['type']}</td>
                            <td>{$item['quantity']}</td>
                            <td>{$item['price']}</td>
                            <td>
                                <a href='edit.php?id={$item['id']}'>Edit</a>
                                <a href='delete.php?id={$item['id']}'>Delete</a>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="create.php" class="btn">Add New Item</a>
    </div>

    <?php include '../partials/footer.php'; ?>
</body>
</html>