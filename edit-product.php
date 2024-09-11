<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include './database_conn.php';

// Fetch product details if product_id is provided
$product_id = isset($_GET['id']) ? $_GET['id'] : null;
$product = null;

if ($product_id) {
    $sql = "SELECT * FROM product_details WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
}

// Handle form submission to update product details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {

    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_description = mysqli_real_escape_string($conn, $_POST['product_description']);
    $product_category = mysqli_real_escape_string($conn, $_POST['product_category']);
    $keywords = mysqli_real_escape_string($conn, $_POST['keywords']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $pdf = '';

    // Handle file uploads
    $image_dir = "uploads/";
    $pdf_dir = "uploads/";

    // Upload product image
    if (!empty($_FILES['product_img']['name'])) {
        $image_file = $image_dir . basename($_FILES["product_img"]["name"]);
        $imageFileType = strtolower(pathinfo($image_file, PATHINFO_EXTENSION));
        
        if (move_uploaded_file($_FILES["product_img"]["tmp_name"], $image_file)) {
            $product_img = $image_file;
        } else {
            echo "Error uploading image.";
        }
    } else {
        // Keep the current image if none is uploaded
        $product_img = $product['product_img'];
    }

    // Upload PDF file
    if (!empty($_FILES['pdf']['name'])) {
        $pdf_file = $pdf_dir . basename($_FILES["pdf"]["name"]);
        $pdfFileType = strtolower(pathinfo($pdf_file, PATHINFO_EXTENSION));

        if (move_uploaded_file($_FILES["pdf"]["tmp_name"], $pdf_file)) {
            $pdf = $pdf_file;
        } else {
            echo "Error uploading PDF.";
        }
    } else {
        // Keep the current PDF if none is uploaded
        $pdf = $product['pdf'];
    }

    // Update the product in the database
    $sql = "UPDATE product_details SET product_name=?, product_description=?, product_category=?, keywords=?, price=?, product_img=?, pdf=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $product_name, $product_description, $product_category, $keywords, $price, $product_img, $pdf, $product_id);

    if ($stmt->execute()) {
        echo "<script>
        alert('Product Updated successfully');
        window.location.href='product-list.php';
        </script>";
    exit();
    } else {
        echo "<script>
        alert('Oops! Something went wrong. Please try again later.');
        window.location.href='product-list.php'; // Redirect to the form page or any other page
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
	<title>Edit Product</title>
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
   <style>
	   .add-reset-btn{
    background-color: gray;
    border:none;
    color:white;
    border-radius: 5px;
	width:70px;
}
	     #imagePreview {
    text-align: center;
    margin-bottom: 15px;
}

#imagePreview img {
    max-width: 150px;
    height: auto;
    display: block;
    margin: 0 auto;
}

   </style>
	
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
								Edit Product
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
                                <h4 class="card-title">Edit Product</h4>
                            </div>
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">
							   <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
								<div class="row">
											 <div class="col-lg-12 mb-4 mt-4">
												  <!-- Image preview div -->
												  <div id="imagePreview" class="mt-3" style="display: none;">
												      <img id="imageElement" src="<?php echo !empty($product['product_img']) ? $product['product_img'] : ''; ?>" alt="Image Preview" class="img-fluid" />
                                                </div>
                                                <label for="productImage" class="form-label">Product Image</label>
                                                <!-- Input box for selecting image -->
                                                <div class="input-group mt-2">
                                                          <input type="file" id="productImage" name="product_img" class="form-control" onchange="previewImage(event)" accept=".jpg, .jpeg, .png, .svg">
                                                          <button type="button" class="add-reset-btn" onclick="resetImagePreview()">Reset</button>
                                                </div>
                                             </div>

												<div class="col-lg-12 mb-2">
													<div class="mb-3">
														<label class="text-label form-label" for="product_name">Product Name</label>
														<input type="text" class="form-control" id="product_name" name="product_name" placeholder="Product Name" value="<?php echo htmlspecialchars($product['product_name']); ?>">
													</div>
												</div>
												<div class="col-lg-12 mb-2">
													<div class="mb-3">
														<label class="text-label form-label" for="product_description">Product Description</label>
														<textarea class="form-control" rows="8" id="product_description" name="product_description" placeholder="Description"><?php echo htmlspecialchars($product['product_description']); ?></textarea>
													</div>
												</div>
												<div class="col-lg-12 mb-2">
													<div class="mb-3">
														<label class="text-label form-label" for="product_category">Product Category</label>
														<select class="default-select form-control form-control-sm wide" id="product_category" name="product_category">
														<option>Select</option>
                                                        <option <?php echo ($product['product_category'] == 'Solar Product') ? 'selected' : ''; ?>>Solar Product</option>
                                                        <option <?php echo ($product['product_category'] == 'Agricultural Product') ? 'selected' : ''; ?>>Agricultural Product</option>
                                                        <option <?php echo ($product['product_category'] == 'Domestic Product') ? 'selected' : ''; ?>>Domestic Product</option>
                                                        </select>
													</div>
												</div>
												<div class="col-lg-12 mb-2">
													<div class="mb-3">
														<label class="text-label form-label" for="keywords">Keywords</label>
														<input type="text" id="keywords" name="keywords" class="form-control" placeholder="keywords" value="<?php echo htmlspecialchars($product['keywords']); ?>">
													</div>
												</div>
												<div class="col-lg-12 mb-3">
													<div class="mb-3">
														<label class="text-label form-label" for="price">Price</label>
														<input type="text" id="price" name="price" class="form-control" placeholder="price" value="<?php echo htmlspecialchars($product['price']); ?>">
													</div>
												</div>
												<div class="col-lg-12 mb-2">
													<div class="mb-3">
														<label class="text-label form-label" for="pdf">Upload PDF</label>
														<input type="file" class="form-control mb-3" id="pdf" name="pdf" accept=".pdf">
														<?php
                                                        if (!empty($product['pdf'])) {
                                                        echo '<p><a href="' . $product['pdf'] . '" target="_blank" style="color:rgb(40, 69, 51); text-decoration: none;">View Pdf</a></p>';
                                                        } else {
                                                         echo '<p>No PDF uploaded.</p>';
                                                         }
                                                        ?>
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
	<script>
window.onload = function() {
    const imageElement = document.getElementById('imageElement');
    const imagePreview = document.getElementById('imagePreview');
    
    // Show image preview if image source is not empty
    if (imageElement.src && imageElement.src !== window.location.href) {
        imagePreview.style.display = 'block';
    }
}

function previewImage(event) {
    const imageElement = document.getElementById('imageElement');
    const imagePreview = document.getElementById('imagePreview');
    
    // Display the new image preview when a file is selected
    imageElement.src = URL.createObjectURL(event.target.files[0]);
    imagePreview.style.display = 'block'; // Ensure the preview is visible
}

function resetImagePreview() {
    const imageElement = document.getElementById('imageElement');
    const imagePreview = document.getElementById('imagePreview');
    const inputFile = document.getElementById('productImage');

    // Clear the file input and restore the original image
    inputFile.value = '';
    imageElement.src = '<?php echo !empty($product['product_img']) ? 'path/to/images/' . $product['product_img'] : ''; ?>'; // Restore original image
    imagePreview.style.display = imageElement.src ? 'block' : 'none'; // Hide if no image exists
}


	</script>
    <!-- Required vendors -->
    <script src="vendor/global/global.min.js"></script>
	<script src="vendor/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="js/custom.min.js"></script>
	<script src="js/ic-sidenav-init.js"></script>
	<script src="js/demo.js"></script>
    <script src="js/styleSwitcher.js"></script>
</body>


</html>