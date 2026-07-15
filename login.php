<?php
require_once 'includes/config.php';

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = clean_input($_POST['username']);
    $password = clean_input($_POST['password']);
    
    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password.";
    } else {
        // Check teacher credentials
        $sql = "SELECT id, username, password, first_name, last_name, role, status FROM teachers WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            if ($user['status'] !== 'Active') {
                $error = "Your account is inactive. Please contact the administrator.";
            } elseif (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];
                $_SESSION['full_name'] = $user['first_name'] . ' ' . $user['last_name'];
                $_SESSION['user_role'] = $user['role'];
                
                // Update last login
                $update_sql = "UPDATE teachers SET last_login = NOW() WHERE id = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("i", $user['id']);
                $update_stmt->execute();
                
                // Log activity
                log_activity($user['id'], 'Login', 'User logged in');
                
                // Redirect based on role
                if ($user['role'] === 'Admin') {
                    header("Location: admin/dashboard.php");
                } else {
                    header("Location: teacher/dashboard.php");
                }
                exit;
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Invalid username or password.";
        }
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    if (is_logged_in()) {
        log_activity($_SESSION['user_id'], 'Logout', 'User logged out');
    }
    
    session_destroy();
    header("Location: login.php");
    exit;
}

// Redirect if already logged in
if (is_logged_in()) {
    if (is_admin()) {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: teacher/dashboard.php");
    }
    exit;
}

