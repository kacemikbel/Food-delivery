<?php
session_start();
include("db.php");

if (isset($_SESSION["sess_id"])) {
	$usr_id = $_SESSION["sess_id"];
	if ($_SESSION["sess_status"] == "admin") {
		header('location: admin/pnl_user');
	}
	if ($_SESSION["sess_status"] == "shop") {
		header('location: shop/pnl_order');
	}
}

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="favicon.ico">
	<title>Food Delivery Management </title>
	<link rel="stylesheet" href="bootstrap/css/all.min.css">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<script src="bootstrap/js/jquery-3.4.1.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
</head>

<body class="content bg-white">

	<!-- Navbar -->
	<nav class="navbar navbar-expand-lg navbar-light sticky-top shadow bg-light">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
			<a class="navbar-brand" href="#">FoodBox</a>
			<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
				<li class="nav-item ">
					<a class="nav-link" href="index">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="browse">Browse </a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="checkout">Checkout</a>
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="order">Status</a>
				</li>
			</ul>
			<div class="my-2 my-lg-0">
				<ul class="navbar-nav ml-auto">
					<?php
					if (isset($_SESSION['sess_id'])) {
					?>
						<li class="nav-item dropdown ">
							<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-user"></i> </a>
							<div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="navbarDropdownMenuLink-333">
								<a class="dropdown-item" href="profile">Profile</a>
								<a class="dropdown-item" href="action?act=lgout">Logout</a>
							</div>
						</li>
					<?php
					} else {
					?>
						<a href="index?act=login" class="btn btn-outline-success my-2 my-sm-0">Login</a>
					<?php
					}
					?>
				</ul>
			</div>
		</div>
	</nav>

	<!-- Content -->
	<div class="container my-5">

		<!-- Alert -->
		<div id="alert" style="position:absolute;z-index:1;">
		</div>

		<h2 class="display-4"><i class="fas fa-tasks"></i> Order Status</h2>

		<div class="row px-3">

			<div class="col">
				<div class="row border-top py-3 font-weight-bold">
					<div class="col-6">Meals Info</div>
					<div class="col-2">Price</div>
					<div class="col-2">Quantity</div>
					<div class="col-2">Status</div>
				</div>

				<?php
				if (isset($usr_id)) {

					$query = "SELECT * from fds_ordr JOIN fds_inv ON fds_ordr.ordr_id=fds_inv.inv_ordr_id WHERE fds_ordr.ordr_usrdt_id='$usr_id' AND fds_ordr.ordr_stat!='Completed'";
					$result = mysqli_query($conn, $query);
					$tot_prc = 0;

					if (mysqli_num_rows($result) > 0) {

						while ($row = mysqli_fetch_assoc($result)) {

							$ordr_ctlog_id = $row['ordr_ctlog_id'];

							$query = "SELECT * from fds_ctlog WHERE ctlog_id = '$ordr_ctlog_id'";
							$row_data = mysqli_fetch_assoc(mysqli_query($conn, $query));

							echo '<div class="row border-top py-3">';
							echo '<div class="col-6 text-capitalize">' . $row_data['ctlog_nme'] . '</div>';
							echo '<div class="col-2">RM ' . number_format((float)($row_data['ctlog_prc']), 2, '.', '') . '</div>';
							echo '<div class="col-2">(' . $row['ordr_qty'] . ')x Order</div>';
							if ($row['ordr_stat'] != "") {
								echo '<div class="col-2">' . $row['ordr_stat'] . '</div>';
							} else {
								echo '<div class="col-2">Preparing</div>';
							}
							echo '</div>';
							$tot_prc += $row_data['ctlog_prc'] * $row['ordr_qty'];
							$payment_type = $row['inv_type'];
						}

						$tot_svc = number_format((float)(10 / 100 * $tot_prc), 2, '.', '');


						echo '<div class="row  border-top pt-3">';

						if ($payment_type == 'paypal') {
							echo '<h4 class="col text-center text-primary">RM ' . number_format((float)(round($tot_prc + $tot_svc, 1)), 2, '.', '') . ' (Paid)</h4>';
							echo '</div>';

							echo '<div class="row">';
							echo '<p class="col text-center ">Pay by Paypal. </p>';
						} else {
							echo '<h4 class="col text-center text-success">RM ' . number_format((float)(round($tot_prc + $tot_svc, 1)), 2, '.', '') . ' (Unpaid)</h4>';
							echo '</div>';

							echo '<div class="row">';
							echo '<p class="col text-center ">Pay by Cash. </p>';
						}
						echo '</div>';

						echo '<div class="row pb-5">';
						echo '<small class="col text-center text-muted">Note: Please ready small changes and follow exact total price.</div>';
						echo '</small>';
					} else {
						echo '<div class="row border-top py-3">';
						echo '<div class="col"> No item has been ordered.</div>';
						echo '</div>';
					}
				} else {
					echo '<div class="row border-top py-3">';
					echo '<div class="col"> No item has been ordered.</div>';
					echo '</div>';
				}
				?>
			</div>
		</div>
	</div>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
