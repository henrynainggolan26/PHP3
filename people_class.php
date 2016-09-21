<?php
	include_once 'people_db.php';
	$con = new DB_con();
	if(isset($_GET['edit_id'])){
		$editid = $_GET['edit_id'];
		$sql = $con->select_update($editid);
		$result = mysqli_fetch_array($sql);
		if (!$sql) {
			die("Error: Data not found..");
		}
		$firstname=$result['first_name'] ;
		$lastname= $result['last_name'] ;					
		$gender=$result['gender'] ;
		$email=$result['email'] ;
		$phone=$result['phone_number'] ;
		$address=$result['address'] ;
?>
	<form action="" method="post">
		First Name: <input type="text" name="firstname" value="<?php echo $firstname ?>"><br /><br />
		Last Name: <input type="text" name="lastname" value="<?php echo $lastname ?>"><br /><br />
		Gender: <input type="radio" name="gender" value="male" <?php echo $gender == 'male' ? 'checked="checked"' : '';?>> male <input type="radio" name="gender" value="female" <?php echo $gender == 'female' ? 'checked="checked"' : '';?>> female <br /><br />
		E-mail: <input type="email" name="email" value="<?php echo $email?>"><br /><br />
		Phone: <input type="text" name="phone" value="<?php echo $phone?>"><br /><br />
		Address: <input type="text" name="address" value="<?php echo $address?>"><br /><br />
		<input type="submit" name="save" value="SAVE">
	</form>
<?php
	} 
	else {
?>
	<form action="" method="post">
		First Name: <input type="text" name="firstname" size="20" value="<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : '';?>"><br /><br />
		Last Name:  <input type="text" name="lastname" size="20" value="<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : '';?>"><br /><br />
		Gender   :  <input type="radio" name="gender" value="male" <?php if (isset($_POST['gender']) && $_POST['gender'] == 'male') {echo 'checked="checked"';} ?>> male <input type="radio" name="gender" value="female" <?php if (isset($_POST['gender']) && $_POST['gender'] == 'female') {echo 'checked="checked"';} ?>> female <br /><br />
		E-mail   :  <input type="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '';?>"><br /><br />
		Phone:      <input type="text" name="phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : '';?>"><br /><br />
		Address:    <input type="text" name="address" value="<?php echo isset($_POST['address']) ? $_POST['address'] : '';?>"><br /><br />
		<input type="submit" name="submit" value="CREATE">
	</form>
<?php
	}
?>

<?php
	include_once 'people_db.php';
	$con = new DB_con();

	//show data
	$result = $con->select();
	echo "<table border='1' cellpadding='10'>"; 
	echo "<tr> <th> First Name </th> <th> Last Name </th>  <th> Gender </th> <th> Email </th> <th> Phone</th> <th> Address </th> <th> Action </th></tr>";
	while ($test = mysqli_fetch_array($result)) {
		$id = $test['id'];
		echo "<tr align='left'>";	
		echo"<td><font color='black'>" .$test['first_name']."</font></td>";
		echo"<td><font color='black'>" .$test['last_name']."</font></td>";
		echo"<td><font color='black'>". $test['gender']. "</font></td>";
		echo"<td><font color='black'>". $test['email']. "</font></td>";
		echo"<td><font color='black'>". $test['phone_number']. "</font></td>";
		echo"<td><font color='black'>". $test['address']. "</font></td>";	
		echo"<td> <a href ='people_class.php?edit_id=$id'> Edit</a> <a href ='people_class.php?delete_id=$id'><center>Delete</center></a>";
		echo "</tr>";
	}
	echo "</table>";

	//insert data
	if(isset($_POST['submit'])){
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$gender = $_POST['gender'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$address = $_POST['address'];

		if($firstname && $lastname && $gender && $email  && $address != "" && is_numeric($phone)){
			$con->insert($firstname, $lastname, $gender, $email, $phone, $address);
			header("Refresh:0");
		}
		else if(!is_numeric($phone) && ($firstname && $lastname && $gender && $email  && $address != "")){
			echo "Correct phone number (0-9)";
		}
		else if($firstname || $lastname || $gender || $email || $phone || $address == ""){
			echo "Correct input";
		}			
	}

	//delete data
	if(isset($_GET['delete_id'])){
		$id = $_GET['delete_id'];
		$res = $con->delete($id);
		header('Location: people_class.php');
	}
	
	//edit data
	if(isset($_POST['save'])){
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$gender = $_POST['gender'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$address = $_POST['address'];

		if($firstname && $lastname && $gender && $email && $address != "" && is_numeric($phone)){
			$res=$con->update($editid, $firstname, $lastname, $gender, $email, $phone, $address);
			header('Location: people_class.php');
		}
		else if(!is_numeric($phone) && ($firstname && $lastname && $gender && $email  && $address != "")){
			echo "Correct phone number (0-9)";
		}
		else if($firstname || $lastname || $gender || $email || $phone || $address == ""){
			echo "Correct input";
		}		
	}
?>