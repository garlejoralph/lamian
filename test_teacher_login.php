<?php
require_once 'includes/config.php';

echo "<h2>Teacher Login Test</h2>";

// Test teacher login
echo "<h3>Testing Teacher Account:</h3>";

$sql = "SELECT * FROM teachers WHERE username = 'teacher'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$teacher = $stmt->get_result()->fetch_assoc();

if ($teacher) {
    echo "<p><strong>✅ Teacher Found:</strong> " . $teacher['first_name'] . " " . $teacher['last_name'] . "</p>";
    echo "<p><strong>Username:</strong> " . $teacher['username'] . "</p>";
    echo "<p><strong>Role:</strong> " . $teacher['role'] . "</p>";
    echo "<p><strong>Assigned Classes:</strong> " . $teacher['assigned_classes'] . "</p>";
    echo "<p><strong>Status:</strong> " . $teacher['status'] . "</p>";
    
    // Test password verification
    if (password_verify('teacher123', $teacher['password'])) {
        echo "<p style='color: green;'><strong>✅ Password verification: SUCCESS</strong></p>";
        
        // Test session creation
        $_SESSION['user_id'] = $teacher['id'];
        $_SESSION['username'] = $teacher['username'];
        $_SESSION['first_name'] = $teacher['first_name'];
        $_SESSION['last_name'] = $teacher['last_name'];
        $_SESSION['full_name'] = $teacher['first_name'] . ' ' . $teacher['last_name'];
        $_SESSION['user_role'] = $teacher['role'];
        
        echo "<p style='color: green;'><strong>✅ Session created successfully</strong></p>";
        echo "<p><strong>Session Data:</strong></p>";
        echo "<ul>";
        echo "<li>User ID: " . $_SESSION['user_id'] . "</li>";
        echo "<li>Username: " . $_SESSION['username'] . "</li>";
        echo "<li>Full Name: " . $_SESSION['full_name'] . "</li>";
        echo "<li>Role: " . $_SESSION['user_role'] . "</li>";
        echo "</ul>";
        
        // Test role check
        if (is_teacher()) {
            echo "<p style='color: green;'><strong>✅ is_teacher() function: WORKING</strong></p>";
        }
        
        // Test redirect paths
        echo "<p><strong>Dashboard URL:</strong> teacher/dashboard.php</p>";
        echo "<p><strong>Students URL:</strong> teacher/students.php</p>";
        
        // Clean up session for real use
        session_destroy();
        
    } else {
        echo "<p style='color: red;'><strong>❌ Password verification: FAILED</strong></p>";
    }
} else {
    echo "<p style='color: red;'><strong>❌ Teacher account not found</strong></p>";
}

$conn->close();
?>

<p><a href="index.php">🔗 Go to Login Page</a></p>
<p><a href="create_teacher.php">👤 Create Teacher Account</a></p>