// Handle password reset request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
    $email = clean_input($_POST['email']);
    
    if (empty($email)) {
        $reset_error = "Please enter your email address.";
    } else {
        // Check if email exists
        $sql = "SELECT id, first_name, last_name FROM teachers WHERE email = ? AND status = 'Active'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Generate reset token
            $token = bin2hex(random_bytes(32));
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            // Save reset token
            $token_sql = "INSERT INTO password_resets (user_id, token, expiry, created_at) VALUES (?, ?, ?, NOW())";
            $token_stmt = $conn->prepare($token_sql);
            $token_stmt->bind_param("iss", $user['id'], $token, $expiry);
            $token_stmt->execute();
            
            // Send reset email (simplified - in production, use proper email service)
            $reset_link = "http://$_SERVER[HTTP_HOST]" . dirname($_SERVER['PHP_SELF']) . "/reset_password.php?token=" . $token;
            
            // For now, just show success message
            $reset_success = "Password reset link has been sent to your email address.";
            
            // Log the password reset request
            log_activity($user['id'], 'Password Reset Request', 'Password reset requested for email: ' . $email);
        } else {
            $reset_error = "Email address not found or account is inactive.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Student Attendance System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: url('uploads/bg.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            backdrop-filter: blur(10px);
            z-index: 0;
        }

        .login-wrapper {
            width: 100%;
            max-width: 500px;
            position: relative;
            z-index: 1;
        }

        .login-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 40px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-header h3 {
            color: #1a202c;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .login-header p {
            color: #718096;
            font-size: 14px;
            margin: 0;
        }

        .school-logo {
            max-width: 64px;
            max-height: 64px;
            margin-bottom: 16px;
            border-radius: 8px;
        }

        .login-body {
            padding: 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 500;
            color: #2d3748;
            font-size: 14px;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 10px 12px;
            font-size: 14px;
            transition: border-color 0.2s;
            background: white;
        }

        .form-control:focus {
            border-color: #3182ce;
            outline: none;
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
        }

        .input-group {
            position: relative;
        }

        .input-group .form-control {
            padding-right: 40px;
        }

        .input-group .btn {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #718096;
            padding: 4px;
            cursor: pointer;
        }

        .input-group .btn:hover {
            color: #2d3748;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
        }

        .form-check-input {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: #3182ce;
        }

        .form-check-label {
            cursor: pointer;
            color: #4a5568;
            font-size: 14px;
        }

        .btn-primary {
            background: #3182ce;
            border: none;
            border-radius: 6px;
            padding: 12px;
            font-size: 14px;
            font-weight: 500;
            color: white;
            transition: background-color 0.2s;
            width: 100%;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: #2c5282;
        }

        .forgot-password {
            text-align: center;
            margin-top: 16px;
        }

        .forgot-password a {
            color: #3182ce;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        .alert {
            border-radius: 6px;
            border: none;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-danger {
            background: #fff5f5;
            color: #c53030;
            border-left: 4px solid #fc8181;
        }

        .alert-success {
            background: #f0fff4;
            color: #22543d;
            border-left: 4px solid #68d391;
        }

        /* Modal styling */
        .modal-content {
            border-radius: 8px;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            border-bottom: 1px solid #e2e8f0;
            padding: 16px 20px;
        }

        .modal-header .modal-title {
            font-weight: 600;
            color: #1a202c;
            font-size: 18px;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-footer {
            border-top: 1px solid #e2e8f0;
            padding: 16px 20px;
        }

        .btn-secondary {
            background: #e2e8f0;
            border: none;
            border-radius: 6px;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 500;
            color: #4a5568;
            cursor: pointer;
        }

        .btn-secondary:hover {
            background: #cbd5e0;
        }

        /* Responsive design */
        @media (max-width: 480px) {
            .login-card {
                padding: 24px;
            }

            .login-header h3 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <!-- Login Header -->
            <div class="login-header">
                <?php if (file_exists('uploads/LOGO.jpg')): ?>
                    <img src="uploads/LOGO.jpg" alt="School Logo" class="school-logo">
                <?php endif; ?>
                <h3>Student Attendance System</h3>
                <p>Sign in to your account</p>
            </div>
            
            <!-- Login Form -->
            <div class="login-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <form method="POST" id="loginForm">
                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required autofocus>
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                            <button type="button" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">
                            Remember me
                        </label>
                    </div>
                    
                    <button type="submit" name="login" class="btn-primary">
                        Sign In
                    </button>
                </form>
                
                <div class="parent-portal">
                    <a href="parent/login.php">
                        Parent Portal Login
                    </a>
                </div>
                
    <!-- Reset Password Modal -->
    <div class="modal fade" id="resetPasswordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reset Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <?php if (isset($reset_success)): ?>
                            <div class="alert alert-success">
                                <?php echo $reset_success; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($reset_error)): ?>
                            <div class="alert alert-danger">
                                <?php echo $reset_error; ?>
                            </div>
                        <?php endif; ?>
                        
                        <p style="color: #4a5568; font-size: 14px; margin-bottom: 16px;">Enter your email address and we'll send you a link to reset your password.</p>
                        
                        <div class="form-group">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="reset_password" class="btn-primary" style="width: auto;">
                            Send Reset Link
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
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
        
        // Form validation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;
            
            if (username.length < 3) {
                e.preventDefault();
                alert('Username must be at least 3 characters long.');
                return;
            }
            
            if (password.length < 6) {
                e.preventDefault();
                alert('Password must be at least 6 characters long.');
                return;
            }
        });
        
        // Auto-focus on username field
        document.getElementById('username').focus();
        
        // Remember me functionality
        if (localStorage.getItem('rememberMe') === 'true') {
            document.getElementById('rememberMe').checked = true;
            document.getElementById('username').value = localStorage.getItem('savedUsername') || '';
        }
        
        document.getElementById('rememberMe').addEventListener('change', function() {
            if (this.checked) {
                localStorage.setItem('rememberMe', 'true');
                localStorage.setItem('savedUsername', document.getElementById('username').value);
            } else {
                localStorage.removeItem('rememberMe');
                localStorage.removeItem('savedUsername');
            }
        });
        
        // Save username when typing if remember me is checked
        document.getElementById('username').addEventListener('input', function() {
            if (document.getElementById('rememberMe').checked) {
                localStorage.setItem('savedUsername', this.value);
            }
        });
    </script>
</body>
</html>
