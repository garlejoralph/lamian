<?php
require_once 'includes/config.php';

// If already logged in, redirect to appropriate dashboard
if (is_logged_in()) {
    if (is_admin()) {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: teacher/dashboard.php");
    }
    exit;
}

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
            
            // For demo purposes, show the reset link
            $reset_link = "http://$_SERVER[HTTP_HOST]" . dirname($_SERVER['PHP_SELF']) . "/reset_password.php?token=" . $token;
            $reset_success = "Password reset link generated: <a href='$reset_link' target='_blank'>$reset_link</a>";
            
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
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 20px 20px 0 0;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        }
        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin: 0 auto 1rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
        <div class="row w-100">
            <div class="col-lg-6 mx-auto">
                <div class="login-container">
                    <!-- Login Header -->
                    <div class="login-header p-4 text-center">
                        <h3 class="mb-0">
                            <i class="fas fa-graduation-cap"></i> 
                            Student Attendance System
                        </h3>
                        <p class="mb-0 mt-2">Please sign in to continue</p>
                    </div>
                    
                    <!-- Login Form -->
                    <div class="p-4">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" id="loginForm">
                            <div class="mb-3">
                                <label for="username" class="form-label">
                                    <i class="fas fa-user"></i> Username
                                </label>
                                <input type="text" class="form-control form-control-lg" id="username" name="username" required autofocus>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock"></i> Password
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control form-control-lg" id="password" name="password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">
                                    Remember me
                                </label>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" name="login" class="btn btn-primary btn-lg">
                                    <i class="fas fa-sign-in-alt"></i> Sign In
                                </button>
                            </div>
                        </form>
                        
                        <div class="text-center mt-3">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#resetPasswordModal">
                                <i class="fas fa-key"></i> Forgot Password?
                            </a>
                        </div>
                        
                        <!-- System Info -->
                        <div class="mt-4 p-3 bg-light rounded">
                            <h6 class="text-center mb-3">System Features</h6>
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="feature-icon">
                                        <i class="fas fa-qrcode"></i>
                                    </div>
                                    <small>QR Code Scanning</small>
                                </div>
                                <div class="col-4">
                                    <div class="feature-icon">
                                        <i class="fas fa-sms"></i>
                                    </div>
                                    <small>SMS Notifications</small>
                                </div>
                                <div class="col-4">
                                    <div class="feature-icon">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                    <small>Real-time Reports</small>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Demo Credentials -->
                        <div class="mt-3 p-3 bg-info text-white rounded">
                            <h6 class="mb-2"><i class="fas fa-info-circle"></i> Demo Credentials</h6>
                            <div class="row">
                                <div class="col-6">
                                    <strong>Admin:</strong><br>
                                    Username: <code>admin</code><br>
                                    Password: <code>admin123</code>
                                </div>
                                <div class="col-6">
                                    <strong>Teacher:</strong><br>
                                    Username: <code>teacher</code><br>
                                    Password: <code>teacher123</code>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                                <i class="fas fa-check-circle"></i> <?php echo $reset_success; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($reset_error)): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle"></i> <?php echo $reset_error; ?>
                            </div>
                        <?php endif; ?>
                        
                        <p>Enter your email address and we'll send you a link to reset your password.</p>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="reset_password" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Send Reset Link
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
