<?php
include 'config.php';
include 'includes/header.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$output = '';
$command = '';
$ping_result = '';


if (isset($_POST['ping_host'])) {
    $host = $_POST['host'];
    $command = "ping -c 4 $host";
   
    $output = shell_exec($command);
    $ping_result = $output;
}


$system_info = [
    'Server Time' => date('Y-m-d H:i:s'),
    'Server Uptime' => shell_exec('uptime'),
    'PHP Version' => phpversion(),
    'Disk Usage' => shell_exec('df -h /')
];

?>
<div class="system-page">
    <h2>System Status Dashboard</h2>
    
    <div class="system-info-grid">
        <?php foreach($system_info as $key => $value): ?>
        <div class="info-card">
            <h4><?php echo $key; ?></h4>
            <p><?php echo nl2br(htmlspecialchars($value)); ?></p>
        </div>
        <?php endforeach; ?>
    </div>
    
    <div class="ping-tool">
        <h3>Network Diagnostics</h3>
        <div class="security-notice">
            <strong>Internal Tool:</strong> For IT use only. Enter hostname or IP to test connectivity.
        </div>
        <form method="POST">
            <div class="form-group">
                <label>Host/IP to ping</label>
                <input type="text" name="host" placeholder="e.g., google.com or 192.168.1.1" required>
            </div>
            <button type="submit" name="ping_host" class="btn-primary">Test Connectivity</button>
        </form>
        
        <?php if($ping_result): ?>
        <div class="ping-output">
            <h4>Ping Results:</h4>
            <pre><?php echo htmlspecialchars($ping_result); ?></pre>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
