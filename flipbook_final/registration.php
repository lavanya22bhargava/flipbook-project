<?php
session_start();
if (isset($_SESSION["user"])) {
   header("Location: index.php");
}

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
}}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/log_reg.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="./index.php">
                <img src="./assets/images/download.png" alt="Logo" height="40" >
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav mx-auto">
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
    
    <div class="container">
        <?php
        if (isset($_POST["submit"])) {
           $fullName = $_POST["fullname"];
           $email = $_POST["email"];
           $password = $_POST["password"];
           $passwordRepeat = $_POST["repeat_password"];
           
           $passwordHash = password_hash($password, PASSWORD_DEFAULT);

           $errors = array();
           
           if (empty($fullName) OR empty($email) OR empty($password) OR empty($passwordRepeat)) {
            array_push($errors,"All fields are required");
           }
           if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid");
           }
           if (strlen($password)<8) {
            array_push($errors,"Password must be at least 8 charactes long");
           }
           if ($password!==$passwordRepeat) {
            array_push($errors,"Password does not match");
           }
           require_once "database.php";
           $sql = "SELECT * FROM users WHERE email = '$email'";
           $result = mysqli_query($conn, $sql);
           $rowCount = mysqli_num_rows($result);
           if ($rowCount>0) {
            array_push($errors,"Email already exists!");
           }
           if (count($errors)>0) {
            foreach ($errors as  $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
           }else{
            
            $sql = "INSERT INTO users (full_name, email, password) VALUES ( ?, ?, ? )";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt,"sss",$fullName, $email, $passwordHash);
                mysqli_stmt_execute($stmt);
                echo "<div class='alert alert-success'>You are registered successfully.</div>";
            }else{
                die("Something went wrong");
            }
           }
          

        }
        ?>
        <form action="registration.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Full Name:">
            </div>
            <div class="form-group">
                <input type="emamil" class="form-control" name="email" placeholder="Email:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Confirm Password:">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
        </form>
        <div>
        <div><p>Already Registered <a href="login.php">Login Here</a></p></div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="footer bg-dark text-white py-4">
        <div class="container_foot">
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