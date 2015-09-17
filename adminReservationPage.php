<?php
session_start();
?> 
<html>
<body>
	<h1>Welcome to K-Town Car Service</h1>
	<form method="post">
		<input type="submit" name="logout" value="Log Out">
	</form>
	<h3>Reservation Information</h3>
	<a href="adminHomePage.php">Home Page</a><br><br><br>
	<h3>Show Reservations:</h3>
	<p>Not selecting a date will select the current date.</p>
	<form method='post'>
		Date: <input type='text' name='date' placeholder='YYYY-MM-DD'><br>
		<input type='submit' name='submit_date' value='Select Date'>
	</form><br>
	<table>
		<tr>
			<th>Reservation Number&nbsp&nbsp&nbsp&nbsp</th>
			<th>Member&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
			<th>Car&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
			<th>Date&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
			<th>Pickup Time&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
			<th>Location&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
			<th>Length&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
	<?php
	if (isset($_POST['submit_date'])) {
		if (empty($_POST['date'])) {
			$date = date('y-m-d');
		}
		else {
			$date = $_POST['date'];
		}
		include('connectDB.php');
		$sql = "select res_num, mem_num, VIN, res_date, pickup_time, location_address, res_length from reservation where res_date = '$date'";
		$result = mysqli_query($cxn, $sql);
		if ($result->num_rows > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<tr><td>".$row['res_num']."</td><td>".$row['mem_num']."</td><td>".$row['VIN']."</td><td>".$row['res_date']."</td><td>".$row['pickup_time']."</td><td>".$row['location_address']."</td><td>".$row['res_length']."</td></tr>";
			}
		}
	}
	/*
	$date = selected date from a date picker
	query to show all reservations on given day
		select res_num, mem_num, VIN, location_address, pickup_time, res_length
		from reservation where date = $date

	query to show all cars currently available on a certain day
		select car.VIN, make, mode, year, car.location_address, from car, reservation
		where car.location_address, = reservation.location_address
		and reservation.date = $date
	*/
		if (isset($_POST['logout'])) {
			session_destroy();
			header('location:loginPageHTML.php');
		}

	?>
</body>
</html>