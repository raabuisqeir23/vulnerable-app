<?php
include 'config.php';
include 'includes/header.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$conn = getDB();
$username = $_SESSION['username'];

// Get user profile data
$query = "SELECT * FROM employees WHERE username = '$username'";
$result = $conn->query($query);
$user = $result->fetch_assoc();

// Get user's recent activity
$activity_query = "SELECT * FROM system_logs WHERE username = '$username' ORDER BY timestamp DESC LIMIT 5";
$activity_result = $conn->query($activity_query);

$conn->close();

// Format date for display
$hire_date = date('F d, Y', strtotime($user['hire_date']));
$last_login = $user['last_login'] ? date('F d, Y H:i:s', strtotime($user['last_login'])) : 'Never';
?>
<div class="profile-page">
    <h2>My Profile</h2>
    
    <div class="profile-container">
        <!-- Profile Photo Section -->
        <div class="profile-left">
            <div class="profile-photo-card">
                <div class="profile-photo">
                    <?php if($user['profile_photo'] && file_exists(UPLOAD_DIR . $user['profile_photo'])): ?>
                        <img src="/bazaarjo/uploads/<?php echo $user['profile_photo']; ?>" 
                             alt="Profile Photo" 
                             class="profile-photo-img">
                    <?php else: ?>
                        <div class="no-photo-placeholder">
                            <span class="avatar-text"><?php echo strtoupper(substr($user['full_name'], 0, 2)); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="profile-photo-actions">
                    <p class="photo-status">
                        <?php if($user['profile_photo']): ?>
                            ✅ Photo uploaded
                        <?php else: ?>
                            ⚠️ No profile photo
                        <?php endif; ?>
                    </p>
                    <a href="/bazaarjo/upload.php" class="btn-secondary">Update Photo</a>
                </div>
            </div>
            
            <div class="profile-stat-card">
                <h4>Account Status</h4>
                <div class="status-item">
                    <span class="status-label">Status:</span>
                    <span class="status-badge active">Active</span>
                </div>
                <div class="status-item">
                    <span class="status-label">Role:</span>
                    <span class="status-value"><?php echo $user['is_admin'] ? 'Administrator' : 'Employee'; ?></span>
                </div>
                <div class="status-item">
                    <span class="status-label">Department:</span>
                    <span class="status-value"><?php echo $user['department']; ?></span>
                </div>
            </div>
        </div>
        
        <!-- Profile Details -->
        <div class="profile-right">
            <div class="profile-info-card">
                <h3>Personal Information</h3>
                
                <div class="info-grid">
                    <div class="info-item">
                        <label>Full Name</label>
                        <div class="info-value"><?php echo htmlspecialchars($user['full_name']); ?></div>
                    </div>
                    
                    <div class="info-item">
                        <label>Username</label>
                        <div class="info-value"><?php echo htmlspecialchars($user['username']); ?></div>
                    </div>
                    
                    <div class="info-item">
                        <label>Email Address</label>
                        <div class="info-value"><?php echo htmlspecialchars($user['email']); ?></div>
                    </div>
                    
                    <div class="info-item">
                        <label>Department</label>
                        <div class="info-value"><?php echo htmlspecialchars($user['department']); ?></div>
                    </div>
                    
                    <div class="info-item">
                        <label>Position</label>
                        <div class="info-value"><?php echo htmlspecialchars($user['position']); ?></div>
                    </div>
                    
                    <div class="info-item">
                        <label>Employee ID</label>
                        <div class="info-value">BJ-<?php echo str_pad($user['emp_id'], 4, '0', STR_PAD_LEFT); ?></div>
                    </div>
                    
                    <div class="info-item">
                        <label>Hire Date</label>
                        <div class="info-value"><?php echo $hire_date; ?></div>
                    </div>
                    
                    <div class="info-item">
                        <label>Last Login</label>
                        <div class="info-value"><?php echo $last_login; ?></div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activity -->
            <div class="activity-card">
                <h3>Recent Activity</h3>
                <?php if($activity_result && $activity_result->num_rows > 0): ?>
                    <div class="activity-list">
                        <?php while($activity = $activity_result->fetch_assoc()): ?>
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <?php 
                                    $icon = '📄';
                                    if(strpos($activity['description'], 'login') !== false) $icon = '🔑';
                                    if(strpos($activity['description'], 'upload') !== false) $icon = '📷';
                                    if(strpos($activity['description'], 'profile') !== false) $icon = '👤';
                                    if(strpos($activity['description'], 'system') !== false) $icon = '🔧';
                                    if(strpos($activity['description'], 'search') !== false) $icon = '🔍';
                                    echo $icon;
                                    ?>
                                </div>
                                <div class="activity-details">
                                    <div class="activity-desc"><?php echo htmlspecialchars($activity['description']); ?></div>
                                    <div class="activity-time"><?php echo date('M d, Y H:i:s', strtotime($activity['timestamp'])); ?></div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <p class="no-activity">No recent activity recorded.</p>
                <?php endif; ?>
            </div>
            
            <!-- Quick Actions -->
            <div class="quick-actions-card">
                <h3>Quick Actions</h3>
                <div class="action-buttons">
                    <a href="/bazaarjo/dashboard.php" class="action-btn">📊 Dashboard</a>
                    <a href="/bazaarjo/system.php" class="action-btn">🔧 System</a>
                    <a href="/bazaarjo/search.php" class="action-btn">🔍 Search</a>
                    <a href="/bazaarjo/announcements.php" class="action-btn">📢 Announcements</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
