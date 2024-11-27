<?php
session_start();
$is_logged_in = isset($_SESSION["user"]);
$user_name = "User"; // Placeholder for the user's name
$email = null;

if ($is_logged_in) {
    require_once "database.php"; // Include your database connection file
    if (isset($_SESSION['email'])) {
        $email = mysqli_real_escape_string($conn, $_SESSION['email']);
    
    $sql = "SELECT full_name FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
    if ($user) {
        $user_name = htmlspecialchars($user['full_name']); // Sanitize output
    }
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Flipbook Maker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <link rel="stylesheet" href="./assets/css/styles1.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="./index.php">
                <img src="./assets/images/download.png" alt="Logo" height="40" >
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="./features.php">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Explore</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./template.php">Templates</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="aboutus.php">About us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contactUs.php">Contact us</a>
                    </li>
                </ul>
            </div>
            <div class="d-flex align-items-center">
            <a class="btn btn-primary me-3" href="<?php echo $is_logged_in ? './dashboard.php' : 'javascript:void(0)'; ?>" 
                onclick="<?php echo !$is_logged_in ? 'redirectToLogin()' : ''; ?>">
                Dashboard 
            </a>
                <?php if ($is_logged_in): ?>
                    <!-- Profile Dropdown -->
                    <div class="dropdown">
                        <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownProfile" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="./assets/images/usericon.png" alt="User" width="32" height="32" class="rounded-circle">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownProfile">
                            <li><h6 class="dropdown-header">Hi, <?php echo $user_name; ?>!</h6></li>
                            <!-- <li><a class="dropdown-item" href="profile.php">My Profile</a></li> -->
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="logout.php" method="POST" class="d-inline">
                                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                <?php else: ?>
                    <!-- Login/Register Links -->
                    <div class="dropdown">
                        <a href="#" class="d-block link-dark text-decoration-none" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="./assets/images/usericon.png" alt="User" width="32" height="32" class="rounded-circle">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                            <li><a class="dropdown-item" href="login.php">Login</a></li>
                            <li><a class="dropdown-item" href="registration.php">Register</a></li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
            <script>
                function redirectToLogin() {
                alert("Please log in first to access the Dashboard.");
                window.location.href = "login.php"; // Redirect to login page
            }
            </script>
        </div>
    </nav>

    <!-- Main Section -->
    <section class="main-section py-5">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="content">
                <h1 class="main-title">Online Flipbook Maker</h1>
                <p class="main-subtitle">Create, Design, and Share</p>

                <ul class="feature-list">
                    <li>Convert PDF/PPT/JPG files into digital flipbooks</li>
                    <li>Edit templates for magazines, brochures, catalogs, etc.</li>
                    <li>Enhance or generate images from text with AI</li>
                    <li>Add AI chatbots, links, videos, and more for engagement</li>
                    <li>Grab the link and share across all platforms</li>
                </ul>

                <div class="main-buttons">
                    <a href="<?php echo $is_logged_in ? 'create.php' : 'javascript:void(0)'; ?>" 
                    class="btn btn-primary btn-lg" 
                    onclick="<?php echo !$is_logged_in ? 'requireLogin()' : ''; ?>">
                        Create Now
                    </a>
                    <a href="#" class="btn btn-outline-secondary btn-lg">Watch Video</a>
                </div>

            </div>

            <!-- Flipbook Demo Image -->
            <div class="flipbook-demo">
                <img src="./assets/images/flip.png" alt="Flipbook Demo" class="img-fluid rounded">
            </div>
        </div>
    </section>
    <script>
    function requireLogin() {
        alert("Please log in first to create a flipbook.");
        window.location.href = "login.php"; // Redirect to login page
    }
</script>

    <!-- Footer -->
    <footer class="footer bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-2 mb-3">
                    <h5>Company</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white-50">Home</a></li>
                        <li><a href="#" class="text-white-50">About Us</a></li>
                        <li><a href="#" class="text-white-50">Learning Center</a></li>
                        <li><a href="#" class="text-white-50">Office Tools</a></li>
                        <li><a href="#" class="text-white-50">Mango AI</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-3">
                    <h5>Cooperation</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white-50">Elite Program</a></li>
                        <li><a href="#" class="text-white-50">Partnership</a></li>
                        <li><a href="#" class="text-white-50">Community</a></li>
                        <li><a href="#" class="text-white-50">DMCA Policy</a></li>
                        <li><a href="#" class="text-white-50">Country Distributor</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-3">
                    <h5>Support</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white-50">Contact Us</a></li>
                        <li><a href="#" class="text-white-50">Help Center</a></li>
                        <li><a href="#" class="text-white-50">Updates</a></li>
                        <li><a href="#" class="text-white-50">Gift Card Exchange</a></li>
                        <li><a href="#" class="text-white-50">Blog Archive</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-3">
                    <h5>Follow Us</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white-50">Twitter</a></li>
                        <li><a href="#" class="text-white-50">Facebook</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-3">
                    <h5>Policies</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white-50">Privacy</a></li>
                        <li><a href="#" class="text-white-50">Cookie Policy</a></li>
                        <li><a href="#" class="text-white-50">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            <p class="text-center mt-4 text-white-50">Explore Our Other Products: AI Video Generator, Animation Software, Video Maker, and more.</p>
            <p class="text-center text-white-50">&copy; 2024 WONDER IDEA TECHNOLOGY LIMITED. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
</body>
</html>