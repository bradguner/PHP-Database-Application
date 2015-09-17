<?php
session_start();
?>
<html>
<body>
	<h1>Welcome to K-Town Car Service</h1>
	<form method="post">
		<input type="submit" name="logout" value="Log Out">
	</form>
	<h3>Comment Board</h3>
	<p>Comment types displayed will be of a specific car in our fleet, or on KTCS in general.</p>
	<a href="adminHomePage.php">Home Page</a><br><br><br><br><br>
	<table>
		<tr>
			<th>Comment Number&nbsp&nbsp&nbsp&nbsp</th>
			<th>Parent Comment&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
			<th>Member&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
			<th>Comment Type&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
			<th>Comment&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>
	<?php
		include('connectDB.php');
		$mem_num = $_SESSION['mem_num'];
		$sql = "select comment_num, parent_comment, mem_num, comment_type, comment.comment from comment";
		$result = mysqli_query($cxn, $sql);
		if ($result->num_rows > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				if ($row['mem_num'] == 1) {
					$member = "Administrator";
				}
				else {
					$member = "Member";
				}

				if ($row['comment_type'] == NULL) {
					$comType = "KTCS";
				}
				else {
					$comType = $row['comment_type'];
				}
				echo "<tr><td>".$row['comment_num']."</td><td>".$row['parent_comment']."</td><td>".$member."</td><td>".$comType."</td><td>".$row['comment']."</td></tr>";
			}
		}
		else {
			echo "No comments made yet. Please post a comment using the form!";
		}
		if (isset($_POST['logout'])) {
			session_destroy();
			header('location:loginPageHTML.php');
		}
	?>
	</table><br><br><br><br>
	<?php
		include ('connectDB.php');
		$mem_num = $_SESSION['mem_num'];
		$sql = "select VIN from car ascending";
		$result = mysqli_query($cxn, $sql);
		if ($result->num_rows > 0) {
			echo "<form method='post'>";
			echo "Comment on: <select name='comment_type'>";
			echo "<option value='KTCS'>KTCS</option>";
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<option value='" . $row['VIN'] . "'>" . $row['VIN'] . "</option>";
			}
			echo "</select><br><br>";
			echo "Parent Comment: <input type='text' name='parent_comment' placeholder='Comment Number'><br><br>";
			echo "Comment: <input type='text' name='comment' placeholder='Comment'><br><br>";
			echo "<input type='submit' name='submit_comment' value='Submit'><br><br>";
		}
		
		if (isset($_POST['submit_comment'])) {
			$parent_comment = $_POST['parent_comment'];
			$comment_type = $_POST['comment_type'];
			$comment = $_POST['comment'];
			if (!empty($comment)) {
				$sql = "insert into comment values ('', '$mem_num', '$comment_type', '$comment', '$parent_comment')";
				mysqli_query($cxn, $sql);
				header('location:adminHomePage.php');
			}
			else {
				echo "Please enter a comment!";
			}
		}
	?>
</body>
</html>