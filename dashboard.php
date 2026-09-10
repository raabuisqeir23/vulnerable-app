<?php
include 'config.php';
include 'includes/header.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$conn = getDB();
$username = $_SESSION['username'];

// Get employee info
$query = "SELECT * FROM employees WHERE username = '$username'";
$result = $conn->query($query);
$user = $result->fetch_assoc();

// Get recent announcements
$announcements = $conn->query("SELECT * FROM announcements ORDER BY posted_date DESC LIMIT 3");

// VULNERABILITY: SQL Injection in search parameter if present
$search_term = $_GET['search'] ?? '';
$search_results = null;
if ($search_term) {
    // VULNERABILITY: SQL Injection - unsanitized input
    $search_query = "SELECT * FROM employees WHERE full_name LIKE '%$search_term%' OR department LIKE '%$search_term%'";
    $search_results = $conn->query($search_query);
}
?>
<div class="dashboard">
    <h2>Welcome, <?php echo htmlspecialchars($user['full_name']); ?></h2>
    
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Employee Info</h3>
            <p><strong>Department:</strong> <?php echo $user['department']; ?></p>
            <p><strong>Position:</strong> <?php echo $user['position']; ?></p>
            <p><strong>Hired:</strong> <?php echo $user['hire_date']; ?></p>
        </div>
        <div class="stat-card">
            <h3>Quick Actions</h3>
            <ul>
                <li><a href="/bazaarjo/upload.php">Update Profile Photo</a></li>
                <li><a href="/bazaarjo/system.php">System Status</a></li>
                <li><a href="/bazaarjo/search.php">Search Employees</a></li>
            </ul>
        </div>
    </div>
    
    <?php if($search_term): ?>
    <div class="search-results">
        <h3>Search Results for "<?php echo htmlspecialchars($search_term); ?>"</h3>
        <?php if($search_results && $search_results->num_rows > 0): ?>
            <table>
                <tr><th>Name</th><th>Department</th><th>Position</th><th>Email</th></tr>
                <?php while($row = $search_results->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['full_name']; ?></td>
                    <td><?php echo $row['department']; ?></td>
                    <td><?php echo $row['position']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No employees found</p>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    
    <div class="announcements">
        <h3>Recent Announcements</h3>
        <?php while($row = $announcements->fetch_assoc()): ?>
            <div class="announcement">
                <h4><?php echo $row['title']; ?></h4>
                <p><?php echo $row['content']; ?></p>
                <small>Posted by <?php echo $row['author']; ?> on <?php echo $row['posted_date']; ?></small>
            </div>
        <?php endwhile; ?>
    </div>
</div>
<?php
$conn->close();
include 'includes/footer.php';
?>
