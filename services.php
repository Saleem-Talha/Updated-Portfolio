<?php
// Include database connection
include 'includes/db-connect.php';

// Handle form submission for services
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_service'])) {
    $service_type = $_POST['service_type'];
    $service_heading = $_POST['service_heading'];
    $services = implode("\n", array_filter(explode("\n", $_POST['services']))); // Convert array to newline-separated string

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
$services_query = "SELECT * FROM services ORDER BY service_type";
$services_result = $db->query($services_query);

// Group services by type
$grouped_services = [];
while ($service = $services_result->fetch_assoc()) {
    $grouped_services[$service['service_type']][] = $service;
}
?>

<section id="services" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-main bold-text">My Services</h2>
            </div>
        </div>
        
        <!-- Display Services -->
        <div class="row mt-4">
            <div class="col-md-12 py-3" data-aos="fade-up">
                <div class="card">
                    <div class="card-body ps-0">
                        <ul class="nav nav-tabs tabs" id="myTab" role="tablist">
                            <?php
                            $first = true;
                            foreach ($grouped_services as $service_type => $services) :
                                $tab_id = strtolower(str_replace(' ', '-', $service_type));
                            ?>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link <?php echo $first ? 'active' : ''; ?>" id="<?php echo $tab_id; ?>-tab" data-bs-toggle="tab"
                                        data-bs-target="#<?php echo $tab_id; ?>-tab-pane" type="button" role="tab"
                                        aria-controls="<?php echo $tab_id; ?>-tab-pane" aria-selected="<?php echo $first ? 'true' : 'false'; ?>">
                                        <?php echo htmlspecialchars($service_type); ?>
                                    </button>
                                </li>
                            <?php
                                $first = false;
                            endforeach;
                            ?>
                        </ul>
                        <div class="tab-content" id="myTabContent" data-aos="fade-up">
                            <?php
                            $first = true;
                            foreach ($grouped_services as $service_type => $services) :
                                $tab_id = strtolower(str_replace(' ', '-', $service_type));
                            ?>
                                <div class="tab-pane fade <?php echo $first ? 'show active' : ''; ?> text-light" id="<?php echo $tab_id; ?>-tab-pane" role="tabpanel"
                                    aria-labelledby="<?php echo $tab_id; ?>-tab" tabindex="0">
                                    <div class="row mt-5">
                                        <?php foreach ($services as $service) : ?>
                                            <div class="col-md-6 mb-3">
                                                <h6 class="text-muted mb-3"><?php echo htmlspecialchars($service['service_heading']); ?></h6>
                                                <ul class="list-group">
                                                    <?php
                                                    $service_items = explode("\n", $service['services']);
                                                    foreach ($service_items as $item) :
                                                        $item = trim($item);
                                                        if (!empty($item)) :
                                                    ?>
                                                        <li class="list-group-item">
                                                            <i class="fa fa-check me-3 text-main"></i>
                                                            <?php echo htmlspecialchars($item); ?>
                                                        </li>
                                                    <?php 
                                                        endif;
                                                    endforeach; 
                                                    ?>
                                                </ul>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php
                                $first = false;
                            endforeach;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

      
    </div>
</section>

<script>
    // JavaScript to handle dynamic addition of service items
    document.getElementById('services').addEventListener('input', function(e) {
        let lines = e.target.value.split('\n');
        e.target.value = lines.join('\n');
    });
</script>