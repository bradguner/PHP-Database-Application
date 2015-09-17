<?php
session_start();
?>
<html>
<body>
	<h1>Welcome to K-Town Car Service</h1>
	<form method="post">
		<input type="submit" name="logout" value="Log Out">
	</form>
	<h3>Fleet Information Page</h3><br><br>
	<a href="adminHomePage.php">Home Page</a><br><br><br><br><br>

	<p>Add a car:</p>
	<form method='post'>
		Car Make: <input type='text' name='make' placeholder='Car Brand'><br><br>
		Car Model: <input type='text' name='model' placeholder='Car Model'><br><br>
		Car Year: <input type='text' name='year' placeholder='YYYY'><br><br>
		Location: <select name='location'>

	<?php
		
		include ('connectDB.php');
		$sql = "select location_address from location";
		$result = mysqli_query($cxn, $sql);
		if ($result->num_rows > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<option value='" . $row['location_address'] . "'>" . $row['location_address'] . "</option>";
			}
			echo "</select><br><br>";
		}
		echo "<input type='submit' name='enter_car' value='Add Car'>";
		echo "</form><br>";
		if (isset($_POST['enter_car'])) {
			if (!empty($make) && !empty($model) && !empty($year)) {
				$make = $_POST['make'];
				$model = $_POST['model'];
				$year = $_POST['year'];
				$location = $_POST['location'];
				$status = '1';
				$date = date('y-m-d');
				$sql = "insert into car values ('', '$make', '$model', '$year', '$location', '$status', '0', '0', '$date', '0')";
				mysqli_query($cxn, $sql);
				echo "Car has been added to the fleet.";
			}
			else {
				echo "Please enter text into all fields.";
			}
		}
		
	/*
	query to show all cars at selected location:
		put into a list of sorts
			select VIN, make, model, year, status, last_odometer, last_gas_level, last_maintenance_date from car where car.location_address = $location_address

	query to show car with most rentals
		select make, model, year, location_address, MAX(reservations) from (select COUNT(*) as reservations from reservation where dropoff_time is not null group by VIN) as reservation_count, reservation, car where reservation.VIN = car.VIN

	query to show car with least rentals
		select make, model, year, location_address, MIN(reservations) from (select COUNT(*) as reservations from reservation where dropoff_time is not null group by VIN) as reservation_count, reservation, car where reservation.VIN = car.VIN
	*/
		echo "<form method='post'>";
		echo "<input type='submit' name='highest' value='Car Highest Rentals'>";
		echo "</form><br><br>";
		echo "<form method='post'>";
		echo "<input type='submit' name='lowest' value='Car Lowest Rentals'></form><br><br>";
		if (isset($_POST['highest'])) {
			$sql = "select car.VIN, make, model, year, car.location_address, MAX(reservations) from (select COUNT(*) as reservations from reservation where not (dropoff_time = '00:00:00') group by VIN) as reservation_count, reservation, car where reservation.VIN = car.VIN";
			include ('connectDB.php');
			$result = mysqli_query($cxn, $sql);
			if ($result->num_rows > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					echo "Car with most rentals is:<br>";
					echo "Car " . $row['VIN'] . ": " . $row['make'] . " " . $row['model'] . " " . $row['year'] . " at " . $row['location_address'] . " with " . $row['MAX(reservations)'] . " reservations.<br><br>";
				}
			}
		}

		if (isset($_POST['lowest'])) {
			$sql = "select car.VIN, make, model, year, car.location_address, MIN(reservations) from (select COUNT(*) as reservations from reservation where not (dropoff_time = '00:00:00') group by VIN) as reservation_count, reservation, car where reservation.VIN = car.VIN";
			include('connectDB.php');
			$result = mysqli_query($cxn, $sql);
			if ($result->num_rows > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					echo "Car with least rentals is:<br>";
					echo "Car " . $row['VIN'] . ": " . $row['make'] . " " . $row['model'] . " " . $row['year'] . " at " . $row['location_address'] . " with " . $row['MIN(reservations)'] . " reservations.<br><br>";
				}
			}
		}
		if (isset($_POST['logout'])) {
			session_destroy();
			header('location:loginPageHTML.php');
		}
		echo "<h3>Cars with 5000 KM driven since last maintentance:</h3>";
		$sql = "select VIN, make, model, year, location_address from car where MOD(last_maintenance_odometer, last_odometer) > 4999";
		$result = mysqli_query($cxn, $sql);
		if ($result->num_rows > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				echo "Car " . $row['VIN'] . ": " . $row['make'] . " " . $row['model'] . " " . $row['year'] . " at " . $row['location_address'] . "<br>";
			}
		}
	?>
</body>
</html>