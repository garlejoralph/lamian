<?php
// Quick Database Setup Script
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Student Attendance System - Database Setup</h2>";

// Step 1: Create database if it doesn't exist
$conn = new mysqli("localhost", "root", "");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS student_attendance CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
if ($conn->query($sql)) {
    echo "<p style='color: green;'>✅ Database 'student_attendance' created/verified</p>";
} else {
    echo "<p style='color: red;'>❌ Database creation failed: " . $conn->error . "</p>";
}

// Select the database
$conn->select_db("student_attendance");

// Step 2: Import the schema
echo "<p>Importing database schema...</p>";

// Read and execute the schema file
$schema_file = __DIR__ . '/database/student_attendance.sql';
if (file_exists($schema_file)) {
    $schema = file_get_contents($schema_file);
    
    // Remove the USE database statement and other problematic parts
    $schema = str_replace("USE `student_attendance`;", "", $schema);
    
    // Split into individual statements
    $statements = array_filter(array_map('trim', explode(';', $schema)));
    
    foreach ($statements as $statement) {
        if (!empty($statement)) {
            try {
                if (!$conn->query($statement)) {
                    echo "<p style='color: orange;'>⚠️ Warning: " . $conn->error . "</p>";
                }
            } catch (Exception $e) {
                echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
            }
        }
    }
    echo "<p style='color: green;'>✅ Database schema imported successfully</p>";
} else {
    echo "<p style='color: red;'>❌ Schema file not found: $schema_file</p>";
}

// Step 3: Verify admin user creation
echo "<p>Verifying admin user...</p>";

$result = $conn->query("SELECT * FROM teachers WHERE username = 'admin'");
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo "<p style='color: green;'>✅ Admin user exists</p>";
    echo "<ul>";
    echo "<li>Username: " . $user['username'] . "</li>";
    echo "<li>Name: " . $user['first_name'] . " " . $user['last_name'] . "</li>";
    echo "<li>Role: " . $user['role'] . "</li>";
    echo "<li>Status: " . $user['status'] . "</li>";
    echo "</ul>";
    
    // Test login
    if (password_verify('admin123', $user['password'])) {
        echo "<p style='color: green;'>✅ Admin password verification: SUCCESS</p>";
    } else {
        echo "<p style='color: red;'>❌ Admin password verification: FAILED</p>";
        
        // Update the password
        $new_hash = password_hash('admin123', PASSWORD_DEFAULT);
        $update_sql = "UPDATE teachers SET password = ? WHERE username = 'admin'";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("s", $new_hash);
        if ($update_stmt->execute()) {
            echo "<p style='color: green;'>✅ Admin password updated successfully</p>";
        }
    }
} else {
    echo "<p style='color: red;'>❌ Admin user not found, creating...</p>";
    
    // Create admin user
    $admin_hash = password_hash('admin123', PASSWORD_DEFAULT);
    $insert_sql = "INSERT INTO teachers (first_name, last_name, email, employee_id, position, username, password, role) VALUES ('System', 'Administrator', 'admin@school.edu', 'ADMIN001', 'System Administrator', 'admin', ?, 'Admin')";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("s", $admin_hash);
    
    if ($insert_stmt->execute()) {
        echo "<p style='color: green;'>✅ Admin user created successfully</p>";
    } else {
        echo "<p style='color: red;'>❌ Admin user creation failed: " . $conn->error . "</p>";
    }
}

// Step 4: Test the login process
echo "<p>Testing login process...</p>";

// Simulate login
$test_username = 'admin';
$test_password = 'admin123';

$sql = "SELECT id, username, password, first_name, last_name, role, status FROM teachers WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $test_username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    
    if ($user['status'] === 'Active' && password_verify($test_password, $user['password'])) {
        echo "<p style='color: green;'>✅ Login test: SUCCESS</p>";
        echo "<p>You can now login with:</p>";
        echo "<ul>";
        echo "<li><strong>Username:</strong> admin</li>";
        echo "<li><strong>Password:</strong> admin123</li>";
        echo "</ul>";
    } else {
        echo "<p style='color: red;'>❌ Login test failed</p>";
    }
} else {
    echo "<p style='color: red;'>❌ Admin user not found after setup</p>";
}

$conn->close();

echo "<hr>";
echo "<p><a href='index.php'>👉 Go to Login Page</a></p>";
echo "<p><a href='test_db.php'>🔧 Run Database Test</a></p>";
?>
