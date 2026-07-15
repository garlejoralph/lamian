<?php
require_once 'includes/config.php';

echo "Running announcements table migration...\n";

$sql_file = 'database/announcements.sql';

if (file_exists($sql_file)) {
    $sql = file_get_contents($sql_file);
    
    // Split by semicolon to handle multiple statements
    $statements = explode(';', $sql);
    
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement)) {
            try {
                $conn->query($statement);
                echo "✓ Executed: " . substr($statement, 0, 50) . "...\n";
            } catch (Exception $e) {
                echo "✗ Error: " . $e->getMessage() . "\n";
            }
        }
    }
    
    echo "\nMigration completed successfully!\n";
} else {
    echo "SQL file not found: $sql_file\n";
}
?>
