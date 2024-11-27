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
    <link rel="stylesheet" href="./assets/css/template.css">
    <link rel="stylesheet" href="./assets/css/features.css">
</head>
<body>
    <!-- Header (Navbar) -->
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
                <a class="btn btn-primary me-3" href="./dashboard.php">Dashboard</a>
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
    </div>
</nav>

    <div class="filters">
        <button>All</button>
        <button>Catalog</button>
        <button>Magazine</button>
        <button>Brochure</button>
        <button>Recipe & Cookbook</button>
        <button>Guidebook</button>
        <button>Lookbook</button>
        <button>Photo Albums</button>
        <button>Newsletter</button>
        <button>Menus</button>
        <button>Profile</button>
        <!-- Add other filter buttons as needed -->
    </div>

    <section class="template-gallery">
        <!-- Template 1 -->
        <div class="template-card">
            <img src="./assets/images/newspaper-template.png" alt="Online Newspaper Template">
            <div class="template-info">
                <h3>Online Newspaper Template</h3>
                <div class="stats">
                    <span>342 views</span> | <span>54 favorites</span>
                </div>
            </div>
        </div>
        <!-- Template 2 -->
        <div class="template-card">
            <img src="./assets/images/teachers-day-card.png" alt="Happy Teachers' Day Card Template">
            <div class="template-info">
                <h3>Happy Teachers' Day Card Template</h3>
                <div class="stats">
                    <span>512 views</span> | <span>20 favorites</span>
                </div>
            </div>
        </div>
        <!-- Template 3 -->
        <div class="template-card">
            <img src="./assets/images/old-newspaper.png" alt="Old Newspaper Template">
            <div class="template-info">
                <h3>Old Newspaper Template</h3>
                <div class="stats">
                    <span>803 views</span> | <span>30 favorites</span>
                </div>
            </div>
        </div>
        <!-- Template 4 -->
        <div class="template-card">
            <img src="./assets/images/product-catalogue.png" alt="Product Catalogue Design Template">
            <div class="template-info">
                <h3>Product Catalogue Design Template</h3>
                <div class="stats">
                    <span>1065 views</span> | <span>40 favorites</span>
                </div>
            </div>
        </div>
        <!-- Template 5 -->
        <div class="template-card">
            <img src="./assets/images/green-transportation.png" alt="Eco-Friendly Green Transportation Brochure Template">
            <div class="template-info">
                <h3>Eco-Friendly Green Transportation Brochure Template</h3>
                <div class="stats">
                    <span>562 views</span> | <span>17 favorites</span>
                </div>
            </div>
        </div>
        <div class="template-card">
            <img src="./assets/images/green-transportation.png" alt="Eco-Friendly Green Transportation Brochure Template">
            <div class="template-info">
                <h3>Eco-Friendly Green Transportation Brochure Template</h3>
                <div class="stats">
                    <span>562 views</span> | <span>17 favorites</span>
                </div>
            </div>
        </div>
        <div class="template-card">
            <img src="./assets/images/green-transportation.png" alt="Eco-Friendly Green Transportation Brochure Template">
            <div class="template-info">
                <h3>Eco-Friendly Green Transportation Brochure Template</h3>
                <div class="stats">
                    <span>562 views</span> | <span>17 favorites</span>
                </div>
            </div>
        </div>
        <div class="template-card">
            <img src="./assets/images/newspaper-template.png" alt="Online Newspaper Template">
            <div class="template-info">
                <h3>Online Newspaper Template</h3>
                <div class="stats">
                    <span>342 views</span> | <span>54 favorites</span>
                </div>
            </div>
        </div>
        <!-- Template 2 -->
        <div class="template-card">
            <img src="./assets/images/teachers-day-card.png" alt="Happy Teachers' Day Card Template">
            <div class="template-info">
                <h3>Happy Teachers' Day Card Template</h3>
                <div class="stats">
                    <span>512 views</span> | <span>20 favorites</span>
                </div>
            </div>
        </div>
        <!-- Template 3 -->
        <div class="template-card">
            <img src="./assets/images/old-newspaper.png" alt="Old Newspaper Template">
            <div class="template-info">
                <h3>Old Newspaper Template</h3>
                <div class="stats">
                    <span>803 views</span> | <span>30 favorites</span>
                </div>
            </div>
        </div>
        <!-- Template 4 -->
        <div class="template-card">
            <img src="./assets/images/product-catalogue.png" alt="Product Catalogue Design Template">
            <div class="template-info">
                <h3>Product Catalogue Design Template</h3>
                <div class="stats">
                    <span>1065 views</span> | <span>40 favorites</span>
                </div>
            </div>
        </div>
        <!-- Template 5 -->
        <div class="template-card">
            <img src="./assets/images/green-transportation.png" alt="Eco-Friendly Green Transportation Brochure Template">
            <div class="template-info">
                <h3>Eco-Friendly Green Transportation Brochure Template</h3>
                <div class="stats">
                    <span>562 views</span> | <span>17 favorites</span>
                </div>
            </div>
        </div>
        <div class="template-card">
            <img src="./assets/images/green-transportation.png" alt="Eco-Friendly Green Transportation Brochure Template">
            <div class="template-info">
                <h3>Eco-Friendly Green Transportation Brochure Template</h3>
                <div class="stats">
                    <span>562 views</span> | <span>17 favorites</span>
                </div>
            </div>
        </div>
        <div class="template-card">
            <img src="./assets/images/green-transportation.png" alt="Eco-Friendly Green Transportation Brochure Template">
            <div class="template-info">
                <h3>Eco-Friendly Green Transportation Brochure Template</h3>
                <div class="stats">
                    <span>562 views</span> | <span>17 favorites</span>
                </div>
            </div>
        </div>
        <div class="template-card">
            <img src="./assets/images/newspaper-template.png" alt="Online Newspaper Template">
            <div class="template-info">
                <h3>Online Newspaper Template</h3>
                <div class="stats">
                    <span>342 views</span> | <span>54 favorites</span>
                </div>
            </div>
        </div>
        <!-- Template 2 -->
        <div class="template-card">
            <img src="./assets/images/teachers-day-card.png" alt="Happy Teachers' Day Card Template">
            <div class="template-info">
                <h3>Happy Teachers' Day Card Template</h3>
                <div class="stats">
                    <span>512 views</span> | <span>20 favorites</span>
                </div>
            </div>
        </div>
        <!-- Template 3 -->
        <div class="template-card">
            <img src="./assets/images/old-newspaper.png" alt="Old Newspaper Template">
            <div class="template-info">
                <h3>Old Newspaper Template</h3>
                <div class="stats">
                    <span>803 views</span> | <span>30 favorites</span>
                </div>
            </div>
        </div>
        <!-- Template 4 -->
        <div class="template-card">
            <img src="./assets/images/product-catalogue.png" alt="Product Catalogue Design Template">
            <div class="template-info">
                <h3>Product Catalogue Design Template</h3>
                <div class="stats">
                    <span>1065 views</span> | <span>40 favorites</span>
                </div>
            </div>
        </div>
        <!-- Template 5 -->
        <div class="template-card">
            <img src="./assets/images/green-transportation.png" alt="Eco-Friendly Green Transportation Brochure Template">
            <div class="template-info">
                <h3>Eco-Friendly Green Transportation Brochure Template</h3>
                <div class="stats">
                    <span>562 views</span> | <span>17 favorites</span>
                </div>
            </div>
        </div>
        <div class="template-card">
            <img src="./assets/images/green-transportation.png" alt="Eco-Friendly Green Transportation Brochure Template">
            <div class="template-info">
                <h3>Eco-Friendly Green Transportation Brochure Template</h3>
                <div class="stats">
                    <span>562 views</span> | <span>17 favorites</span>
                </div>
            </div>
        </div>
        <div class="template-card">
            <img src="./assets/images/green-transportation.png" alt="Eco-Friendly Green Transportation Brochure Template">
            <div class="template-info">
                <h3>Eco-Friendly Green Transportation Brochure Template</h3>
                <div class="stats">
                    <span>562 views</span> | <span>17 favorites</span>
                </div>
            </div>
        </div>
        <div class="template-card">
            <img src="./assets/images/green-transportation.png" alt="Eco-Friendly Green Transportation Brochure Template">
            <div class="template-info">
                <h3>Eco-Friendly Green Transportation Brochure Template</h3>
                <div class="stats">
                    <span>562 views</span> | <span>17 favorites</span>
                </div>
            </div>
        </div>
        <!-- Add more templates as needed -->
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h4>Company</h4>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Learning Center</a></li>
                    <li><a href="#">Office Tools</a></li>
                    <li><a href="#">Mango AI</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Cooperation</h4>
                <ul>
                    <li><a href="#">Elite Program</a></li>
                    <li><a href="#">Partnership</a></li>
                    <li><a href="#">Community</a></li>
                    <li><a href="#">DMCA Policy</a></li>
                    <li><a href="#">Country Distributor</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Support</h4>
                <ul>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">Updates</a></li>
                    <li><a href="#">Gift Card Exchange</a></li>
                    <li><a href="#">Blog Archive</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Follow Us</h4>
                <ul>
                    <li><a href="#">Twitter</a></li>
                    <li><a href="#">Facebook</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Policies</h4>
                <ul>
                    <li><a href="#">Privacy</a></li>
                    <li><a href="#">Cookie Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Explore Our Other Products: AI Video Generator, AI Video Maker, Animation Software, Whiteboard Animation Software, Character Animation Maker, Video Maker, Presentation Maker, Flipbook Software</p>
            <p>© 2024 WONDER IDEA TECHNOLOGY LIMITED. All rights reserved</p>
        </div>
    </footer>

</body>
</html>