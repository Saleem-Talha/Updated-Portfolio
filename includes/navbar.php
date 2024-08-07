
<nav id="navbar" class="navbar navbar-expand-lg navbar-dark main-nav">
        <div class="container">
            <a class="navbar-brand bold-text" href="#" data-aos="fade-down" data-aos-delay="100">Saleem Talha</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end nav-headings" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item" data-aos="fade-down" data-aos-delay="200">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item" data-aos="fade-down" data-aos-delay="300">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item" data-aos="fade-down" data-aos-delay="400">
                        <a class="nav-link" href="#skills">Skills</a>
                    </li>
                    <li class="nav-item" data-aos="fade-down" data-aos-delay="500">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item" data-aos="fade-down" data-aos-delay="600">
                        <a class="nav-link" href="#projects">Projects</a>
                    </li>
                    <li class="nav-item" data-aos="fade-down" data-aos-delay="700">
                        <a class="nav-link" href="#contacts">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <script>
        // on some scroll a new class will be added to nav
        window.addEventListener('scroll', function () {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
                navbar.classList.add('fixed-top');
            } else {
                navbar.classList.remove('scrolled');
                navbar.classList.remove('fixed-top');
            }
        });
    </script>