<html>
<body>
	<?php
	$host = "localhost";
	$user = "root";
	$password = "password";
	$database = "DB";

	$cxn = mysqli_connect($host, $user, $password, $database);
	//check connection
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_errno();
		die();
	}
	?>
</body>
</html>