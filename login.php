<?php
session_start();
// if (isset($_SESSION['username'])) {
//     header("Location: dashboard.php");
//     exit();
// }

include './database_conn.php';

//Handle form submission
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST['username'];
    $password = $_POST['password'];

//prepare the sql statement
$stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $stored_password);
    $stmt->fetch();

    // Compare plain text passwords
    if ($password === $stored_password) {
        $_SESSION['username'] = $username;
        echo "<script>
        alert('Login Successful! Welcome, " . htmlspecialchars($username) . "');
        window.location.href='dashboard.php'; 
    </script>";
    exit();
    } else {
        echo "<script>
        alert('Invalid password.');
        window.location.href='" . $_SERVER['PHP_SELF'] . "';
    </script>";
    exit();
    }
} else {
    echo "<script>
    alert('No user found with that username.');
    window.location.href='" . $_SERVER['PHP_SELF'] . "';
</script>";
exit();
}
$stmt->close();
$conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from worldnic.dexignlab.com/xhtml/page-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 09 Sep 2024 06:00:13 GMT -->
<head>
    <!-- PAGE TITLE HERE -->
	<title>Login Page</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="DexignLab">
	<meta name="robots" content="index, follow">
	<link rel="canonical" href="https://worldnic.dexignlab.com/xhtml">
	<meta name="keywords"content="admin, admin dashboard, admin template, analytics, bootstrap, bootstrap5, bootstrap 5 admin template, modern, responsive admin dashboard, sales dashboard, sass, ui kit, web app, Codebyte SaaS, User Interface (UI), User Experience (UX), Dashboard Design, SaaS Application, Web Application, Data Visualization, Analytics, Customization, Responsive Design, Bootstrap Framework, Charts and Graphs, Data Management, Reporting, Dark Mode, Mobile-Friendly, Dashboard Components, Integrations, Analytics Dashboard, API Integration, User Authentication">
	<meta name="description"content="Elevate your administrative efficiency and enhance productivity with the Codebyte SaaS Admin Dashboard Template. Designed to streamline your tasks, this powerful tool provides a user-friendly interface, robust features, and customizable options, making it the ideal choice for managing your data and operations with ease.">
	<!-- OG:META TAGS -->
	<meta property="og:title" content="WorldNIC - Admin Dashboard Bootstrap HTML Template">
	<meta property="og:description"content="Elevate your administrative efficiency and enhance productivity with the Codebyte SaaS Admin Dashboard Template. Designed to streamline your tasks, this powerful tool provides a user-friendly interface, robust features, and customizable options, making it the ideal choice for managing your data and operations with ease.">
	<meta property="og:image" content="social-image.png">
	<meta name="format-detection" content="telephone=no">
	<!-- TWITTER:META TAGS -->
	<meta name="twitter:title" content="WorldNIC - Admin Dashboard Bootstrap HTML Template">
	<meta name="twitter:description"content="Elevate your administrative efficiency and enhance productivity with the Codebyte SaaS Admin Dashboard Template. Designed to streamline your tasks, this powerful tool provides a user-friendly interface, robust features, and customizable options, making it the ideal choice for managing your data and operations with ease.">
	<meta name="twitter:image" content="social-image.png">
	<meta name="twitter:card" content="summary_large_image">

	<!-- MOBILE SPECIFIC -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="image/png" href="images/favicon.png">
	<link href="vendor/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet">
   <link class="main-css" href="css/style.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <style>
    .social-icon1 {
    font-size: 20px;
    color: #1A3636;
    margin: 0 10px;
    transition: color 0.3s ease;
}
/* .container{
	background-color:#0bfea5;
} */
   </style>

</head>

<body>
    <div class="authincation d-flex flex-column flex-lg-row flex-column-fluid">
		<div class="login-aside text-center d-none d-sm-flex flex-column flex-row-auto">
			<div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
				<div class="text-center mb-4 pt-5">
					<a href="index.html"><img src="images/favicon.png" class="dark-login" width="160px"  alt=""></a>
					<!-- <a href="index.html"><img src="images/favicon.png" class="light-login" alt=""></a> -->
				</div>
				<h3 class="mb-2">Welcome back!</h3>
				<p>Your trusted partner in pumping solutions.</p>
			</div>
			<div class="aside-image" style="background-image:url(images/pic1.svg);"></div>
		</div>
		<div class="container flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
			<div class="d-flex justify-content-center h-100 align-items-center">
				<div class="authincation-content style-2">
					<div class="row no-gutters">
						<div class="col-xl-12">
							<div class="auth-form">
								<div class="text-center d-block d-sm-none mb-4 pt-5">
									<!-- <a href="index.html"><img src="images/favicon.png" class="dark-login"  alt="" width="100px"></a> -->
									<!-- <img src="images/favicon.png" class="light-login" alt=""> -->
								</div>
								
								<h4 class="text-center mb-4">Admin Login</h4>
								<form action="login.php" method="post">
									<div class="mb-3">
										<label class="mb-1 form-label">Email</label>
										<input type="email" class="form-control"  name="username" placeholder="Email address">
									</div>
									<div class="mb-3">
										<label class="mb-1 form-label">Password</label>
										<div class="position-relative">
											<input type="password" id="inputPassword" class="form-control" name="password" placeholder="Password">
											<span class="eye">
												<i class="fa fa-eye-slash" id="togglePassword" style="cursor:pointer;"></i>
											</span>
										</div>
									</div>
									<div class="form-row d-flex justify-content-between mt-4 mb-2">
										<div class="mb-3">
										   <div class="form-check custom-checkbox ms-1">
												<input type="checkbox" class="form-check-input" id="basic_checkbox_1">
												<label class="form-check-label" for="basic_checkbox_1">Remember my preference</label>
											</div>
										</div>
									</div>
									<div class="text-center">
										<button type="submit" class="btn btn-primary btn-block">Login Now</button>
									</div>
								</form>
                                <div class="text-center mt-5">
                                       <h5>Follow Us!</h5>
									   <a href="#" class="social-icon1 mx-2"><i class="fab fa-facebook-f"></i></a>
                                       <a href="#" class="social-icon1 mx-2"><i class="fab fa-instagram"></i></a>
                                       <a href="#" class="social-icon1 mx-2"><i class="fab fa-whatsapp"></i></a>  
                                </div>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<script>
	  const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#inputPassword');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
</script>

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
  <script src="vendor/global/global.min.js"></script>
<script src="vendor/bootstrap-select/js/bootstrap-select.min.js"></script>
<script src="js/custom.min.js"></script>
<script src="js/ic-sidenav-init.js"></script>
<script src="js/demo.js"></script>
<script src="js/styleSwitcher.js"></script>
</body>

<!-- Mirrored from worldnic.dexignlab.com/xhtml/page-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 09 Sep 2024 06:00:14 GMT -->
</html>