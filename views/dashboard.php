<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'partials/header.php'; ?>
    
    <div class="container">
        <h1>Dashboard</h1>
        <p>Welcome to the Meat Inventory System!</p>
        
        <h2>Inventory Overview</h2>
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <!-- Inventory items will be populated here -->
                <?php
                // Example data, replace with dynamic data from the database
                $inventoryItems = [
                    ['type' => 'Pig', 'quantity' => 10, 'price' => 200],
                    ['type' => 'Chicken', 'quantity' => 20, 'price' => 50],
                    ['type' => 'Beef', 'quantity' => 15, 'price' => 300],
                ];

                foreach ($inventoryItems as $item) {
                    echo "<tr>
                            <td>{$item['type']}</td>
                            <td>{$item['quantity']}</td>
                            <td>{$item['price']}</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php include 'partials/footer.php'; ?>
</body>
</html>