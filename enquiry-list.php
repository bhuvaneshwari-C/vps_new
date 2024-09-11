<?php
session_start();

if (!isset($_SESSION['username'])) {
    // If the session is not set, redirect to the login page
    header("Location:login.php");
    exit();
}
include './database_conn.php';

// Fetch product data from the database
$sql = "SELECT * FROM enquiries ORDER BY id DESC";
$result = $conn->query($sql);
$serialNumber = 1;

?>



<!DOCTYPE html>
<html lang="en">


<head>
    <!-- PAGE TITLE HERE -->
	<title>Product List</title>
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
	<link href="vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
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
								Enquiry List
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
		<div class="container-fluid">
				<div class="row">
					<div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Enquiry List</h4>
								<div>
                                     <a href="#" class="btn btn-primary btn-sm" id="exportButton">Download Excel</a>
								    <a href="#" class="btn btn-info btn-sm" id="exportPdfButton">Download PDF</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="enquiryList" class="display">
                                        <thead>
                                            <tr>
											<th>S.No</th>
                                            <th>Name</th>
                                            <th>Phone No.</th>
                                            <th>Email</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Category</th>
                                            <th>Message</th>
                                            <th>Action</th>
                                            </tr>
                                        </thead>
										<tbody>
                    <?php if ($result->num_rows > 0) : ?>
                        <?php while($row = $result->fetch_assoc()) : ?>
                            <tr>
                                <td><?php echo $serialNumber++; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['phone']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['city']; ?></td>
                                <td><?php echo $row['state']; ?></td>
                                <td><?php echo $row['category']; ?></td>
                                <td><?php echo $row['message']; ?></td>
                                <td class="action-buttons">
                                    <a href="edit-enquiry.php?id=<?php echo $row['id']; ?>" class="btn btn-primary shadow btn-xs sharp me-1"><i class='fa fa-pencil'></i></a>
                                    <form action="delete-enquiry.php" method="post" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" onclick="return confirm('Are you sure, you want to delete this record?');" class="btn btn-danger shadow btn-xs sharp">
                                            <i class='fa fa-trash'></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7">No products found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                                    </table>
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
	   <!-- Datatable -->
	   <script src="vendor/global/global.min.js"></script>

	   <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
     
	 <script src="js/plugins-init/datatables.init.js"></script>
    <!-- Required vendors -->
   
	<script src="vendor/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="js/custom.min.js"></script>
	<script src="js/ic-sidenav-init.js"></script>
	<script src="js/demo.js"></script>
    <script src="js/styleSwitcher.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<!-- pdf -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

<script>
        document.getElementById('exportButton').addEventListener('click', function () {
    let table = document.getElementById('enquiryList');

    // Convert table to a JSON array to easily manipulate rows/columns
    let rows = Array.from(table.rows).map(row =>
        Array.from(row.cells).map(cell => cell.innerText)
    );

    // Remove unwanted columns (second column and last two columns)
    let filteredRows = rows.map(row => row.filter((_, index) => index !== 1 && index < row.length - 2));

    // Create a new workbook and worksheet
    let workbook = XLSX.utils.book_new();
    let worksheet = XLSX.utils.aoa_to_sheet(filteredRows); // AOA = Array of Arrays

    // Append the worksheet to the workbook
    XLSX.utils.book_append_sheet(workbook, worksheet, "Products");

    // Export the workbook to an Excel file
    XLSX.writeFile(workbook, 'Enquiry_List.xlsx');
});

// pdf

document.getElementById('exportPdfButton').addEventListener('click', function () {
    let table = document.getElementById('enquiryList');

    // Extract rows and cells data
    let rows = Array.from(table.rows).map(row => 
        Array.from(row.cells).map(cell => cell.innerText)
    );

    // Remove the second column (Image) and the last two columns (PDF, Action)
    let filteredRows = rows.map(row => row.filter((_, index) => index !== 1 && index < row.length - 2));

    // Create a temporary table for the PDF generation
    let tempTable = document.createElement('table');
    tempTable.style.borderCollapse = 'separate'; // Ensure spacing between rows
    tempTable.style.borderSpacing = '0 10px';   // Add vertical spacing between rows

    filteredRows.forEach(row => {
        let tr = document.createElement('tr');
        row.forEach(cell => {
            let td = document.createElement('td');
            td.style.padding = '10px';  // Add padding to the table cells
            td.textContent = cell;
            tr.appendChild(td);
        });
        tempTable.appendChild(tr);
    });

    // Add the table to the DOM (temporarily)
    document.body.appendChild(tempTable);
    
    // Use html2canvas to convert the table to a canvas
    html2canvas(tempTable, { scale: 2 }).then(canvas => {
        let imgData = canvas.toDataURL('image/png');
        
        // Check if the canvas generated a valid image
        if (imgData === "data:,") {
            console.error("Canvas failed to generate a valid image.");
            return;
        }

        // Initialize jsPDF and calculate the image size for the PDF
        const { jsPDF } = window.jspdf;
        let pdf = new jsPDF('p', 'pt', 'a4');
        let imgWidth = pdf.internal.pageSize.getWidth();
        let imgHeight = canvas.height * imgWidth / canvas.width;

        // Add the image to the PDF
        pdf.addImage(imgData, 'PNG', 10, 10, imgWidth - 20, imgHeight);
        pdf.save('Enquiry_List.pdf');

        // Clean up by removing the temporary table
        document.body.removeChild(tempTable);
    }).catch(error => {
        console.error("Error rendering canvas: ", error);
    });
});



    </script>
</body>


</html>