<footer id="dk-footer" class="dk-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-4">
                    <div class="dk-footer-box-info">
                        <a href="index.html" class="footer-logo">
                            <img src="https://cdn.pixabay.com/photo/2016/11/07/13/04/yoga-1805784_960_720.png" alt="footer_logo" class="img-fluid">
                        </a>
                        <p class="footer-info-text">
                        Foodbox: Savor the Moment, We Deliver the Flavor
                        </p>
                        <div class="footer-social-link">
                            <h3>Follow us</h3>
                            <ul>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-google-plus"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-linkedin"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-instagram"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- End Social link -->
                    </div>
                    <!-- End Footer info -->
                    <div class="footer-awarad">
                        <img src="images/icon/best.png" alt="">
                        <p>FoodBox</p>
                    </div>
                </div>
                <!-- End Col -->
                <div class="col-md-12 col-lg-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="contact-us">
                                <div class="contact-icon">
                                    <i class="fa fa-map-o" aria-hidden="true"></i>
                                </div>
                                <!-- End contact Icon -->
                                <div class="contact-info">
                                    <h3>Welcome</h3>
                                    <p>5252 Hamamm Sousse</p>
                                </div>
                                <!-- End Contact Info -->
                            </div>
                            <!-- End Contact Us -->
                        </div>
                        <!-- End Col -->
                        <div class="col-md-6">
                            <div class="contact-us contact-us-last">
                                <div class="contact-icon">
                                    <i class="fa fa-volume-control-phone" aria-hidden="true"></i>
                                </div>
                                <!-- End contact Icon -->
                                <div class="contact-info">
                                    <h3>25 456 852</h3>
                                    <p>Give us a call</p>
                                </div>
                                <!-- End Contact Info -->
                            </div>
                            <!-- End Contact Us -->
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Contact Row -->
                    <div class="row">
                        <div class="col-md-12 col-lg-6">
                            <div class="footer-widget footer-left-widget">
                                <div class="section-heading">
                                    <h3>Useful Links</h3>
                                    <span class="animate-border border-black"></span>
                                </div>
                                <ul>
                                    <li>
                                        <a href="#">About us</a>
                                    </li>
                                    <li>
                                        <a href="#">Services</a>
                                    </li>
                                    <li>
                                        <a href="#">Projects</a>
                                    </li>
                                    <li>
                                        <a href="#">Our Team</a>
                                    </li>
                                </ul>
                                <ul>
                                    <li>
                                        <a href="#">Contact us</a>
                                    </li>
                                    <li>
                                        <a href="#">Blog</a>
                                    </li>
                                    <li>
                                        <a href="#">Testimonials</a>
                                    </li>
                                    <li>
                                        <a href="#">Faq</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- End Footer Widget -->
                        </div>
                        <!-- End col -->
                        <div class="col-md-12 col-lg-6">
                            <div class="footer-widget">
                                <div class="section-heading">
                                    <h3>Subscribe</h3>
                                    <span class="animate-border border-black"></span>
                                </div>
                                <form action="#">
                                    <div class="form-row">
                                        <div class="col dk-footer-form">
                                            <input type="email" class="form-control" placeholder="Email Address">
                                            <button type="submit">
                                                <i class="fa fa-send"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                <!-- End form -->
                            </div>
                            <!-- End footer widget -->
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>
                <!-- End Col -->
            </div>
            <!-- End Widget Row -->
        </div>
        <!-- End Contact Container -->


        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <span>Copyright © 2024, All Right Reserved FoodBox Team</span>
                    </div>
                    <!-- End Col -->
                    <div class="col-md-6">
                        <div class="copyright-menu">
                            <ul>
                                <li>
                                    <a href="#">Home</a>
                                </li>
                                <li>
                                    <a href="#">Terms</a>
                                </li>
                                <li>
                                    <a href="#">Privacy Policy</a>
                                </li>
                                <li>
                                    <a href="#">Contact</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- End col -->
                </div>
                <!-- End Row -->
            </div>
            <!-- End Copyright Container -->
        </div>
        <!-- End Copyright -->
        <!-- Back to top -->
        <div id="back-to-top" class="back-to-top">
            <button class="btn btn-dark" title="Back to Top" style="display: block;">
                <i class="fa fa-angle-up"></i>
            </button>
        </div>
        
