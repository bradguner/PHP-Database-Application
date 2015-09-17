<?php
session_start();
?>
<html>
<body>
	<h1>Welcome to K-Town Car Service</h1>
	<form method="post">
		<input type="submit" name="logout" value="Log Out">
	</form>
	<h3>Member Home Page</h3>
	<?php
		$mem_num = $_SESSION['mem_num'];
		echo "Logged in as member: " . $mem_num;
		echo "<br>";
	?>
	<a href="reservationPage.php">Reservation</a><br>
	<a href="returnCarPage.php">Return A Car</a><br>
	<a href="memberCommentPage.php">Comment Board</a><br><br><br><br><br><br>
	<p>Here is your rental history:</p>
	<table>
		<tr>
			<th>Reservation Number&nbsp&nbsp&nbsp&nbsp</th>
			<th>Date&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
			<th>Location&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
			<th>Make&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
			<th>Model&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
			<th>Year&nbsp&nbsp&nbsp&nbsp</th>
	<?php
		$mem_num = $_SESSION["mem_num"];
		include('connectDB.php');
		$sql = "select res_num, res_date, reservation.location_address, make, model, year from reservation, car where mem_num = '$mem_num' and reservation.VIN = car.VIN and not (reservation.dropoff_time = '00:00:00')";
		mysqli_query($cxn, $sql);
		$result = $cxn->query($sql);
		if ($result->num_rows > 0) {
			while ($row = mysqli_fetch_assoc($result)){
				echo "<tr><td>".$row['res_num']."</td><td>".$row['res_date']."</td><td>".$row['location_address']."</td><td>".$row['make']."</td><td>".$row['model']."</td><td>".$row['year']."</td></tr>";
			}
		}
		else {
			echo "You have no rental history.";
		}

		if (isset($_POST['logout'])) {
			session_destroy();
			header('location:loginPageHTML.php');
		}
	?>
	</table>
	
</body>
</html>