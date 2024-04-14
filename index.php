<?php 

session_start();

// Check if user is not logged in, redirect to logout.php
if (!isset($_SESSION["email"])) {
    header("Location: /session/logout.php");
    exit();
}

include "include/header.php";
?>

<style>
    .container{
    margin-top:100px;
}

.counter-box {
	display: block;
	background: #f6f6f6;
	padding: 40px 20px 37px;
	text-align: center;    
    border-radius: 20px;
}

.counter-box p {
	margin: 5px 0 0;
	padding: 0;
	color: #909090;
	font-size: 18px;
	font-weight: 500
}

.counter-box i {
	font-size: 60px;
	margin: 0 0 15px;
	color: #d2d2d2;
}

.counter { 
	display: block;
	font-size: 32px;
	font-weight: 700;
	color: #666;
	line-height: 28px
}

.counter-box.colored {
      background: #3acf87;
}


.counter-box.colored p,
.counter-box.colored i,
.counter-box.colored .counter {
	color: #fff
}
</style>

<ul class="nav nav-tabs my-5">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="/">Home</a>
  </li>
  <li class="nav-item">
        <a class="nav-link" href="/graph.php">Graph View</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/monthstd.php">Monthly List</a>
    </li>
    <li class="nav-item">
        <a class="nav-link disabled" aria-disabled="true">Disabled</a>
    </li>
</ul>

<div class="container">
    
    <div class="row">

	<div class="four col-md-3 mb-5">
		<div class="counter-box">
        <i class="fa-duotone fa-user-graduate"></i>
			<span class="counter"><?php include "count/student.php"; ?></span>
			<p>Student List</p>
		</div>
	</div>
	<div class="four col-md-3 mb-5">
		<div class="counter-box">
        <i class="fa-solid fa-user-magnifying-glass"></i>
			<span class="counter"><?php include "count/review.php"; ?></span>
			<p>Review List</p>
		</div>
	</div>
	<div class="four col-md-3 mb-5">
		<div class="counter-box">
        <i class="fa-regular fa-microchip"></i>
			<span class="counter"><?php include "count/class.php" ?></span>
			<p>Class List</p>
		</div>
	</div>
	<div class="four col-md-3 mb-5">
		<div class="counter-box">
        <i class="fa-duotone fa-screen-users"></i>
			<span class="counter"><?php include "count/batch.php"; ?></span>
			<p>Batch List</p>
		</div>
	</div>
    <div class="four col-md-3 mb-5">
		<div class="counter-box">
        <i class="fa-duotone fa-user-tie"></i>
			<span class="counter"><?php include "count/admin.php"; ?></span>
			<p>Admin List</p>
		</div>
	</div>
    <div class="four col-md-3 mb-5">
		<div class="counter-box">
        <i class="fa-duotone fa-clock-rotate-left"></i>
			<span class="counter"><?php include "count/login.php"; ?></span>
			<p>Login List</p>
		</div>
	</div>
    <div class="four col-md-3 mb-5">
		<div class="counter-box">
        <i class="fa-duotone fa-comment"></i>
			<span class="counter"><?php include "count/feedback.php"; ?></span>
			<p>Feedback List</p>
		</div>
	</div>
    <div class="four col-md-3 mb-5">
		<div class="counter-box">
        <i class="fa-solid fa-message-arrow-down"></i>
			<span class="counter">0</span>
			<p>Contact List</p>
		</div>
	</div>
  </div>	
</div>

<?php include "include/footer.php"; ?>