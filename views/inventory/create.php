<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Inventory Item</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <?php include '../partials/header.php'; ?>
    <div class="container">
        <h2>Create New Inventory Item</h2>
        <form action="/src/controllers/InventoryController.php?action=create" method="POST">
            <label for="type">Type:</label>
            <select name="type" id="type" required>
                <option value="pig">Pig</option>
                <option value="chicken">Chicken</option>
                <option value="beef">Beef</option>
            </select>
            <br>
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" required>
            <br>
            <label for="price">Price:</label>
            <input type="text" name="price" id="price" required>
            <br>
            <input type="submit" value="Create Item">
        </form>
    </div>
    <?php include '../partials/footer.php'; ?>
</body>
</html>