</footer>
<style>

.footer-widget p {
    margin-bottom: 27px;
}
p {
    font-family: 'Nunito', sans-serif;
    font-size: 16px;
  color:white;
    line-height: 28px;
}

   .animate-border {
  position: relative;
  display: block;
  width: 115px;
  height: 3px;
  background: #007bff; }

.animate-border:after {
  position: absolute;
  content: "";
  width: 35px;
  height: 3px;
  left: 0;
  bottom: 0;
  border-left: 10px solid #fff;
  border-right: 10px solid #fff;
  -webkit-animation: animborder 2s linear infinite;
  animation: animborder 2s linear infinite; }

@-webkit-keyframes animborder {
  0% {
    -webkit-transform: translateX(0px);
    transform: translateX(0px); }
  100% {
    -webkit-transform: translateX(113px);
    transform: translateX(113px); } }

@keyframes animborder {
  0% {
    -webkit-transform: translateX(0px);
    transform: translateX(0px); }
  100% {
    -webkit-transform: translateX(113px);
    transform: translateX(113px); } }

.animate-border.border-white:after {
  border-color: #fff; }

.animate-border.border-yellow:after {
  border-color: #F5B02E; }

.animate-border.border-orange:after {
  border-right-color: #007bff;
  border-left-color: #007bff; }

.animate-border.border-ash:after {
  border-right-color: #EEF0EF;
  border-left-color: #EEF0EF; }

.animate-border.border-offwhite:after {
  border-right-color: #F7F9F8;
  border-left-color: #F7F9F8; }

/* Animated heading border */
@keyframes primary-short {
  0% {
    width: 15%; }
  50% {
    width: 90%; }
  100% {
    width: 10%; } }

@keyframes primary-long {
  0% {
    width: 80%; }
  50% {
    width: 0%; }
  100% {
    width: 80%; } } 

.dk-footer {
  padding: 75px 0 0;
  background-color: #151414;
  position: relative;
  z-index: 2; }
  .dk-footer .contact-us {
    margin-top: 0;
    margin-bottom: 30px;
    padding-left: 80px; }
    .dk-footer .contact-us .contact-info {
      margin-left: 50px; }
    .dk-footer .contact-us.contact-us-last {
      margin-left: -80px; }
  .dk-footer .contact-icon i {
    font-size: 24px;
    top: -15px;
    position: relative;
    color:#007bff; }

.dk-footer-box-info {
  position: absolute;
  top: -122px;
  background: #202020;
  padding: 40px;
  z-index: 2; }
  .dk-footer-box-info .footer-social-link h3 {
    color: #fff;
    font-size: 24px;
    margin-bottom: 25px; }
  .dk-footer-box-info .footer-social-link ul {
    list-style-type: none;
    padding: 0;
    margin: 0; }
  .dk-footer-box-info .footer-social-link li {
    display: inline-block; }
  .dk-footer-box-info .footer-social-link a i {
    display: block;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    text-align: center;
    line-height: 40px;
    background: #000;
    margin-right: 5px;
    color: #fff; }
    .dk-footer-box-info .footer-social-link a i.fa-facebook {
      background-color: #3B5998; }
    .dk-footer-box-info .footer-social-link a i.fa-twitter {
      background-color: #55ACEE; }
    .dk-footer-box-info .footer-social-link a i.fa-google-plus {
      background-color: #DD4B39; }
    .dk-footer-box-info .footer-social-link a i.fa-linkedin {
      background-color: #0976B4; }
    .dk-footer-box-info .footer-social-link a i.fa-instagram {
      background-color: #B7242A; }

.footer-awarad {
  margin-top: 285px;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-flex: 0;
  -webkit-flex: 0 0 100%;
  -moz-box-flex: 0;
  -ms-flex: 0 0 100%;
  flex: 0 0 100%;
  -webkit-box-align: center;
  -webkit-align-items: center;
  -moz-box-align: center;
  -ms-flex-align: center;
  align-items: center; }
  .footer-awarad p {
    color: #fff;
    font-size: 24px;
    font-weight: 700;
    margin-left: 20px;
    padding-top: 15px; }

.footer-info-text {
  margin: 26px 0 32px; }

.footer-left-widget {
  padding-left: 80px; }

.footer-widget .section-heading {
  margin-bottom: 35px; }

.footer-widget h3 {
  font-size: 24px;
  color: #fff;
  position: relative;
  margin-bottom: 15px;
  max-width: -webkit-fit-content;
  max-width: -moz-fit-content;
  max-width: fit-content; }

.footer-widget ul {
  width: 50%;
  float: left;
  list-style: none;
  margin: 0;
  padding: 0; }

.footer-widget li {
  margin-bottom: 18px; }

.footer-widget p {
  margin-bottom: 27px; }

.footer-widget a {
  color: #878787;
  -webkit-transition: all 0.3s;
  -o-transition: all 0.3s;
  transition: all 0.3s; }
  .footer-widget a:hover {
    color: #007bff; }

.footer-widget:after {
  content: "";
  display: block;
  clear: both; }

.dk-footer-form {
  position: relative; }
  .dk-footer-form input[type=email] {
    padding: 14px 28px;
    border-radius: 50px;
    background: #2E2E2E;
    border: 1px solid #2E2E2E; }
  .dk-footer-form input::-webkit-input-placeholder, .dk-footer-form input::-moz-placeholder, .dk-footer-form input:-ms-input-placeholder, .dk-footer-form input::-ms-input-placeholder, .dk-footer-form input::-webkit-input-placeholder {
    color: #878787;
    font-size: 14px; }
  .dk-footer-form input::-webkit-input-placeholder, .dk-footer-form input::-moz-placeholder, .dk-footer-form input:-ms-input-placeholder, .dk-footer-form input::-ms-input-placeholder, .dk-footer-form input::placeholder {
    color: #878787;
    font-size: 14px; }
  .dk-footer-form button[type=submit] {
    position: absolute;
    top: 0;
    right: 0;
    padding: 12px 24px 12px 17px;
    border-top-right-radius: 25px;
    border-bottom-right-radius: 25px;
    border: 1px solid #007bff;
    background: #007bff;
    color: #fff; }
  .dk-footer-form button:hover {
    cursor: pointer; }

/* ==========================

    Contact

=============================*/
.contact-us {
  position: relative;
  z-index: 2;
  margin-top: 65px;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
  -webkit-align-items: center;
  -moz-box-align: center;
  -ms-flex-align: center;
  align-items: center; }

.contact-icon {
  position: absolute; }
  .contact-icon i {
    font-size: 36px;
    top: -5px;
    position: relative;
    color: #007bff; }

.contact-info {
  margin-left: 75px;
  color: #fff; }
  .contact-info h3 {
    font-size: 20px;
    color: #fff;
    margin-bottom: 0; }

.copyright {
  padding: 28px 0;
  margin-top: 55px;
  background-color: #202020; }
  .copyright span,
  .copyright a {
    color: #878787;
    -webkit-transition: all 0.3s linear;
    -o-transition: all 0.3s linear;
    transition: all 0.3s linear; }
  .copyright a:hover {
    color:#007bff; }

.copyright-menu ul {
  text-align: right;
  margin: 0; }

.copyright-menu li {
  display: inline-block;
  padding-left: 20px; }

.back-to-top {
  position: relative;
  z-index: 2; }
  .back-to-top .btn-dark {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    padding: 0;
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #2e2e2e;
    border-color: #2e2e2e;
    display: none;
    z-index: 999;
    -webkit-transition: all 0.3s linear;
    -o-transition: all 0.3s linear;
    transition: all 0.3s linear; }
    .back-to-top .btn-dark:hover {
      cursor: pointer;
      background: #FA6742;
      border-color: #FA6742; }

</style>
	<script src="bootstrap/js/app.js"></script>

</body>

</html>