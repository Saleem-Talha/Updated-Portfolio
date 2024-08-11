<?php
// Include your database connection file
include 'includes/db-connect.php';

// Get the project ID from the URL parameter
$project_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the project details from the database
$stmt = $db->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->bind_param("i", $project_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $project = $result->fetch_assoc();
}

// Fetch two random projects excluding the current project
$projects_result = $db->query("SELECT * FROM projects WHERE id != $project_id ORDER BY RAND() LIMIT 2");

// Function to extract YouTube video ID
function getYouTubeVideoId($url) {
    $video_id = '';
    $parsed_url = parse_url($url);
    if (isset($parsed_url['query'])) {
        parse_str($parsed_url['query'], $query_params);
        if (isset($query_params['v'])) {
            $video_id = $query_params['v'];
        }
    } elseif (isset($parsed_url['path'])) {
        $path = explode('/', trim($parsed_url['path'], '/'));
        $video_id = end($path);
    }
    return $video_id;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($project['project_name']); ?> - Project Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@900&family=Poppins:wght@300;400;500;600&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/boxicons/css/boxicons.min.css" rel="stylesheet">

    <style>
        .hero-section {
            position: relative;
            height: 50vh;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.7));
        }
        .hero-content {
            position: relative;
            z-index: 1;
        }
        .tech-badges-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            border: none;
            outline: none;
        }
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 12px;
            background-color: transparent;
            color: white;
            border: 1px solid white;
            font-size: 0.875rem;
            text-align: center;
            transition: transform 0.3s ease;
            cursor: pointer;
        }
        .badge:hover {
            background-color: transparent !important;
            border: 1px solid var(--main-color-50) !important;
            color: var(--main-color-50) !important;
            cursor: pointer;
            transition: 0.4s;
        }
        .project-card {
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .project-card:hover {
            transform: translateY(-5px);
        }
        .card {
            border-color: rgba(255, 255, 255, 0.5);
        }
        .btn-home {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 9999;
            background-color: rgba(255, 255, 255, 0.8);
            border: none;
        }
        .list-group-item {
            background-color: transparent;
        }
        .link{
            transition: 0.5s ease;
        }
        .link:hover{
            border: 1px solid var(--main-color) !important;
            background-color: transparent !important;
            color: var(--main-color) !important;
            transition: 0.2s ease;
        }
    </style>
</head>
<body>
<div id="particles-container">
    <div id="particles-js"></div>
</div>

<div class="hero-section" style="background-image: url('<?php echo htmlspecialchars($project['project_img']); ?>');">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="display-4 bold-text mb-3 fs-5 main-text">Saleem Talha</h1>
        <p class="lead white-opacity-50">Your Vision, My Expertise, Together We Create</p>
    </div>
    <a href="index.php" class="btn btn-main btn-home"><i class="bx bx-home"></i></a>
</div>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            <h2 class="text-main bold-text"><?php echo htmlspecialchars($project['project_name']); ?></h2>
            <p class="main-text white-opacity-50" style="font-size: 1.2rem;"><?php echo nl2br(htmlspecialchars($project['project_description'])); ?></p>
            <?php if (!empty($project['project_features'])): ?>
                <h3 class="text-main bold-text mt-4">Project Features</h3>
                <ul class="list-group" style="font-size: 1rem;">
                    <?php
                    $features = explode("\n", $project['project_features']);
                    foreach ($features as $feature):
                        $feature = trim($feature);
                        if (!empty($feature)):
                    ?>
                        <li class="list-group-item white-opacity-50" style="font-size: 1.2rem;">
                            <i class="bx bx-check me-2 text-main" style="color:white"></i>
                            <?php echo htmlspecialchars($feature); ?>
                        </li>
                    <?php
                        endif;
                    endforeach;
                    ?>
                </ul>
            <?php endif; ?>
            <h3 class="text-main bold-text mt-4">Project Demo</h3>
            <?php if (!empty($project['demo_link'])): ?>
   
    <div class="ratio ratio-16x9 mt-3 mb-4">
        <div id="player"></div>
    </div>
    <script>
        // Load the YouTube IFrame Player API code asynchronously
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        // Create an <iframe> (and YouTube player) after the API code downloads
        var player;
        function onYouTubeIframeAPIReady() {
            player = new YT.Player('player', {
                height: '360',
                width: '640',
                videoId: '<?php echo getYouTubeVideoId($project['demo_link']); ?>',
                playerVars: {
                    'autoplay': 1,
                    'playsinline': 1,
                    'mute': 1  // Mute the video to allow autoplay
                },
                events: {
                    'onReady': onPlayerReady
                }
            });
        }

        // The API will call this function when the video player is ready
        function onPlayerReady(event) {
            event.target.playVideo();
        }
    </script>
<?php else: ?>
    <div class="alert alert-dark mt-4 white-opacity-50" role="alert" style="background-color: transparent;  font-size: 1rem;">
        No demo available for this project.
    </div>
<?php endif; ?>
        </div>
        
        <div class="col-md-4">
            <h3 class="text-main bold-text">Technologies Used</h3>
            <div class="mt-2 tech-badges-container">
                <?php
                $technologies = explode("\n", $project['project_technologies']);
                foreach ($technologies as $tech):
                    $tech = trim($tech);
                    if (!empty($tech)):
                ?>
                    <span class="badge"><?php echo htmlspecialchars($tech); ?></span>
                <?php
                    endif;
                endforeach;
                ?>
            </div>
            <h3 class="mt-5 text-main bold-text">Project Link</h3>
            <?php if (!empty($project['project_link'])): ?>
                <div class="mt-3 mb-4">
                    <a href="<?php echo htmlspecialchars($project['project_link']); ?>" class="white-opacity-50 link" style="text-decoration:none" target="_blank">
                        <div class="container d-flex">
                            <h6 class="me-2"><?php echo htmlspecialchars($project['project_name']); ?></h6>
                            <i class="bx bxl-github fs-2" ></i>
                        </div>
                    </a>
                </div>
            <?php endif; ?>
            <section id="more-work">
    <h3 class="mt-5 text-main bold-text mb-4">More of My Work</h3>
    <figcaption class="blockquote-footer mb-0 fs-1 text-uppercase">
        Recent Projects
    </figcaption>
    <div class="container">
        <?php if ($projects_result && $projects_result->num_rows > 0): ?>
            <?php while ($project = $projects_result->fetch_assoc()): ?>
                <div class="m-4">
                    <div class="card project-card border border-main rounded-4 main-text" data-aos="fade-up" onclick="window.location.href='project-details.php?id=<?php echo $project['id']; ?>'">
                        <img src="<?php echo htmlspecialchars($project['project_img']); ?>" class="card-img-top rounded-top-4" alt="<?php echo htmlspecialchars($project['project_name']); ?>">
                        <div class="card-body">
                            <div class="tech-badges-container">
                                <?php 
                                $technologies = explode("\n", $project['project_technologies']);
                                foreach ($technologies as $tech): 
                                    $tech = trim($tech);
                                    if (!empty($tech)):
                                ?>
                                    <span class="badge"><?php echo htmlspecialchars($tech); ?></span>
                                <?php
                                    endif;
                                endforeach; 
                                ?>
                            </div>
                            <h5 class="card-title bold-text text-main mt-2"><?php echo htmlspecialchars($project['project_name']); ?></h5>
                            <p class="card-text white-opacity-50">
                                <?php
                                $description = htmlspecialchars($project['project_description']);
                                echo substr($description, 0, 100) . (strlen($description) > 100 ? '...' : '');
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No additional projects found.</p>
        <?php endif; ?>
    </div>
</section>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.3.0/echarts.min.js"></script>
<script src="https://threejs.org/examples/js/libs/stats.min.js"></script>

<script>
    particlesJS("particles-js", {
        particles: {
            number: { value: 80, density: { enable: true, value_area: 800 } },
            color: { value: "#ffffff" },
            shape: {
                type: "circle",
                stroke: { width: 0, color: "#000000" },
                polygon: { nb_sides: 5 },
                image: { src: "img/github.svg", width: 100, height: 100 },
            },
            opacity: {
                value: 0.5,
                random: false,
                anim: { enable: false, speed: 1, opacity_min: 0.1, sync: false },
            },
            size: {
                value: 3,
                random: true,
                anim: { enable: false, speed: 40, size_min: 0.1, sync: false },
            },
            line_linked: {
                enable: true,
                distance: 150,
                color: "#ffffff",
                opacity: 0.4,
                width: 1,
            },
            move: {
                enable: true,
                speed: 6,
                direction: "none",
                random: false,
                straight: false,
                out_mode: "out",
                bounce: false,
                attract: { enable: false, rotateX: 600, rotateY: 1200 },
            },
        },
        interactivity: {
            detect_on: "canvas",
            events: {
                onhover: { enable: false, mode: "repulse" },
                onclick: { enable: true, mode: "push" },
                resize: true,
            },
            modes: {
                grab: { distance: 400, line_linked: { opacity: 1 } },
                bubble: {
                    distance: 400,
                    size: 40,
                    duration: 2,
                    opacity: 8,
                    speed: 3,
                },
                repulse: { distance: 200, duration: 0.4 },
                push: { particles_nb: 4 },
                remove: { particles_nb: 2 },
            },
        },
        retina_detect: true,
    });
    var count_particles, stats, update;
    stats = new Stats();
    stats.setMode(0);
    stats.domElement.style.position = "absolute";
    stats.domElement.style.left = "0px";
    stats.domElement.style.top = "0px";
    document.body.appendChild(stats.domElement);
    count_particles = document.querySelector(".js-count-particles");
    update = function () {
        stats.begin();
        stats.end();
        if (
            window.pJSDom[0].pJS.particles &&
            window.pJSDom[0].pJS.particles.array
        ) {
            count_particles.innerText =
                window.pJSDom[0].pJS.particles.array.length;
        }
        requestAnimationFrame(update);
    };
    requestAnimationFrame(update);

    AOS.init();
</script>

</body>
</html>

<script>
        document.addEventListener('keydown', function(event) {
            if (event.altKey && event.shiftKey && event.key === 'A') {
                // Redirect to admin.php
                window.location.href = 'admin.php';
            }
            if (event.altKey && event.shiftKey && event.key === 'U') {
                // Redirect to admin.php
                window.location.href = 'update_project.php';
            }
        });
    </script>