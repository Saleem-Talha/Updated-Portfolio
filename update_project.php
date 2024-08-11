<?php
// Include the database connection file
include 'includes/db-connect.php';
include 'includes/header-links.php';

// Initialize variables
$project = null;
$message = '';
$search_performed = false;

// Handle project search
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_project'])) {
    $project_name = $_POST['project_name'];
    
    // Fetch project details
    $stmt = $db->prepare("SELECT * FROM projects WHERE project_name = ?");
    $stmt->bind_param("s", $project_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $project = $result->fetch_assoc();
    $stmt->close();

    $search_performed = true;

    if (!$project) {
        $message = "<div class='alert alert-warning' role='alert'>No project found with the name '$project_name'.</div>";
    }
}

// Handle form submission for updating project
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_project'])) {
    $project_name = $_POST['project_name'];
    $project_description = $_POST['project_description'];
    $project_features = $_POST['project_features'];
    $project_link = $_POST['project_link'];
    $project_demo_link = $_POST['project_demo_link'];
    $project_technologies = $_POST['project_technologies'];

    // Handle file upload if a new image is provided
    if ($_FILES['project_img']['size'] > 0) {
        $target_dir = "project_img/";
        $target_file = $target_dir . basename($_FILES["project_img"]["name"]);
        move_uploaded_file($_FILES["project_img"]["tmp_name"], $target_file);
        $project_img = $target_file;
    } else {
        $project_img = $_POST['current_project_img'];
    }

    // Update the project in the database
    $stmt = $db->prepare("UPDATE projects SET project_description = ?, project_features = ?, project_link = ?, demo_link = ?, project_img = ?, project_technologies = ? WHERE project_name = ?");
    $stmt->bind_param("sssssss", $project_description, $project_features, $project_link, $project_demo_link, $project_img, $project_technologies, $project_name);
    
    if ($stmt->execute()) {
        $message = "<div class='alert alert-success' role='alert'>Project updated successfully!</div>";
        // Refresh project data
        $result = $db->query("SELECT * FROM projects WHERE project_name = '$project_name'");
        $project = $result->fetch_assoc();
    } else {
        $message = "<div class='alert alert-danger' role='alert'>Error updating project: " . $stmt->error . "</div>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Project</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #343a40;
            color: #ffffff;
        }
        .form-label {
            color: #ffffff;
        }
    </style>
</head>
<body>
<div id="particles-container">
    <div id="particles-js"></div>
</div>
<div class="container">
    <h1 class="mt-5">Update Project</h1>
    <?php echo $message; ?>

    <!-- Project Search Form -->
    <form method="post" action="" class="mb-4">
        <div class="form-group">
            <label for="search_project_name" class="form-label">Enter Project Name:</label>
            <input type="text" name="project_name" id="search_project_name" class="form-control" required>
        </div>
        <button type="submit" name="search_project" class="btn btn-primary">Search Project</button>
    </form>

    <?php if ($project): ?>
        <form method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="project_name" value="<?php echo htmlspecialchars($project['project_name']); ?>">
            <input type="hidden" name="current_project_img" value="<?php echo htmlspecialchars($project['project_img']); ?>">
            
            <div class="form-group">
                <label for="project_name" class="form-label">Project Name:</label>
                <input type="text" id="project_name" class="form-control" value="<?php echo htmlspecialchars($project['project_name']); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="project_description" class="form-label">Project Description:</label>
                <textarea name="project_description" id="project_description" rows="5" class="form-control" required><?php echo htmlspecialchars($project['project_description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="project_features" class="form-label">Project Features (one per line):</label>
                <textarea name="project_features" id="project_features" rows="5" class="form-control"><?php echo htmlspecialchars($project['project_features']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="project_link" class="form-label">Project Link:</label>
                <input type="url" name="project_link" id="project_link" class="form-control" value="<?php echo htmlspecialchars($project['project_link']); ?>" required>
            </div>
            <div class="form-group">
                <label for="project_demo_link" class="form-label">Project Demo Link:</label>
                <input type="url" name="project_demo_link" id="project_demo_link" class="form-control" value="<?php echo htmlspecialchars($project['demo_link']); ?>">
            </div>
            <div class="form-group">
                <label for="project_img" class="form-label">Project Image:</label>
                <input type="file" name="project_img" id="project_img" class="form-control-file">
                <small class="form-text text-muted">Leave empty to keep the current image.</small>
            </div>
            <div class="form-group">
                <label for="project_technologies" class="form-label">Project Technologies (separate each with a comma):</label>
                <textarea name="project_technologies" id="project_technologies" class="form-control" required><?php echo htmlspecialchars($project['project_technologies']); ?></textarea>
            </div>
            <button type="submit" name="update_project" class="btn btn-primary">Update Project</button>
        </form>
    <?php elseif ($search_performed): ?>
        <p>No project found with the given name. Please check the project name and try again.</p>
    <?php endif; ?>
</div>

<?php include_once('particles.php'); ?>
</body>
</html>