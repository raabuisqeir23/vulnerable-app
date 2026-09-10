<?php
// Log user activity if logged in
if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    $conn = getDB();
    $username = $_SESSION['username'];
    $page = basename($_SERVER['PHP_SELF']);
    $stmt = $conn->prepare("INSERT INTO system_logs (event_type, description, username, timestamp) VALUES (?, ?, ?, NOW())");
    $event = 'page_view';
    $desc = "Viewed page: $page";
    $stmt->bind_param("sss", $event, $desc, $username);
    $stmt->execute();
    $stmt->close();
    $conn->close();
}
?>
    </main>
    <footer>
        <div class="footer-container">
            <p>&copy; 2024 SecureCorp. All rights reserved.</p>
            <p>Internal Use Only</p>
        </div>
    </footer>
</body>
</html>
