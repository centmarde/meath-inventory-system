<?php
$databaseFile = __DIR__ . '/../../database/inventory.db';
try {
    $db = new PDO('sqlite:' . $databaseFile);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $createUsersTable = "CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL
    );";

    $createInventoryTable = "CREATE TABLE IF NOT EXISTS inventory (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        type TEXT NOT NULL,
        quantity INTEGER NOT NULL,
        price REAL NOT NULL
    );";

    $db->exec($createUsersTable);
    $db->exec($createInventoryTable);

    // Insert default admin user (vulnerable: plain text password)
    $db->exec("INSERT OR IGNORE INTO users (username, password) VALUES ('admin', 'admin123')");

    // Insert sample inventory data
    $db->exec("INSERT OR IGNORE INTO inventory (type, quantity, price) VALUES ('Pork', 100, 5.99)");
    $db->exec("INSERT OR IGNORE INTO inventory (type, quantity, price) VALUES ('Chicken', 150, 3.99)");
    $db->exec("INSERT OR IGNORE INTO inventory (type, quantity, price) VALUES ('Beef', 75, 8.99)");

    echo "Database initialized successfully!\n";
    echo "Tables created and sample data inserted.\n";
    echo "Default login - Username: admin, Password: admin123\n";

} catch (PDOException $e) {
    echo "Database initialization failed: " . $e->getMessage();
}
?>