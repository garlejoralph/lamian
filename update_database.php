<?php
// Database update script to fix missing columns
require_once 'includes/config.php';

echo "<h1>🔧 Database Update Script</h1>";

$updates = [];

// Check and add assigned_classes column to teachers table
$check_column_sql = "SHOW COLUMNS FROM teachers LIKE 'assigned_classes'";
$result = $conn->query($check_column_sql);

if ($result->num_rows == 0) {
    $updates[] = "ALTER TABLE teachers ADD COLUMN assigned_classes TEXT AFTER position";
    echo "<p style='color: orange;'>⚠️ Adding assigned_classes column to teachers table...</p>";
} else {
    echo "<p style='color: green;'>✅ assigned_classes column exists in teachers table</p>";
}

// Check and add role column to teachers table
$check_role_sql = "SHOW COLUMNS FROM teachers LIKE 'role'";
$result = $conn->query($check_role_sql);

if ($result->num_rows == 0) {
    $updates[] = "ALTER TABLE teachers ADD COLUMN role ENUM('Admin','Teacher','Staff') DEFAULT 'Teacher' AFTER password";
    echo "<p style='color: orange;'>⚠️ Adding role column to teachers table...</p>";
} else {
    echo "<p style='color: green;'>✅ role column exists in teachers table</p>";
}

// Check and add status column to teachers table
$check_status_sql = "SHOW COLUMNS FROM teachers LIKE 'status'";
$result = $conn->query($check_status_sql);

if ($result->num_rows == 0) {
    $updates[] = "ALTER TABLE teachers ADD COLUMN status ENUM('Active','Inactive') DEFAULT 'Active' AFTER role";
    echo "<p style='color: orange;'>⚠️ Adding status column to teachers table...</p>";
} else {
    echo "<p style='color: green;'>✅ status column exists in teachers table</p>";
}

// Check and add teacher_id column to attendance table
$check_teacher_id_sql = "SHOW COLUMNS FROM attendance LIKE 'teacher_id'";
$result = $conn->query($check_teacher_id_sql);

if ($result->num_rows == 0) {
    $updates[] = "ALTER TABLE attendance ADD COLUMN teacher_id INT AFTER notes";
    echo "<p style='color: orange;'>⚠️ Adding teacher_id column to attendance table...</p>";
} else {
    echo "<p style='color: green;'>✅ teacher_id column exists in attendance table</p>";
}

// Check and add scan_method column to attendance table
$check_scan_method_sql = "SHOW COLUMNS FROM attendance LIKE 'scan_method'";
$result = $conn->query($check_scan_method_sql);

if ($result->num_rows == 0) {
    $updates[] = "ALTER TABLE attendance ADD COLUMN scan_method ENUM('QR_Code','Manual','RFID','Barcode') DEFAULT 'QR_Code' AFTER status";
    echo "<p style='color: orange;'>⚠️ Adding scan_method column to attendance table...</p>";
} else {
    echo "<p style='color: green;'>✅ scan_method column exists in attendance table</p>";
}

// Check and add late_minutes column to attendance table
$check_late_minutes_sql = "SHOW COLUMNS FROM attendance LIKE 'late_minutes'";
$result = $conn->query($check_late_minutes_sql);

if ($result->num_rows == 0) {
    $updates[] = "ALTER TABLE attendance ADD COLUMN late_minutes INT DEFAULT 0 AFTER teacher_id";
    echo "<p style='color: orange;'>⚠️ Adding late_minutes column to attendance table...</p>";
} else {
    echo "<p style='color: green;'>✅ late_minutes column exists in attendance table</p>";
}

// Execute updates
if (!empty($updates)) {
    echo "<h3>🔨 Applying Updates:</h3>";
    foreach ($updates as $update) {
        echo "<p><strong>Executing:</strong> " . htmlspecialchars($update) . "</p>";
        if ($conn->query($update)) {
            echo "<p style='color: green;'>✅ Success!</p>";
        } else {
            echo "<p style='color: red;'>❌ Error: " . $conn->error . "</p>";
        }
    }
} else {
    echo "<p style='color: green;'>✅ No updates needed - database is up to date!</p>";
}

// Verify tables exist
echo "<h3>🔍 Verifying Tables:</h3>";
$tables = ['students', 'teachers', 'attendance', 'activity_logs', 'school_settings'];

foreach ($tables as $table) {
    $check_table_sql = "SHOW TABLES LIKE '$table'";
    $result = $conn->query($check_table_sql);
    
    if ($result->num_rows > 0) {
        echo "<p style='color: green;'>✅ Table '$table' exists</p>";
    } else {
        echo "<p style='color: red;'>❌ Table '$table' missing</p>";
    }
}

// Check if admin user exists
echo "<h3>👤 Checking Admin User:</h3>";
$admin_check_sql = "SELECT * FROM users WHERE username = 'admin' OR (SELECT username FROM teachers WHERE username = 'admin')";
$admin_result = $conn->query($admin_check_sql);

if ($admin_result && $admin_result->num_rows > 0) {
    echo "<p style='color: green;'>✅ Admin user exists</p>";
} else {
    echo "<p style='color: orange;'>⚠️ Admin user not found - you may need to create one</p>";
}

echo "<hr>";
echo "<div style='background: #d4edda; color: #155724; padding: 20px; border-radius: 10px;'>";
echo "<h3>✅ Database Update Complete!</h3>";
echo "<p><strong>Next Steps:</strong></p>";
echo "<ul>";
echo "<li><a href='index.php' style='display: inline-block; padding: 10px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; margin: 5px;'>🏠 Login Page</a></li>";
echo "<li><a href='admin/dashboard.php' style='display: inline-block; padding: 10px; background: #28a745; color: white; text-decoration: none; border-radius: 5px; margin: 5px;'>👨 Admin Dashboard</a></li>";
echo "<li><a href='teacher/dashboard.php' style='display: inline-block; padding: 10px; background: #17a2b8; color: white; text-decoration: none; border-radius: 5px; margin: 5px;'>👩 Teacher Dashboard</a></li>";
echo "</ul>";
echo "<p><strong>Default Credentials:</strong></p>";
echo "<ul>";
echo "<li>Admin: admin/admin123</li>";
echo "<li>Teacher: teacher/teacher123</li>";
echo "</ul>";
echo "</div>";

$conn->close();
?>
