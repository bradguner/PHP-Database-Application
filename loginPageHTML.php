<?php
session_start()
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>
	<h1>K-Town Car Service</h1>
	<h3>Login</h3>
	<p> Login with your email and password for your KTCS account.</p>
    <form method="post">
    	Email: <input type="text" name="email"><br><br>
    	Password: <input type="text" name="password"><br><br>
    	<input type="submit" name="submit" value="Login">
    </form>
    <a href="signup.php">Sign Up</a>
	<?php
	if (isset($_POST['submit'])) {
		include('connectDB.php');
		
		$email = $_POST["email"];
		$password = $_POST["password"];
		$sql = "select * from member where email = '$email' and password = '$password'";
		mysqli_query($cxn, $sql);
		$result = $cxn->query($sql);
		mysqli_close($cxn);
		if ($result->num_rows > 0) {
			while ($row = mysqli_fetch_assoc($result)){
				$_SESSION['mem_num'] = $row['mem_num'];
			}
			if ($_SESSION['mem_num'] == 1) {
				header('location:adminHomePage.php');
			}
			else {
				header('location:memberHomePage.php');
			}
		}
		else {
			echo "<br> Please enter a valid username and password.";
		}
	}
	if (isset($_POST['signup'])) {
		header('location:signup.php');
	}
	?>

</body>
</html>