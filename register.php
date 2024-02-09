<?php
	
$showAlert = false;
$showError = false;
$exists=false;
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
	
	include 'koneksi.php';

	$nama = $_POST["nama"];
	$username = $_POST["username"];
	$password = $_POST["password"];
	$cpassword = $_POST["cpassword"];
	$alamat = $_POST["alamat"];
	$nohp = $_POST["nohp"];
			
	
	$sql = "Select * from customers where nama='$username'";
	
	$result = mysqli_query($conn, $sql);
	
	$num = mysqli_num_rows($result);
	if($num == 0) {
		if(($password == $cpassword) && $exists==false) {
				
			$sql = "INSERT INTO `customers` ( `nama`,`username`,
				`password`,`alamat`,`nohp`) VALUES ('$nama','$username','$password','$alamat','$nohp')";
	
			$result = mysqli_query($conn, $sql);
	
			if ($result) {
				$showAlert = true;
			}
		}
		else {
			$showError = "Passwords do not match";
		}	
	}// end if
	
if($num>0)
{
	$exists="Username not available";
}
	
}//end if
	
?>


<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> REGISTRASI BENGKEL </title> 
    <link rel="stylesheet" href="register.css">
   </head>
<body>
<?php
	
	if($showAlert) {
	
		echo ' <div class="alert alert-success
			alert-dismissible fade show" role="alert">
	
			<strong>Success!</strong> Your account is
			now created and you can login.
			<button type="button" class="close"
				data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div> ';
	}
	
	if($showError) {
	
		echo ' <div class="alert alert-danger
			alert-dismissible fade show" role="alert">
		<strong>Error!</strong> '. $showError.'
	
	<button type="button" class="close"
			data-dismiss="alert aria-label="Close">
			<span aria-hidden="true">×</span>
	</button>
	</div> ';
}
		
	if($exists) {
		echo ' <div class="alert alert-danger
			alert-dismissible fade show" role="alert">
	
		<strong>Error!</strong> '. $exists.'
		<button type="button" class="close"
			data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">×</span>
		</button>
	</div> ';
	}

?>
  <div class="wrapper">
    <h2>Registration2</h2>
    <form action="register.php" method="POST">
      <div class="input-box">
        <input type="text" name="nama" placeholder="Enter your name" required>
      </div>
      <div class="input-box">
        <input type="text" name="username" placeholder="Enter your username" required>
      </div>
      <div class="input-box">
        <input type="password" name="password" placeholder="Create password" required>
      </div>
      <div class="input-box">
        <input type="password" name="cpassword" placeholder="Confirm password" required>
      </div>
      <div class="input-box">
        <input type="text" name="alamat" placeholder="Enter your address" required>
      </div>
      <div class="input-box">
        <input type="text" name="nohp" placeholder="Enter your phone number" required>
      </div> -->
      <div class="input-box button">
        <input type="Submit" value="Register Now" name="submit">
      </div>
      <div class="text">
        <h3>Already have an account? <a href="login.php">Login now</a></h3>
      </div>
    </form>
  </div>
</body>
</html>