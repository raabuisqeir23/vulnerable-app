<?php
include 'config.php';
include 'includes/header.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$search_term = '';
$results = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['q'])) {
    $search_term = $_GET['q'];
    $conn = getDB();
    

    $query = "SELECT * FROM employees WHERE 
              full_name LIKE '%$search_term%' OR 
              department LIKE '%$search_term%' OR 
              email LIKE '%$search_term%' OR
              username LIKE '%$search_term%'";
    
    $results = $conn->query($query);
    if (!$results) {
        $error = $conn->error;
    }
    $conn->close();
}
?>
<div class="search-page">
    <h2>Employee Directory Search</h2>
    
    <div class="search-form">
        <form method="GET">
            <div class="form-group">
                <label>Search employees by name, department, or email</label>
                <input type="text" name="q" value="<?php echo htmlspecialchars($search_term); ?>" 
                       placeholder="Enter search term..." required>
            </div>
            <button type="submit" class="btn-primary">Search</button>
        </form>
    </div>
    
    <?php if($search_term): ?>
    <div class="search-results">
        <h3>Results for "<?php echo htmlspecialchars($search_term); ?>"</h3>
        <?php if($error): ?>
            <div class="error-msg">Search error: <?php echo $error; ?></div>
        <?php elseif($results && $results->num_rows > 0): ?>
            <table class="employee-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Email</th>
                        <th>Photo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $results->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['full_name']; ?></td>
                        <td><?php echo $row['department']; ?></td>
                        <td><?php echo $row['position']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td>
                            <?php if($row['profile_photo']): ?>
                                <img src="/bazaarjo/uploads/<?php echo $row['profile_photo']; ?>" 
                                     style="max-width:50px; max-height:50px; border-radius:50%;">
                            <?php else: ?>
                                No photo
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No employees found matching your search.</p>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>
<?php include 'includes/footer.php'; ?>
