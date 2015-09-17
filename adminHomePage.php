<?php
session_start();
?>
<html>
<body>
	<h1>Welcome to K-Town Car Service</h1>
	<form method="post">
		<input type="submit" name="logout" value="Log Out">
	</form>
	<h3>Home Page</h3>
	<p>Logged in as: Administrator</p>
	<a href="fleetInfoPage.php">Fleet Information</a><br>
	<a href="adminReservationPage.php">Reservations</a><br>
	<a href="adminCommentPage.php">Comment Page</a><br><br><br><br><br><br>
	<p>Member Registration Anniversaries:</p>
	<p>Choose a date to see member registration anniversaries.</p>
	<p>Not choosing a date will select the current date.</p>
	<form method='post'>
		Date: <input type='text' name='date' placeholder='YYYY-MM-DD'><br><br>
		<input type='submit' name='submit_date' value='Select Date'>
	</form>
	<table>
		<tr>
			<th>Member Number&nbsp&nbsp&nbsp&nbsp</th>
			<th>Name&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
			<th>Address&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
			<th>Phone Number&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
	<?php
		$mem_num = $_SESSION['mem_num'];
		if (isset($_POST['submit_date'])) {
			if (empty($_POST['date'])) {
				$date = date('y-m-d');
			}
			else {
				$date = $_POST['date'];
			}
			include('connectDB.php');
			$sql = "select mem_num, name, address, phone_num from member where reg_anniversary_date = '$date'";
			$result = mysqli_query($cxn, $sql);
			if ($result->num_rows > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					echo "<tr><td>".$row['mem_num']."</td><td>".$row['name']."</td><td>".$row['address']."</td><td>".$row['phone_num']."</td></tr>";
				}
			}
			else {
				echo "No Members have their reservation anniversary today.";
			}
			
		}

		if (isset($_POST['logout'])) {
			session_destroy();
			header('location:loginPageHTML.php');
		}
	?>
</table>
</body>
</html>