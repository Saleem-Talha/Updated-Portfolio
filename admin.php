<?php
// Include the database connection file
include 'includes/db-connect.php';
include 'includes/header-links.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['hero_submit'])) {
        // Handle Hero section submission
        $description = $_POST['description'];

        // Check if a description already exists in the hero table
        $result = $db->query("SELECT id FROM hero LIMIT 1");
        if ($result && $result->num_rows > 0) {
            // If a description exists, update it
            $stmt = $db->prepare("UPDATE hero SET description = ? WHERE id = (SELECT id FROM hero LIMIT 1)");
        } else {
            // If no description exists, insert a new one
            $stmt = $db->prepare("INSERT INTO hero (description) VALUES (?)");
        }

        if ($stmt) {
            // Bind the parameter and execute the statement
            $stmt->bind_param("s", $description);
            $stmt->execute();
            $stmt->close(); // Close the statement

            echo "<div class='alert alert-success' role='alert'>Hero data saved successfully!</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error preparing statement: " . $db->error . "</div>";
        }
    } elseif (isset($_POST['about_submit'])) {
        // Handle About section submission
        $about_description = $_POST['about_description'];
        $about_img = $_FILES['about_img'];

        // Handle file upload
        $target_dir = "img/";
        
        // Create the directory if it doesn't exist
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $target_file = $target_dir . basename($about_img["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($about_img["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "<div class='alert alert-danger' role='alert'>File is not an image.</div>";
            $uploadOk = 0;
        }

        // Check file size
        if ($about_img["size"] > 500000) {
            echo "<div class='alert alert-danger' role='alert'>Sorry, your file is too large.</div>";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "<div class='alert alert-danger' role='alert'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>";
            $uploadOk = 0;
        }

        // If everything is ok, try to upload file and save data
        if ($uploadOk == 1) {
            if (move_uploaded_file($about_img["tmp_name"], $target_file)) {
                // File uploaded successfully, now save to database
                $stmt = $db->prepare("INSERT INTO about (description, about_img) VALUES (?, ?) ON DUPLICATE KEY UPDATE description = VALUES(description), about_img = VALUES(about_img)");
                
                if ($stmt) {
                    $stmt->bind_param("ss", $about_description, $target_file);
                    $stmt->execute();
                    $stmt->close();

                    echo "<div class='alert alert-success' role='alert'>About data saved successfully!</div>";
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Error preparing statement: " . $db->error . "</div>";
                }
            } else {
                echo "<div class='alert alert-danger' role='alert'>Sorry, there was an error uploading your file.</div>";
            }
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_service'])) {
    $service_type = $_POST['service_type'];
    $service_heading = $_POST['service_heading'];
    $services = implode(", ", $_POST['services']); // Convert array to comma-separated string

    $stmt = $db->prepare("INSERT INTO services (service_type, service_heading, services) VALUES (?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sss", $service_type, $service_heading, $services);
        if ($stmt->execute()) {
            echo "<div class='alert alert-success' role='alert'>Service added successfully!</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error adding service: " . $stmt->error . "</div>";
        }
        $stmt->close();
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error preparing statement: " . $db->error . "</div>";
    }
}

// Fetch services from the database
$services_result = $db->query("SELECT * FROM services ORDER BY id DESC");


// Handle Project section submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['project_submit'])) {
    $project_name = $_POST['project_name'];
    $project_description = $_POST['project_description'];
    $project_link = $_POST['project_link'];
    $project_img = $_FILES['project_img'];
    $project_technologies = implode(", ", $_POST['project_technologies']); // Convert array to comma-separated string

    // Handle file upload
    $target_dir = "project_img/";
    
    // Create the directory if it doesn't exist
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $target_file = $target_dir . basename($project_img["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($project_img["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "<div class='alert alert-danger' role='alert'>File is not an image.</div>";
        $uploadOk = 0;
    }

    // Check file size
    if ($project_img["size"] > 500000) {
        echo "<div class='alert alert-danger' role='alert'>Sorry, your file is too large.</div>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "<div class='alert alert-danger' role='alert'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>";
        $uploadOk = 0;
    }

    // If everything is ok, try to upload file and save data
    if ($uploadOk == 1) {
        if (move_uploaded_file($project_img["tmp_name"], $target_file)) {
            // File uploaded successfully, now save to database
            $stmt = $db->prepare("INSERT INTO projects (project_name, project_description, project_link, project_img, project_technologies) VALUES (?, ?, ?, ?, ?)");

            if ($stmt) {
                $stmt->bind_param("sssss", $project_name, $project_description, $project_link, $target_file, $project_technologies);
                $stmt->execute();
                $stmt->close();

                echo "<div class='alert alert-success' role='alert'>Project added successfully!</div>";
            } else {
                echo "<div class='alert alert-danger' role='alert'>Error preparing statement: " . $db->error . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger' role='alert'>Sorry, there was an error uploading your file.</div>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #343a40; /* Dark background */
            color: #ffffff; /* White text color */
        }
        .form-label {
            color: #ffffff; /* White label color */
        }
    </style>
</head>
<body>
    <div class="container">
        <section id="hero" class="mt-5">
            <h2>Hero Section</h2>
            <form method="post" action="">
                <div class="form-group">
                    <label for="description" class="form-label">Hero Description:</label>
                    <textarea name="description" id="description" rows="5" class="form-control" required></textarea>
                </div>
                <button type="submit" name="hero_submit" class="btn btn-dark">Save Hero</button>
            </form>
        </section>

        <section id="about" class="mt-5">
            <h2>About Section</h2>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="about_description" class="form-label">About Description:</label>
                    <textarea name="about_description" id="about_description" rows="5" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="about_img" class="form-label">About Image:</label>
                    <input type="file" name="about_img" id="about_img" class="form-control-file" required>
                </div>
                <button type="submit" name="about_submit" class="btn btn-dark">Save About</button>
            </form>
        </section>

        <section class="services py-5" id="services">
        <div class="container">
        <!-- Add Service Form -->
        <div class="row mt-5">
            <div class="col-md-12">
                <h3>Add New Service</h3>
                <form method="post" action="">
                    <div class="mb-3">
                        <label for="service_type" class="form-label">Service Type</label>
                        <select name="service_type" id="service_type" class="form-control" required>
                            <option value="framework">Framework</option>
                            <option value="frontend">Frontend</option>
                            <option value="backend">Backend</option>
                            <option value="uiux">UI/UX</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="service_heading" class="form-label">Service Heading</label>
                        <input type="text" name="service_heading" id="service_heading" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="services" class="form-label">Services (one per line)</label>
                        <textarea name="services[]" id="services" class="form-control" rows="5" required></textarea>
                    </div>
                    <button type="submit" name="add_service" class="btn btn-primary">Add Service</button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Project Section Form -->
<section id="projects" class="mt-5">
    <h2>Projects Section</h2>
    <form method="post" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label for="project_name" class="form-label">Project Name:</label>
            <input type="text" name="project_name" id="project_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="project_description" class="form-label">Project Description:</label>
            <textarea name="project_description" id="project_description" rows="5" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="project_link" class="form-label">Project Link:</label>
            <input type="url" name="project_link" id="project_link" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="project_img" class="form-label">Project Image:</label>
            <input type="file" name="project_img" id="project_img" class="form-control-file" required>
        </div>
        <div class="form-group">
            <label for="project_technologies" class="form-label">Project Technologies (separate each with a comma):</label>
            <input type="text" name="project_technologies[]" id="project_technologies" class="form-control" required>
        </div>
        <button type="submit" name="project_submit" class="btn btn-dark">Add Project</button>
    </form>
</section>
    </body>

<script>
    // JavaScript to handle dynamic addition of service items
    document.getElementById('services').addEventListener('input', function(e) {
        let lines = e.target.value.split('\n');
        e.target.value = lines.join('\n');
    });
</script>
    </div>
</body>
</html>