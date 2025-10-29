<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Inventory Item</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <?php include '../partials/header.php'; ?>
    
    <div class="container">
        <h2>Edit Inventory Item</h2>
        <form action="/src/controllers/InventoryController.php?action=update&id=<?php echo htmlspecialchars($item['id']); ?>" method="POST">
            <label for="type">Type:</label>
            <select name="type" id="type" required>
                <option value="pig" <?php echo ($item['type'] == 'pig') ? 'selected' : ''; ?>>Pig</option>
                <option value="chicken" <?php echo ($item['type'] == 'chicken') ? 'selected' : ''; ?>>Chicken</option>
                <option value="beef" <?php echo ($item['type'] == 'beef') ? 'selected' : ''; ?>>Beef</option>
            </select>

            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" value="<?php echo htmlspecialchars($item['quantity']); ?>" required>

            <label for="price">Price:</label>
            <input type="text" name="price" id="price" value="<?php echo htmlspecialchars($item['price']); ?>" required>

            <button type="submit">Update Item</button>
        </form>
    </div>

    <?php include '../partials/footer.php'; ?>
</body>
</html>