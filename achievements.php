<?php
include 'includes/db-connect.php';
include('includes/header-links.php');

// Fetch achievements from the database
$stmt = $db->prepare("SELECT * FROM achievements ORDER BY id DESC");
$stmt->execute();
$result = $stmt->get_result();
$achievements = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<head>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<style>
body {
    font-family: 'Poppins', sans-serif;
}

.certificate-container {
    position: relative;
    height: 400px;
    overflow: hidden;
}

.certificate-iframe {
    width: 100%;
    height: 100%;
    border: none;
    overflow: hidden;
}

.certificate-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.8);
    color: white;
    opacity: 0;
    transition: opacity 0.3s;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px;
    text-align: center;
}

.certificate-container:hover .certificate-overlay {
    opacity: 1;
}

.main-text {
    color: white;
    text-align: center;
    padding: 10px;
    margin-bottom: 10px;
}

.button-container {
    margin-top: 10px;
}

.button-container .btn {
    margin: 0 5px;
}

/* Hide scrollbars */
.certificate-iframe {
    overflow: hidden; /* Hide scrollbars */
}
</style>

<section class="achievements py-5" id="achievements">
    <p style="color: transparent;">h</p>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <figure data-aos="fade-up">
                    <blockquote class="blockquote">
                        <h2 class="text-main bold-text">Achievements.</h2>
                    </blockquote>
                    <figcaption class="blockquote-footer mb-0 fs-1 text-uppercase">
                        Section 03
                    </figcaption>
                </figure>
            </div>
        </div>
        <div class="row">
            <?php foreach ($achievements as $index => $achievement): ?>
                <div class="col-md-6 mb-4" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title text-main bold-text"><?php echo htmlspecialchars($achievement['type']); ?></h5>
                            <div class="certificate-container">
                                <!-- Replace /view with /preview for embedding -->
                                <iframe class="certificate-iframe" src="<?php echo htmlspecialchars(str_replace('/view', '/preview', $achievement['certificate'])); ?>#toolbar=0&view=FitH" scrolling="no"></iframe>
                            </div>
                            <div class="button-container">
                                <a href="<?php echo htmlspecialchars($achievement['certificate']); ?>" class="btn btn-outline-main mt-3 main-text me-3 btn-sm" download>Download</a>
                                <button class="btn btn-outline-main mt-3 main-text me-3 btn-sm details-btn" data-title="<?php echo htmlspecialchars($achievement['title']); ?>"
                                    data-description="<?php echo htmlspecialchars($achievement['description']); ?>"
                                    data-credential_details="<?php echo htmlspecialchars($achievement['credential_details']); ?>"
                                    data-skills_acquired="<?php echo htmlspecialchars($achievement['skills_acquired']); ?>"
                                    data-key_learning_outcomes="<?php echo htmlspecialchars($achievement['key_learning_outcomes']); ?>">Details</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (($index + 1) % 2 == 0): ?>
                    </div><div class="row">
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Modal for Details -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content text-light border-0" style="background-color:black">
            <div class="modal-header border-0">
                <h5 class="modal-title text-main fs-4" id="detailsModalLabel">Achievement Details</h5>
                <button type="button" class="btn-close btn-close-light" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="fs-2 mb-2"><strong class="text-main">Title:</strong></p>
                <p id="modalTitle" class="fs-6 mb-4 white-opacity-50"></p>

                <p class="fs-2 mb-2"><strong class="text-main">Description:</strong></p>
                <p id="modalDescription" class="fs-6 mb-4 white-opacity-50"></p>

                <p class="fs-2 mb-2"><strong class="text-main">Credential Details:</strong></p>
                <ul id="modalCredentialDetails" class="list-unstyled mb-4 white-opacity-50 fs-6"></ul>

                <p class="fs-2 mb-2"><strong class="text-main">Skills Acquired:</strong></p>
                <ul id="modalSkillsAcquired" class="list-unstyled mb-4 white-opacity-50 fs-6"></ul>

                <p class="fs-2 mb-2"><strong class="text-main">Key Learning Outcomes:</strong></p>
                <ul id="modalKeyLearningOutcomes" class="list-unstyled mb-4 white-opacity-50 fs-6"></ul>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const detailsButtons = document.querySelectorAll('.details-btn');
    const modal = new bootstrap.Modal(document.getElementById('detailsModal'));
    const modalTitle = document.getElementById('modalTitle');
    const modalDescription = document.getElementById('modalDescription');
    const modalCredentialDetails = document.getElementById('modalCredentialDetails');
    const modalSkillsAcquired = document.getElementById('modalSkillsAcquired');
    const modalKeyLearningOutcomes = document.getElementById('modalKeyLearningOutcomes');

    detailsButtons.forEach(button => {
        button.addEventListener('click', function() {
            modalTitle.textContent = this.getAttribute('data-title');
            modalDescription.textContent = this.getAttribute('data-description');
            
            // Function to format text as list items with icons
            function formatAsList(text) {
                const list = text.split('\n').map(item => item.trim()).filter(item => item !== '');
                return list.map(item => `<li><i class="fa fa-check me-3 text-main"></i>${item}</li>`).join('');
            }

            modalCredentialDetails.innerHTML = formatAsList(this.getAttribute('data-credential_details'));
            modalSkillsAcquired.innerHTML = formatAsList(this.getAttribute('data-skills_acquired'));
            modalKeyLearningOutcomes.innerHTML = formatAsList(this.getAttribute('data-key_learning_outcomes'));

            modal.show();
        });
    });
});
</script>
