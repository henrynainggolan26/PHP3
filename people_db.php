<?php
	class DB_con
	{
		var $conn = false;

		function __construct(){
			$this->conn = mysqli_connect("localhost", "root", "ssmaju", "test_wordpress");
			if(mysqli_connect_errno()){
				echo "error : Can't conncet to database";
			}
		}
		public function select(){
			$query = "SELECT * FROM people";
			$res=mysqli_query($this->conn, $query );
			return $res;
		}

		public function insert($firstname, $lastname, $gender, $email, $phone, $address){
			$query = "INSERT INTO people (first_name, last_name, gender, email, phone_number, address) 
			VALUES ('".$firstname."','".$lastname."','".$gender."','".$email."','".$phone."','".$address."')";
			$res = mysqli_query($this->conn, $query);
			return $res;

		}

		public function delete($id){
			$query = "DELETE FROM people WHERE id = '".$id."'";
			$res = mysqli_query($this->conn, $query);
			return $res;
		}

		public function select_update($id){
			$query = "SELECT * FROM people WHERE id = '".$id."'";
			$res = mysqli_query($this->conn, $query);
			return $res;
		}

		public function update($id, $fname, $lname, $gender, $email, $phone, $address){
			$query="UPDATE people SET first_name='$fname', last_name='$lname', gender='$gender', email='$email', phone_number='$phone', address='$address' WHERE id = '".$id."'";
			$res = mysqli_query($this->conn, $query);
			return $res;
		}
	}
?>