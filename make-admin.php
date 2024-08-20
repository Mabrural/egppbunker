<?php 
session_name("EGPPBUNKER_SESSION");
session_start();

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}
include 'koneksi.php';

$id_user = mysqli_real_escape_string($koneksi, $_GET["id_user"]);

if( makeAdmin($id_user) > 0 ){
    echo '<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css"></script>';
	echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
	echo '<script src="./sweetalert2.min.js"></script>';
	echo "<script>
	setTimeout(function () { 
		swal.fire({
			
			title               : 'Success',
			text                :  'User Successfully Granted Admin Access!',
			//footer              :  '',
			icon                : 'success',
			timer               : 2000,
			showConfirmButton   : true
		});  
	},10);   setTimeout(function () {
		window.location.href = 'manage-users.php'; //will redirect to your blog page (an ex: blog.html)
	}, 2000); //will call the function after 2 secs
	</script>";

} else {
    echo '<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css"></script>';
    echo '<link rel="stylesheet" href="./sweetalert2.min.css"></script>';
	echo '<script src="./sweetalert2.min.js"></script>';
	echo "<script>
	setTimeout(function () { 
		swal.fire({
			
			title               : 'Failed',
			text                :  'Failed to Grant Admin Access!',
			//footer              :  '',
			icon                : 'error',
			timer               : 2000,
			showConfirmButton   : true
		});  
	},10);   setTimeout(function () {
		window.location.href = 'manage-users.php'; //will redirect to your blog page (an ex: blog.html)
	}, 2000); //will call the function after 2 secs
	</script>";

 }

 ?>