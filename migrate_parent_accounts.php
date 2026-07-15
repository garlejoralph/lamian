<?php
require_once 'includes/config.php';

echo "<h2>Parent Accounts Migration</h2>";

$sql_file = 'database/parent_accounts.sql';

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
        
        // Create parent accounts for existing students
        echo "<h3>Creating parent accounts for existing students...</h3>";
        
        $sql = "SELECT id, first_name, last_name, lrn FROM students WHERE lrn IS NOT NULL AND lrn != ''";
        $result = $conn->query($sql);
        
        $created = 0;
        $skipped = 0;
        
        while ($student = $result->fetch_assoc()) {
            $username = strtolower($student['last_name'] . $student['first_name']);
            $password = $student['lrn'];
            $full_name = $student['last_name'] . ', ' . $student['first_name'];
            
            // Check if parent account already exists
            $check_sql = "SELECT id FROM parent_accounts WHERE student_id = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bind_param("i", $student['id']);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            
            if ($check_result->num_rows === 0) {
                // Create parent account
                $insert_sql = "INSERT INTO parent_accounts (student_id, username, password, full_name) VALUES (?, ?, ?, ?)";
                $insert_stmt = $conn->prepare($insert_sql);
                $insert_stmt->bind_param("isss", $student['id'], $username, $password, $full_name);
                
                if ($insert_stmt->execute()) {
                    $created++;
                    echo "<p style='color: green;'>✓ Created parent account for: $full_name</p>";
                }
            } else {
                $skipped++;
            }
        }
        
        echo "<h3>Summary:</h3>";
        echo "<p style='color: green;'>Created: $created parent accounts</p>";
        echo "<p style='color: orange;'>Skipped: $skipped (already exists)</p>";
        
        echo "<p><a href='parent/login.php'>Go to Parent Login</a></p>";
    } else {
        echo "<h3 style='color: red;'>Migration completed with errors.</h3>";
    }
} else {
    echo "<p style='color: red;'>SQL file not found: $sql_file</p>";
}
?>
