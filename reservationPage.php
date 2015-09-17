<?php
session_start();
?>
<html>
<body>
	<h1>Welcome to K-Town Car Service</h1>
	<form method="post">
		<input type="submit" name="logout" value="Log Out">
	</form>
	<h3>Reservation Page</h3>
	<p>Begin creating a reservation by selecting a location, the date</p>
	<p>and the time in which you would like to reserve. Not selecting</p>
	<p>a date and time will show currently available cars at your</p>
	<p>selected location.</p>
	<a href="memberHomePage.php">Home Page</a><br><br><br><br><br><br>
	<?php
	include('connectDB.php');
	$mem_num = $_SESSION['mem_num'];

	$sql = "select distinct location_address from location";
	$result = mysqli_query($cxn, $sql);
	if ($result->num_rows > 0) {
		echo "<form method='post'>";
		echo "Location: <select name='locations'>";
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<option value='" . $row['location_address'] . "'>" . $row['location_address'] . "</option>";
		}
		echo "</select><br><br>";
		echo "Date: <input type='text' name='res_date' placeholder='YYYY-MM-DD'><br><br>";
		echo "Time: <input type='text' name='pickup_time' placeholder='HH:MM'><br><br>";
		echo "<input type='submit' name='submit_resInfo' value='Submit'><br><br>";
		echo "</form>";
	}
		if (isset($_POST['submit_resInfo'])) {
			$location_address = $_POST['locations'];
			$res_date = $_POST['res_date'];
			$pickup_time = $_POST['pickup_time'] . ":00";
			$_SESSION['location_address'] = $location_address;
			$_SESSION['res_date'] = $res_date;
			$_SESSION['pickup_time'] = $pickup_time;
			if (empty($_POST['res_date'])) {
				$res_date = date("y-m-d");
				$_SESSION['res_date'] = $res_date;
			}
			if (empty($_POST['pickup_time'])) {
				date_default_timezone_set("America/Toronto");
				$pickup_time = date('h:i') . ":00";
				$_SESSION['pickup_time'] = $pickup_time;
			}
			echo "<form method='post'>";
			echo "Cars: <select name='cars'>";
			$sql = "select VIN, make, model, year from car where location_address = '$location_address'";
			$result = mysqli_query($cxn, $sql);
			if ($result->num_rows > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					echo "<option value='" . $row['VIN'] . "'>" . $row['make'] . " " . $row['model'] . " " . $row['year'] . "</option>";
				}
				echo "</select><br><br>";
				echo "<input type='submit' name='rent_car' value='Reserve Car'><br><br>";
				echo "</form>";
			}
		}
		if (isset($_POST['rent_car'])) {
			$res_date = $_POST['res_date'];
			$location_address = $_POST['location_address'];
			$pickup_time = $_POST['pickup_time'];
			$vin = $_POST['cars'];
			$sql = "insert into reservation values ('', '$mem_num', '$vin', '$res_date', '$pickup_time', '$location_address', '1', '0', '00:00:00')";
			mysqli_query($cxn, $sql);
			echo "Successfully rented car " . $vin;
		}
	//add a date picker and a time field
	//take that information and put it into a query
	//query to show all available cars (VIN, make, model) at location at date and time
		//if no time and date given, show current availability

			// select make, model, year, car.location_address from car, reservation
			// where car.location_address = $location_address and reservation.VIN = $vin
			// and status = '0' and not (reservation.res_date = $pickupDate) and not
			// (reservation.pickup_time = $pickupTime) and
			// reservation.location_address = car.location_address


	//have a way of choosing a car, click a button to make a reservation
	//query from member table to get mem_num
		//take this result, put it into $mem_num
	//query to insert reservation info ('', $mem_num, $vin, $date, $pickupTime
		// $locationAddress, $reservationLength)

		if (isset($_POST['logout'])) {
			session_destroy();
			header('location:loginPageHTML.php');
		}
	?>
</body>
</html>