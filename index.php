<?php
include 'config.php';
include 'includes/header.php';

// Get company stats
$conn = getDB();
$employee_count = 0;
$dept_count = 0;

$emp_result = $conn->query("SELECT COUNT(*) as total FROM employees");
if ($emp_result && $emp_result->num_rows > 0) {
    $row = $emp_result->fetch_assoc();
    $employee_count = $row['total'];
}

$dept_result = $conn->query("SELECT COUNT(DISTINCT department) as total FROM employees");
if ($dept_result && $dept_result->num_rows > 0) {
    $row = $dept_result->fetch_assoc();
    $dept_count = $row['total'];
}

$conn->close();
?>
<div class="home-page">
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-content">
            <h1>Welcome to Bazaarjo</h1>
            <p class="hero-subtitle">Your trusted partner in e-commerce solutions since 2018</p>
            <?php if(!$logged_in): ?>
                <div class="hero-cta">
                    <a href="/bazaarjo/login.php" class="btn-primary btn-large">Employee Login</a>
                    <span class="cta-text">Access your employee portal</span>
                </div>
            <?php else: ?>
                <div class="hero-cta">
                    <a href="/bazaarjo/dashboard.php" class="btn-primary btn-large">Go to Dashboard</a>
                    <span class="cta-text">Welcome back, <?php echo htmlspecialchars($username); ?></span>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Company Overview -->
    <div class="company-overview">
        <div class="overview-grid">
            <div class="overview-card">
                <div class="overview-icon">🏢</div>
                <h3>Our Mission</h3>
                <p>To revolutionize online shopping with innovative technology and exceptional customer service.</p>
            </div>
            <div class="overview-card">
                <div class="overview-icon">💡</div>
                <h3>Innovation</h3>
                <p>We leverage AI and machine learning to create personalized shopping experiences.</p>
            </div>
            <div class="overview-card">
                <div class="overview-icon">🤝</div>
                <h3>Team Culture</h3>
                <p>Collaborative, creative, and driven by excellence - our people make Bazaarjo great.</p>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="stats-section">
        <h2>Company at a Glance</h2>
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number"><?php echo $employee_count; ?></div>
                <div class="stat-label">Employees</div>
            </div>
            <div class="stat-item">
                <div class="stat-number"><?php echo $dept_count; ?></div>
                <div class="stat-label">Departments</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">6+</div>
                <div class="stat-label">Years in Business</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">100%</div>
                <div class="stat-label">Dedicated to Success</div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="features-section">
        <h2>Employee Portal Features</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">👤</div>
                <h3>Profile Management</h3>
                <p>View and update your personal information and profile photo.</p>
                <a href="/bazaarjo/profile.php" class="feature-link">View Profile →</a>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📷</div>
                <h3>Photo Upload</h3>
                <p>Upload and manage your profile picture for internal communications.</p>
                <a href="/bazaarjo/upload.php" class="feature-link">Upload Photo →</a>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔧</div>
                <h3>System Tools</h3>
                <p>IT diagnostic tools and system status monitoring.</p>
                <a href="/bazaarjo/system.php" class="feature-link">System Status →</a>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📢</div>
                <h3>Announcements</h3>
                <p>Stay updated with company news and official communications.</p>
                <a href="/bazaarjo/announcements.php" class="feature-link">View Announcements →</a>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔍</div>
                <h3>Employee Directory</h3>
                <p>Search and connect with colleagues across the organization.</p>
                <a href="/bazaarjo/search.php" class="feature-link">Search Directory →</a>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3>Dashboard</h3>
                <p>Personal dashboard with relevant information and updates.</p>
                <a href="/bazaarjo/dashboard.php" class="feature-link">Go to Dashboard →</a>
            </div>
        </div>
    </div>

    <!-- Security Notice (Legitimate) -->
    <div class="security-notice-bottom">
        <div class="security-icon">🔒</div>
        <div class="security-text">
            <h3>Security & Privacy</h3>
            <p>This portal is for authorized personnel only. All access is monitored and logged. 
            If you experience any issues, please contact IT Support at support@bazaarjo.com</p>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
