<?php
include 'config.php';
include 'includes/header.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$conn = getDB();
$message = '';
$announcements = $conn->query("SELECT * FROM announcements ORDER BY posted_date DESC");


$feedback = $_GET['feedback'] ?? '';
?>
<div class="announcements-page">
    <h2>Company Announcements</h2>
    
    <?php if($feedback): ?>
    <div class="feedback-box">
        <h3>Feedback Submitted</h3>
        <p>Thank you for your feedback: <?php echo $feedback; ?></p>
        
    </div>
    <?php endif; ?>
    
    <div class="announcements-list">
        <?php while($row = $announcements->fetch_assoc()): ?>
        <div class="announcement-card">
            <h3><?php echo $row['title']; ?></h3>
           
            <div class="announcement-content">
                <?php echo $row['content']; ?>
            </div>
            <div class="announcement-meta">
                <span>Posted by: <?php echo $row['author']; ?></span>
                <span>Date: <?php echo $row['posted_date']; ?></span>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
    
    <div class="feedback-section">
        <h3>Leave Feedback</h3>
        <form method="GET" action="announcements.php">
            <div class="form-group">
                <label>Your feedback</label>
                <input type="text" name="feedback" placeholder="Enter your feedback here...">
            </div>
            <button type="submit" class="btn-primary">Submit Feedback</button>
        </form>
    </div>
</div>
<?php
$conn->close();
include 'includes/footer.php';
?>
