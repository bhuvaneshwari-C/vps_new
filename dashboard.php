<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Store the success message and then unset it
$success_message = "";
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

$error_message = "";
if(isset($_SESSION['error_message'])){
    $ERROR_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}

include './database_conn.php';

$agriculture_count = 0;
$solar_count = 0;
$domestic_count = 0;

$sql_agriculture = "SELECT COUNT(*) as agriculture_count FROM product_details WHERE product_category = 'Agricultural Product'";
$sql_solar = "SELECT COUNT(*) as solar_count FROM product_details WHERE product_category = 'Solar Product'";
$sql_domestic = "SELECT COUNT(*) as domestic_count FROM product_details WHERE product_category = 'Domestic Product'";

$result_agriculture = $conn->query($sql_agriculture);
$result_solar = $conn->query($sql_solar);
$result_domestic = $conn->query($sql_domestic);

if ($result_agriculture) {
    $row = $result_agriculture->fetch_assoc();
    $agriculture_count = $row['agriculture_count'];
}

if ($result_solar) {
    $row = $result_solar->fetch_assoc();
    $solar_count = $row['solar_count'];
}

if ($result_domestic) {
    $row = $result_domestic->fetch_assoc();
    $domestic_count = $row['domestic_count'];
}

$sql = "SELECT COUNT(*) as product_count FROM product_details";
$result = $conn->query($sql);
$product_count = 0;

if ($result) {
    $row = $result->fetch_assoc();
    $product_count = $row['product_count'];
} else {
    echo "Error: " . $conn->error;
}
// Enquires
$sql = "SELECT COUNT(*) as enquire_count FROM enquiries";
$result = $conn->query($sql);
$enquire_count = 0;

if ($result) {
    $row = $result->fetch_assoc();
    $enquire_count = $row['enquire_count'];
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">


<head>
    <!-- PAGE TITLE HERE -->
	<title>Dashboard</title>
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
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
   <link class="main-css" href="css/style.css" rel="stylesheet">
	
</head>
<body>

    <!--*******************
        Preloader start
    ********************-->
   <div id="preloader">
		<div class="loading-wave">
			<div class="loading-bar"></div>
			<div class="loading-bar"></div>
			<div class="loading-bar"></div>
			<div class="loading-bar"></div>
		</div>
	</div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
		<div class="nav-header">
			
				<div class="brand-logo">
					<img src="images/favicon.png" class="logo light" width="120px" alt="">
					<!-- <img src="images/DarkFavicon.png" class="dark" width="120px"  alt=""> -->
				</div>
	
		
			<div class="nav-control">
				<div class="hamburger">
					<span class="line"></span><span class="line"></span><span class="line"></span>
				</div>
			</div>
		</div>
        <!--**********************************
            Nav header end
        ***********************************-->
		
		<!--**********************************
            Header start
        ***********************************-->
		<div class="header">
			<div class="header-content">
				<nav class="navbar navbar-expand">
					<div class="collapse navbar-collapse justify-content-between">
						<div class="header-left">
							<div class="dashboard_bar">
								Dashboard
							</div>
						</div>
						<ul class="navbar-nav header-right">
							<li class="nav-item dropdown notification_dropdown">
								<button class="ic-theme-mode" type="button">
									<span class="light">Light</span>
									<span class="dark">Dark</span>
								</button>
							</li>
						
							<li class="nav-item header-profile">
								<a class="nav-link" href="logout.php" role="button">
								
									<svg width="40" height="40" viewBox="0 0 40 40" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<path opacity="0.25"
										d="M28.6325 11.2111L16.3162 7.10573C15.6687 6.88989 15 7.37186 15 8.05442V31.9462C15 32.6288 15.6687 33.1108 16.3162 32.8949L28.6325 28.7895C29.4491 28.5173 30 27.753 30 26.8921V13.1085C30 12.2476 29.4491 11.4834 28.6325 11.2111Z"
										fill="white" />
									<path
										d="M19.1663 15.833L23.333 19.9997M23.333 19.9997L19.1663 24.1663M23.333 19.9997H6.66634"
										stroke="white" stroke-linecap="round" />
								</svg>
									<div class="header-info ms-3">
										<span class="fs-14 font-w600 mb-0">Logout</span>
									</div>
								</a>
							
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</div>
                    
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
		<div class="ic-sidenav">
			<div class="ic-sidenav-scroll">
				<ul class="metismenu" id="menu">
					<li><a class="has-arrow" href="dashboard.php" aria-expanded="false">
							<i class="flaticon-home"></i>
							<span class="nav-text">Dashboard</span>
						</a>
					</li>
					<li>
						<a class="has-arrow " href="add-product.php" aria-expanded="false">
							<i class="bi bi-folder-plus"></i>
							<span class="nav-text">Add Product</span>
						</a>
					</li>
					<li><a class="has-arrow " href="product-list.php" aria-expanded="false">
							<i class="flaticon-document"></i>
							<span class="nav-text">Product List</span>
						</a>
					</li>
					<li><a class="has-arrow " href="enquiry-list.php" aria-expanded="false">
							<i class="bi bi-question-circle"></i>
							<span class="nav-text">Enquiry List</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
        <!--**********************************
            Sidebar end
        ***********************************-->
		
		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
			<div class="container-fluid">
			  <div class="row">
				<div class="col-xl-3 col-xxl-4 col-lg-6 col-sm-6">
					<div class="widget-stat card bg-danger">
						<div class="card-body  p-4">
							<div class="media">
								<span class="me-3">
									<i class="fas fa-solar-panel"></i>
								</span>
								<div class="media-body text-white text-end">
									<p class="mb-1">Solar Products</p>
									<h3 class="text-white"><?php echo $solar_count; ?></h3>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-xxl-4 col-lg-6 col-sm-6">
					<div class="widget-stat card bg-success">
						<div class="card-body p-4">
							<div class="media">
								<span class="me-3">
									<i class="fas fa-tractor"></i>
								</span>
								<div class="media-body text-white text-end">
									<p class="mb-1">Agriculture Products</p>
									<h3 class="text-white"><?php echo $agriculture_count; ?></h3>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-xxl-4 col-lg-6 col-sm-6">
					<div class="widget-stat card bg-info">
						<div class="card-body p-4">
							<div class="media">
								<span class="me-3">
									<i class="fas fa-tools"></i>
								</span>
								<div class="media-body text-white text-end">
									<p class="mb-1">Domestic Products</p>
									<h3 class="text-white"><?php echo $domestic_count; ?></h3>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-xxl-4 col-lg-6 col-sm-6">
					<div class="widget-stat card bg-warning">
						<div class="card-body p-4">
							<div class="media">
								<span class="me-3">
									<i class="fas fa-box"></i>
								</span>
								<div class="media-body text-white text-end">
									<p class="mb-1">Total Products</p>
									<h3 class="text-white"><?php echo $product_count; ?></h3>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-xxl-4 col-lg-6 col-sm-6">
					<div class="widget-stat card bg-primary">
						<div class="card-body p-4">
							<div class="media">
								<span class="me-3">
									<i class="fas fa-box"></i>
								</span>
								<div class="media-body text-white text-end">
									<p class="mb-1">Total Enquiries</p>
									<h3 class="text-white"><?php echo $enquire_count; ?></h3>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				
            </div>
		  </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
		
		
        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
              <p>Copyright © Designed &amp; Developed by <a href="https://www.nearlooks.com/" target="_blank">Nearlook</a> <span class="current-year">2024</span></p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->


	</div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

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


</html>