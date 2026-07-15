<?php
require_once 'includes/config.php';
if (!is_logged_in()) die('Login required.');
$sqls = [
"CREATE TABLE IF NOT EXISTS `grading_system` (
  `id` int NOT NULL AUTO_INCREMENT,
  `teacher_id` int NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `grade_level` varchar(20) NOT NULL,
  `section` varchar(20) NOT NULL,
  `quarter` tinyint NOT NULL DEFAULT 1,
  `written_work_pct` decimal(5,2) NOT NULL DEFAULT 25.00,
  `performance_task_pct` decimal(5,2) NOT NULL DEFAULT 50.00,
  `quarterly_exam_pct` decimal(5,2) NOT NULL DEFAULT 25.00,
  `passing_grade` decimal(5,2) NOT NULL DEFAULT 75.00,
  `school_year` varchar(20) DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_class` (`teacher_id`,`grade_level`,`section`,`subject_name`,`quarter`),
  CONSTRAINT `gs_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
"CREATE TABLE IF NOT EXISTS `activity_log` (
  `id` int NOT NULL AUTO_INCREMENT,
  `grading_system_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `student_id` int NOT NULL,
  `category` enum('Written Work','Performance Task','Quarterly Exam','Attendance') NOT NULL,
  `activity_name` varchar(150) NOT NULL,
  `score` decimal(7,2) DEFAULT NULL,
  `highest_possible_score` decimal(7,2) NOT NULL DEFAULT 100,
  `date_given` date NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_gs` (`grading_system_id`),
  KEY `idx_student` (`student_id`),
  CONSTRAINT `al_gs` FOREIGN KEY (`grading_system_id`) REFERENCES `grading_system` (`id`) ON DELETE CASCADE,
  CONSTRAINT `al_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `al_student` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
];
$results = [];
foreach ($sqls as $sql) {
    $results[] = ['ok' => $conn->query($sql) !== false, 'err' => $conn->error, 'sql' => substr($sql, 0, 60)];
}
if (isset($_GET['delete'])) { @unlink(__FILE__); die('Deleted.'); }
?><!DOCTYPE html><html><head><meta charset="UTF-8"><title>Grading Migration</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body class="p-4"><div class="container" style="max-width:700px">
<h4 class="mb-4">Grading System Migration</h4>
<?php foreach($results as $r): ?>
<div class="alert alert-<?php echo $r['ok']?'success':'danger'; ?> py-2">
<?php echo $r['ok']?'✅ OK':'❌ '.$r['err']; ?><br><small><?php echo htmlspecialchars($r['sql']); ?>...</small>
</div><?php endforeach; ?>
<div class="alert alert-info mt-3">Done! <a href="teacher/gradebook.php" class="alert-link">Go to Gradebook</a></div>
<a href="?delete=1" class="btn btn-danger btn-sm" onclick="return confirm('Delete this file?')">Delete Migration File</a>
</div></body></html>
