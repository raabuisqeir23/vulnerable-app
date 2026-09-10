<?php
include 'config.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    
    $conn = getDB();
    $query = "SELECT * FROM employees WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $user['username'];
        $_SESSION['emp_id'] = $user['emp_id'];
        $_SESSION['is_admin'] = $user['is_admin'];
        $_SESSION['full_name'] = $user['full_name'];
        
        // Update last login
        $update = "UPDATE employees SET last_login = NOW() WHERE emp_id = " . $user['emp_id'];
        $conn->query($update);
        $conn->close();
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Invalid username or password";
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Bazaarjo</title>
    <link rel="stylesheet" href="/bazaarjo/css/style.css">
</head>
<body style="background: #f5f5f5;">
    <div class="login-container">
        <div class="login-box">
            <h1>Bazaarjo</h1>
            <p>Employee Portal Login</p>
            
            <?php if($error): ?>
                <div class="error-msg"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" class="btn-primary">Login</button>
            </form>
            
        </div>
    </div>
</body>
</html>
