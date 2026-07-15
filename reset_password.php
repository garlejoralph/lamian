<?php
require_once '../includes/config.php';

// Check if user is logged in and has admin rights
redirect_if_not_admin();

// Handle password reset
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
    $token = clean_input($_GET['token']);
    $new_password = clean_input($_POST['new_password']);
    $confirm_password = clean_input($_POST['confirm_password']);
    
    if (empty($new_password) || empty($confirm_password)) {
        $error = "Please enter both password fields.";
    } elseif ($new_password !== $confirm_password) {
        $error = "Passwords do not match.";
    } elseif (strlen($new_password) < 6) {
        $error = "Password must be at least 6 characters long.";
    } else {
        // Validate token
        $token_sql = "SELECT pr.user_id, pr.expiry FROM password_resets pr WHERE pr.token = ? AND pr.expiry > NOW() AND pr.used = 0";
        $token_stmt = $conn->prepare($token_sql);
        $token_stmt->bind_param("s", $token);
        $token_stmt->execute();
        $token_result = $token_stmt->get_result();
        
        if ($token_result->num_rows === 1) {
            $reset_data = $token_result->fetch_assoc();
            $user_id = $reset_data['user_id'];
            
            // Hash new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            
            // Update password
            $update_sql = "UPDATE teachers SET password = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("si", $hashed_password, $user_id);
            
            if ($update_stmt->execute()) {
                // Mark token as used
                $mark_used_sql = "UPDATE password_resets SET used = 1, used_at = NOW() WHERE token = ?";
                $mark_used_stmt = $conn->prepare($mark_used_sql);
                $mark_used_stmt->bind_param("s", $token);
                $mark_used_stmt->execute();
                
                // Log activity
                log_activity($user_id, 'Password Reset', 'Password was reset successfully');
                
                $success = "Password has been reset successfully. You can now login with your new password.";
                
                // Redirect to login after 3 seconds
                header("refresh:3;url=login.php");
            } else {
                $error = "Error updating password. Please try again.";
            }
        } else {
            $error = "Invalid or expired reset token.";
        }
    }
}

// Validate token
$token = clean_input($_GET['token'] ?? '');
if (empty($token)) {
    header("Location: login.php");
    exit;
}

$token_sql = "SELECT pr.user_id, pr.expiry, t.first_name, t.last_name FROM password_resets pr 
              JOIN teachers t ON pr.user_id = t.id 
              WHERE pr.token = ? AND pr.expiry > NOW() AND pr.used = 0";
$token_stmt = $conn->prepare($token_sql);
$token_stmt->bind_param("s", $token);
$token_stmt->execute();
$token_result = $token_stmt->get_result();

if ($token_result->num_rows !== 1) {
    $token_error = "This password reset link is invalid or has expired. Please request a new one.";
    $show_form = false;
} else {
    $user_data = $token_result->fetch_assoc();
    $show_form = true;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Student Attendance System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .reset-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        .reset-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 20px 20px 0 0;
        }
    </style>
</head>
<body>
    <div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
        <div class="row w-100">
            <div class="col-lg-5 mx-auto">
                <div class="reset-container">
                    <!-- Header -->
                    <div class="reset-header p-4 text-center">
                        <h3 class="mb-0">
                            <i class="fas fa-key"></i> 
                            Reset Password
                        </h3>
                        <p class="mb-0 mt-2">Set your new password</p>
                    </div>
                    
                    <!-- Content -->
                    <div class="p-4">
                        <?php if (isset($success)): ?>
                            <div class="alert alert-success text-center">
                                <i class="fas fa-check-circle fa-3x mb-3"></i>
                                <h5>Password Reset Successful!</h5>
                                <p><?php echo $success; ?></p>
                                <p class="mb-0">Redirecting to login page...</p>
                            </div>
                        <?php elseif (isset($token_error)): ?>
                            <div class="alert alert-danger text-center">
                                <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                <h5>Invalid Reset Link</h5>
                                <p><?php echo $token_error; ?></p>
                                <a href="login.php" class="btn btn-primary mt-3">
                                    <i class="fas fa-arrow-left"></i> Back to Login
                                </a>
                            </div>
                        <?php else: ?>
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>
                            
                            <div class="text-center mb-4">
                                <p>Hello <strong><?php echo htmlspecialchars($user_data['first_name'] . ' ' . $user_data['last_name']); ?></strong>,</p>
                                <p>Please enter your new password below.</p>
                            </div>
                            
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">
                                        <i class="fas fa-lock"></i> New Password
                                    </label>
                                    <div class="input-group">
                                        <input type="password" class="form-control form-control-lg" id="new_password" name="new_password" required minlength="6">
                                        <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <small class="form-text text-muted">Password must be at least 6 characters long.</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">
                                        <i class="fas fa-lock"></i> Confirm New Password
                                    </label>
                                    <div class="input-group">
                                        <input type="password" class="form-control form-control-lg" id="confirm_password" name="confirm_password" required minlength="6">
                                        <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Password Strength Indicator -->
                                <div class="mb-3">
                                    <div class="progress" style="height: 5px;">
                                        <div class="progress-bar" id="passwordStrength" role="progressbar" style="width: 0%"></div>
                                    </div>
                                    <small class="form-text" id="strengthText">Enter a password to see strength</small>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <button type="submit" name="reset_password" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save"></i> Reset Password
                                    </button>
                                </div>
                            </form>
                            
                            <div class="text-center mt-3">
                                <a href="login.php" class="text-muted">
                                    <i class="fas fa-arrow-left"></i> Back to Login
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        document.getElementById('toggleNewPassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('new_password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
        
        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('confirm_password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
        
        // Password strength checker
        function checkPasswordStrength(password) {
            let strength = 0;
            let strengthText = '';
            let strengthClass = '';
            
            if (password.length >= 6) strength += 25;
            if (password.length >= 10) strength += 25;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength += 25;
            if (/[0-9]/.test(password)) strength += 12.5;
            if (/[^a-zA-Z0-9]/.test(password)) strength += 12.5;
            
            if (strength <= 25) {
                strengthText = 'Weak';
                strengthClass = 'bg-danger';
            } else if (strength <= 50) {
                strengthText = 'Fair';
                strengthClass = 'bg-warning';
            } else if (strength <= 75) {
                strengthText = 'Good';
                strengthClass = 'bg-info';
            } else {
                strengthText = 'Strong';
                strengthClass = 'bg-success';
            }
            
            return { strength, strengthText, strengthClass };
        }
        
        document.getElementById('new_password').addEventListener('input', function() {
            const result = checkPasswordStrength(this.value);
            const progressBar = document.getElementById('passwordStrength');
            const strengthText = document.getElementById('strengthText');
            
            progressBar.style.width = result.strength + '%';
            progressBar.className = 'progress-bar ' + result.strengthClass;
            strengthText.textContent = 'Password strength: ' + result.strengthText;
            strengthText.className = 'form-text text-' + (result.strengthClass.replace('bg-', ''));
        });
        
        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            
            if (newPassword !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match. Please make sure both passwords are the same.');
                return;
            }
            
            if (newPassword.length < 6) {
                e.preventDefault();
                alert('Password must be at least 6 characters long.');
                return;
            }
        });
        
        // Auto-focus on new password field
        document.getElementById('new_password').focus();
    </script>
</body>
</html>
