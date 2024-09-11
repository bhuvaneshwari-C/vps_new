<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include './database_conn.php';

// Fetch product details if product_id is provided
$enquire_id = isset($_GET['id']) ? $_GET['id'] : null;
$enquire = null;

if ($enquire_id) {
    $sql = "SELECT * FROM enquiries WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $enquire_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $enquire = $result->fetch_assoc();
    $stmt->close();
}

// Handle form submission to update product details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['enquire_id'])) {

    $enquire_id = mysqli_real_escape_string($conn, $_POST['enquire_id']);
    $enquiry_name = mysqli_real_escape_string($conn, $_POST['enquiry_name']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $enquiry_category = mysqli_real_escape_string($conn, $_POST['enquiry_category']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Update the product in the database
    $sql = "UPDATE enquiries SET name=?, phone=?, email=?, city=?, state=?, category=?, message=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $enquiry_name, $number, $email, $city, $state, $enquiry_category, $message, $enquire_id);

    if ($stmt->execute()) {
        echo "<script>
        alert('Enquire Updated successfully');
        window.location.href='enquiry-list.php';
        </script>";
    exit();
    } else {
        echo "<script>
        alert('Oops! Something went wrong. Please try again later.');
        window.location.href='enquiry-list.php'; // Redirect to the form page or any other page
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">


<head>
    <!-- PAGE TITLE HERE -->
	<title>Edit Enquiry</title>
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
					<img src="images/favicon.png" class="dark-login" width="110px" alt="">
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
								Edit Enquiry
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
               <div class="col-xl-12 col-xxl-12">
                   <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Enquiry</h4>
                            </div>
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">
							<input type="hidden" name="enquire_id" value="<?php echo isset($enquire['id']) ? $enquire['id'] : ''; ?>">
								<div class="row">
												<div class="col-lg-12 mb-2">
													<div class="mb-3">
													     <label for="enquiry_name" class="text-label form-label">Name</label>
													     <input type="text" class="form-control" id="enquiry_name" name="enquiry_name" value="<?php echo htmlspecialchars($enquire['name']); ?>">
													</div>
												</div>
												<div class="col-lg-12 mb-2">
													<div class="mb-3">
													   <label for="number" class="text-label form-label">Phone Number</label>
													   <input type="number" class="form-control" id="number" name="number" value="<?php echo htmlspecialchars($enquire['phone']); ?>">
													</div>
												</div>
												<div class="col-lg-12 mb-2">
													<div class="mb-3">
													    <label for="email" class="text-label form-label">Email</label>
													    <input type="text" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($enquire['email']); ?>">
													</div>
												</div>
												<div class="col-lg-12 mb-3">
													<div class="mb-3">
													<label for="city" class="text-label form-label">City</label>
													<input type="text" class="form-control" id="city" name="city" value="<?php echo htmlspecialchars($enquire['city']); ?>">
													</div>
												</div>
												<div class="col-lg-12 mb-2">
													<div class="mb-3">
													<label for="state" class="text-label form-label">State</label>
													<input type="text" class="form-control" id="state" name="state" value="<?php echo htmlspecialchars($enquire['state']); ?>">
													</div>
												</div>
												<div class="col-lg-12 mb-2">
													<div class="mb-3">
														<label class="text-label form-label" for="category">Category</label>
														<select class="default-select form-control form-control-sm wide" id="enquiry_category" name="enquiry_category">
														<option>Select</option>
                                                        <option <?php echo ($enquire['category'] == 'Solar') ? 'selected' : ''; ?>>Solar</option>
                                                        <option <?php echo ($enquire['category'] == 'Agricultural') ? 'selected' : ''; ?>>Agricultural</option>
                                                        <option <?php echo ($enquire['category'] == 'Domestic') ? 'selected' : ''; ?>>Domestic </option>
														<option <?php echo ($enquire['category'] == 'Both') ? 'selected' : ''; ?>>Both</option>
                                                        </select>
													</div>
												</div>
												<div class="col-lg-12 mb-2">
													<div class="mb-3">
														<label class="text-label form-label" for="message">Message</label>
														<textarea class="form-control" rows="8" id="message" name="message" placeholder=""><?php echo htmlspecialchars($enquire['message']); ?></textarea>
													</div>
												</div>
												<div class="mb-4">
												   <button type="submit" class="btn btn-outline-success">Update</button>
                                                </div>
										</div>
                                </form>   
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