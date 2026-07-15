<?php
// One-time migration runner — delete this file after running
require_once 'includes/config.php';

if (!is_admin()) {
    die('<p style="color:red;font-family:sans-serif;">Admin access required.</p>');
}

$queries = [
    "ALTER TABLE `students` ADD COLUMN IF NOT EXISTS `lrn` varchar(12) DEFAULT NULL COMMENT 'Learner Reference Number' AFTER `student_id_number`",
    "ALTER TABLE `students` ADD COLUMN IF NOT EXISTS `extension_name` varchar(10) DEFAULT NULL COMMENT 'Jr., Sr., II, III, IV' AFTER `gender`",
    "ALTER TABLE `students` ADD COLUMN IF NOT EXISTS `track` varchar(50) DEFAULT NULL COMMENT 'Academic|TVL|Arts and Design|Sports' AFTER `section`",
    "ALTER TABLE `students` ADD COLUMN IF NOT EXISTS `strand` varchar(80) DEFAULT NULL COMMENT 'STEM, HUMSS, ICT, AFA...' AFTER `track`",
];

$results = [];
foreach ($queries as $sql) {
    if ($conn->query($sql)) {
        $results[] = ['ok' => true,  'sql' => $sql];
    } else {
        $results[] = ['ok' => false, 'sql' => $sql, 'err' => $conn->error];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Database Migration</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container" style="max-width:700px;">
    <h4 class="mb-4"><i class="fas fa-database me-2"></i>Database Migration — Student Fields</h4>
    <?php foreach ($results as $r): ?>
    <div class="alert alert-<?php echo $r['ok'] ? 'success' : 'danger'; ?> py-2">
        <?php if ($r['ok']): ?>
            <i class="fas fa-check-circle me-1"></i> <strong>OK</strong>
        <?php else: ?>
            <i class="fas fa-times-circle me-1"></i> <strong>Error:</strong> <?php echo htmlspecialchars($r['err']); ?>
        <?php endif; ?>
        <br><small class="text-muted font-monospace"><?php echo htmlspecialchars(substr($r['sql'], 0, 80)).'...'; ?></small>
    </div>
    <?php endforeach; ?>
    <div class="alert alert-info mt-3">
        <strong>Done!</strong> Please <a href="admin/students.php" class="alert-link">go to Students</a> to verify,
        then <strong>delete this file</strong> (<code>run_migration.php</code>) from your server.
    </div>
    <a href="admin/students.php" class="btn btn-primary me-2">Go to Students</a>
    <a href="#" onclick="if(confirm('Delete this migration file?')) fetch('?delete=1').then(()=>location.reload())" class="btn btn-danger">Delete This File</a>
</div>
<?php
// Self-delete
if (isset($_GET['delete'])) {
    @unlink(__FILE__);
    echo '<script>alert("File deleted.");window.location="admin/students.php";</script>';
}
?>
</body>
</html>
