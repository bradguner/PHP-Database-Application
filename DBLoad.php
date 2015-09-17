<html>
<head><title>Load Project Database</title></head>
<body>

	<?php
	/* Program: 332Project_load.php
	 * Desc:	creates and loads the company database tables with sample data
	 */

	$host = "localhost";
	$user = "root";
	$password = "okid2350";
	$database = "332Project";

	$cxn = mysqli_connect($host, $user, $password, $database);
	//check connection
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_errno();
		die();
	}

	mysqli_query($cxn, "Drop table car");
	mysqli_query($cxn, "Drop table member");
	mysqli_query($cxn, "Drop table reservation");
	mysqli_query($cxn, "Drop table location");
	mysqli_query($cxn, "Drop table comment");
	mysqli_query($cxn, "Drop table fee");

	mysqli_query($cxn, "CREATE TABLE car(
					VIN							INT(2)	 NOT NULL AUTO_INCREMENT,
					make 						CHAR(20) NOT NULL,
                  	model						CHAR(20) NOT NULL,
                  	year						YEAR(4)	 NOT NULL,
                  	location_address			CHAR(20) NOT NULL,
                  	status 						INT(1)	 NOT NULL,
                  	last_odometer				INT(7)	 NOT NULL,
                  	last_gas_level				INT(4)	 NOT NULL,
                  	last_maintenance_date		DATE 	 NOT NULL,
                  	last_maintenance_odometer	INT(7)	 NOT NULL,
                  	PRIMARY KEY(VIN));");
	echo "Done car";

	mysqli_query($cxn, "CREATE TABLE member(
					mem_num						INT(4)		NOT NULL AUTO_INCREMENT,
					name 						CHAR(50)	NOT NULL,
                  	address						CHAR(50)	NOT NULL,
                  	phone_num					CHAR(10)	NOT NULL,
                  	email						CHAR(100)	NOT NULL,
                  	password 					CHAR(20)	NOT NULL,
                  	license_num 				CHAR(20)	NOT NULL,
                  	ccard_num					CHAR(16)	NOT NULL,
                  	ccard_expiry				DATE		NOT NULL,
                  	reg_anniversary_date		DATE 		NOT NULL,
                  	PRIMARY KEY(mem_num));");
	echo "Done member";

	mysqli_query($cxn, "CREATE TABLE reservation(
					res_num						INT(2)		NOT NULL AUTO_INCREMENT,
					mem_num 					INT(4)		NOT NULL,
                  	VIN							INT(4)		NOT NULL,
                  	res_date					DATE		NOT NULL,
                  	pickup_time					TIME 		NOT NULL,
                  	location_address 			CHAR(20)	NOT NULL,
                  	res_length					INT(4)		NOT NULL,
                  	pickup_odometer				INT(7)		NOT NULL,
                  	dropoff_time				TIME 		NOT NULL,
                  	PRIMARY KEY(res_num));");
	echo "Done reservation";

	mysqli_query($cxn, "CREATE TABLE location(
					location_num				INT(2)		NOT NULL AUTO_INCREMENT,
					location_address			CHAR(50)	NOT NULL,
					location_spaces 			INT(4)		NOT NULL,
                  	PRIMARY KEY(location_num));");
	echo "Done location";

	mysqli_query($cxn, "CREATE TABLE comment(
					comment_num					INT(4)		NOT NULL AUTO_INCREMENT,
					mem_num 					INT(4)		NOT NULL,
					comment_type				INT(10),
					comment 					CHAR(255)	NOT NULL,
					parent_comment				INT(10),
                  	PRIMARY KEY(comment_num));");
	echo "Done comment";

	mysqli_query($cxn, "CREATE TABLE fees(
					annual						INT(4)		NOT NULL,
					hourly 						INT(4)		NOT NULL)
                  	");
	echo "Done fees";

	mysqli_query($cxn, "insert into car values
		('1', 'Honda', 'Accord', '2010', '1 Alfred Street', 0, 10000, 15, '2015-01-09', 6500),
		('2', 'Toyota', 'Camry', '2008', '1 Princess Street', 1, 20000, 30, '2014-12-27', 14000),
		('3', 'Ford', 'Focus', '2007', '1 Alfred Street', 2, 30000, 35, '2015-03-30', 30000),
		('4', 'Honda', 'Accord', '2006', '1 Princess Street', 1, 50000, 30, '2015-03-1', 48500)
		");

	mysqli_query($cxn, "insert into member values
		(0, 'me', '1', '1111111111', 'admin@admin.com', 'admin', '1', '1', '2000-01-01', '2000-01-01'),
		('', 'b', 'a', 'a', 'member@member.com', 'member', '1', '1', '2000-01-01', '2000-01-01')
		");

	mysqli_query($cxn, "insert into reservation values
		('', '2', '1', '2015-03-30', '9:00:00', '1 Alfred Street', '4', '10000', '13:00:00'),
		('', '2', '2', '2015-04-02', '9:00:00', '1 Princess Street', '3', '10000', 'NULL'),
		('', '2', '1', '2015-04-02', '9:00:00', '1 Princess Street', '3', '10000', 'NULL'),
		('', '2', '3', '2015-04-02', '9:00:00', '1 Alfred Street', '2', '10000', 'NULL'),
		('', '2', '3', '2015-04-05', '9:00:00', '1 Alfred Street', '2', '10000', 'NULL')
		");

	mysqli_query($cxn, "insert into location values
		('', '1 Alfred Street', '100'),
		('', '1 Princess Street', '100')
		"); 

	mysqli_query($cxn, "insert into comment values
		('', '2', '2', 'Great car!', NULL),
		('', '1', '2', 'Thank you!', '1')
		");

	echo "Done!";
	mysqli_close($cxn);
	?>
</body>
</html>