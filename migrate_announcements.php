<?php
require_once 'includes/config.php';

echo "<h2>Announcements Table Migration</h2>";

$sql_file = 'database/announcements.sql';

if (file_exists($sql_file)) {
    $sql = file_get_contents($sql_file);
    
    // Split by semicolon to handle multiple statements
    $statements = explode(';', $sql);
    
    $success = true;
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement)) {
            try {
                $conn->query($statement);
                echo "<p style='color: green;'>✓ Executed: " . htmlspecialchars(substr($statement, 0, 50)) . "...</p>";
            } catch (Exception $e) {
                echo "<p style='color: red;'>✗ Error: " . htmlspecialchars($e->getMessage()) . "</p>";
                $success = false;
            }
        }
    }
    
    if ($success) {
        echo "<h3 style='color: green;'>Migration completed successfully!</h3>";
        echo "<p><a href='admin/announcements.php'>Go to Announcements Page</a></p>";
    } else {
        echo "<h3 style='color: red;'>Migration completed with errors.</h3>";
    }
} else {
    echo "<p style='color: red;'>SQL file not found: $sql_file</p>";
}
?>
