<?php
session_start();
?>
<html>
<body>
	<h1>Welcome to K-Town Car Service</h1>
	<form method="post">
		<input type="submit" name="logout" value="Log Out">
	</form>
	<h3>Return Car</h3>
	<p>Please enter the return date and time for a car that you have rented.</p>
	<a href="memberHomePage.php">Home Page</a>
	<!--<form method="post">
		Car: <input type="" name="vin"><br><br>
		Date Returned: <input type="text" name="dropoff_time" placeholder="HH:MM">
		<input type="submit" name="submit" value="Return Car">
	</form>-->
	<?php
		include('connectDB.php');
		$mem_num = $_SESSION['mem_num'];
		$date = date('y-m-d');
		$sql = "select res_num from reservation where mem_num = '$mem_num' and res_date = '$date' and dropoff_time = '00:00:00'";
		$result = mysqli_query($cxn, $sql);
		if ($result->num_rows > 0) {
			echo "<form method='post'>";
			echo "Reservation: <select name='reservation'>";
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<option value='" . $row['res_num'] . "'>" . $row['res_num'] . "</option>";
			}
			echo "</select><br><br>";
			echo "Return Time: <input type='text' name='dropoff_time' placeholder='HH:MM'><br><br>";
			echo "<input type='submit' name='submit' value='Return Car'>";
			echo "</form>";
		}
		else {
			echo "No outstanding reservations!";
		}
		if (isset($_POST['submit'])) {
			$res_num = $_POST['reservation'];
			$dropoff_time = $_POST["dropoff_time"] . ":00";
			if ($dropoff_time == ':00') {
				date_default_timezone_set("America/Toronto");
				$dropoff_time = date('h:i') . ":00";
			}
			$sql = "update reservation set dropoff_time = '$dropoff_time' where res_num = '$res_num'";
			mysqli_query($cxn, $sql);
			header('location:memberHomePage.php');
		}
		if (isset($_POST['logout'])) {
			session_destroy();
			header('location:loginPageHTML.php');
		}
	?>
</body>
</html>