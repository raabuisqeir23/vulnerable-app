<?php
include 'config.php';
include 'includes/header.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$message = '';
$upload_success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['profile_photo'])) {
        $file = $_FILES['profile_photo'];
        $filename = $file['name'];
        $tmp_name = $file['tmp_name'];
        $file_size = $file['size'];
        $file_error = $file['error'];
        
        
        $upload_path = UPLOAD_DIR . $filename;
        
        if ($file_error === 0) {
            if ($file_size <= MAX_FILE_SIZE) {
                if (move_uploaded_file($tmp_name, $upload_path)) {
                    $username = $_SESSION['username'];
                    $conn = getDB();
                    $update = "UPDATE employees SET profile_photo = '$filename' WHERE username = '$username'";
                    $conn->query($update);
                    $conn->close();
                    
                    $message = "Profile photo uploaded successfully!";
                    $upload_success = true;
                    

                } else {
                    $message = "Failed to upload file.";
                }
            } else {
                $message = "File too large. Maximum size is 5MB.";
            }
        } else {
            $message = "Error uploading file.";
        }
    }
}

// Get current user's photo
$conn = getDB();
$username = $_SESSION['username'];
$query = "SELECT profile_photo FROM employees WHERE username = '$username'";
$result = $conn->query($query);
$user = $result->fetch_assoc();
$current_photo = $user['profile_photo'] ?? '';
$conn->close();
?>
<div class="upload-page">
    <h2>Update Profile Photo</h2>
    
    <?php if($message): ?>
        <div class="<?php echo $upload_success ? 'success-msg' : 'error-msg'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    
    <?php if($current_photo): ?>
    <div class="current-photo">
        <h3>Current Photo</h3>
        <img src="/bazaarjo/uploads/<?php echo $current_photo; ?>" alt="Profile Photo" style="max-width:200px;">
    </div>
    <?php endif; ?>
    
    <div class="upload-form">
        <h3>Upload New Photo</h3>
        <div class="security-notice">
            <strong>Note:</strong> Supported formats: JPG, PNG, GIF
        </div>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="profile_photo">Select Image</label>
                <input type="file" name="profile_photo" id="profile_photo" required>
            </div>
            <button type="submit" class="btn-primary">Upload Photo</button>
        </form>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
