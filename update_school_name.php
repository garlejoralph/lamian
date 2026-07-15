<?php
// Update school name and add logo column to school_settings
// Run this file in browser: http://localhost/student_attendance/update_school_name.php

$conn = new mysqli("localhost", "root", "", "student_attendance");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add school_logo column if it doesn't exist
$add_logo_sql = "ALTER TABLE school_settings ADD COLUMN IF NOT EXISTS school_logo varchar(255) DEFAULT NULL AFTER school_email";
$conn->query($add_logo_sql);

// Add school_principal column if it doesn't exist
$add_principal_sql = "ALTER TABLE school_settings ADD COLUMN IF NOT EXISTS school_principal varchar(200) DEFAULT NULL AFTER school_logo";
$conn->query($add_principal_sql);

// Update school name to Lamian National High School
$update_name_sql = "UPDATE school_settings SET school_name = 'Lamian National High School' WHERE school_name = 'Sample School' OR school_name = 'School Name' OR school_name IS NULL";
$conn->query($update_name_sql);

// Update SMS templates to use new school name
$update_templates_sql = "UPDATE school_settings SET 
    sms_template_present = REPLACE(sms_template_present, 'Sample School', 'Lamian National High School'),
    sms_template_late = REPLACE(sms_template_late, 'Sample School', 'Lamian National High School'),
    sms_template_absent = REPLACE(sms_template_absent, 'Sample School', 'Lamian National High School'),
    sms_template_early_dismissal = REPLACE(sms_template_early_dismissal, 'Sample School', 'Lamian National High School'),
    sms_template_present = REPLACE(sms_template_present, '[School Name]', 'Lamian National High School'),
    sms_template_late = REPLACE(sms_template_late, '[School Name]', 'Lamian National High School'),
    sms_template_absent = REPLACE(sms_template_absent, '[School Name]', 'Lamian National High School'),
    sms_template_early_dismissal = REPLACE(sms_template_early_dismissal, '[School Name]', 'Lamian National High School')";
$conn->query($update_templates_sql);

// Verify the update
$result = $conn->query("SELECT school_name, school_address, school_logo, school_principal FROM school_settings LIMIT 1");
if ($result) {
    $row = $result->fetch_assoc();
    echo "<h3>School Settings Updated Successfully!</h3>";
    echo "<p><strong>School Name:</strong> " . htmlspecialchars($row['school_name']) . "</p>";
    echo "<p><strong>School Address:</strong> " . htmlspecialchars($row['school_address']) . "</p>";
    echo "<p><strong>School Logo:</strong> " . ($row['school_logo'] ? 'Path set' : 'Not set') . "</p>";
    echo "<p><strong>School Principal:</strong> " . ($row['school_principal'] ? htmlspecialchars($row['school_principal']) : 'Not set') . "</p>";
    echo "<p><a href='admin/settings.php'>Go to Settings Page</a></p>";
} else {
    echo "<p>No school settings found. Please check the database.</p>";
}

$conn->close();
?>
