<?php
session_start();
?>
<html>
<body>
	<h3>Sign Up For KTCS</h3>
	<p>Please enter your information in all fields.</p>
	<form method="post">
		Name: <input type="text" name="name"><br><br>
		Address: <input type="text" name="address"><br><br>
		Phone Number: <input type="text" name="phoneNumber"><br><br>
		Email: <input type="text" name="email"><br><br>
		Password: <input type="text" name="password"><br><br>
		License Number: <input type="text" name="licenseNum"><br><br>
		Credit Card Number: <input type="text" name="ccardNum"><br><br>
		Credit Card Expiry: <input type="text" name="ccardExpiry"><br><br>
		<input type="submit" name="submit" value="Submit">	
	</form>
	<form method="post">
		<input type="submit" name="cancel" value="Cancel">
	</form>
	<?php
	if (isset($_POST['submit'])) {
		$mem_num = '';
		$name = $_POST["name"];
		$address = $_POST["address"];
		$phoneNumber = $_POST["phoneNumber"];
		$email = $_POST["email"];
		$password = $_POST["password"];
		$licenseNum = $_POST["licenseNum"];
		$ccardNum = $_POST["ccardNum"];
		$ccardExpiry = $_POST["ccardExpiry"];
		$regAnniversary = date("Y-m-d");
		if (empty($name) || empty($address) || empty($phoneNumber) || empty($email) || empty($password) || empty($licenseNum) || empty($ccardNum) || empty($ccardExpiry)) {
			echo "Please fill in all fields.";
		}
		else {
			include('connectDB.php');
			$sql = "insert into member values ('', '$name', '$address', '$phoneNumber', '$email', '$password', '$licenseNum', '$ccardNum', '$ccardExpiry', '$regAnniversary')";
			mysqli_query($cxn, $sql);
			mysqli_close($cxn);
			header('location:loginPageHTML.php');
			//mysqli_close($cxn);
		}
	}
	if (isset($_POST['cancel'])) {
		session_destroy();
		header('location:loginPageHTML.php');
	}
	?>
</body> 
</html>