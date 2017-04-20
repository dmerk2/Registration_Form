<?php
session_start();
$_SESSION['message'] = '';

$mysqli = new mysqli('localhost', 'root', 'mypass123', 'accounts');

// Cheking the 2 passwords are equal to eachother
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if ($_POST['password'] == $_POST['confirmpassword']) {

		print_r($_FILES); die;

		$username = $mysqli->mysql_real_escape_string($_POST['username']);
		$email = $mysqli->mysql_real_escape_string($_POST['email']);
		$password = md5($_POST['password']); //md5 is hash password
		$avatar_path = $mysqli->mysql_real_escape_string('image/'.$_FILES['avatar']['name']);

		//make sure file type is image
		if (preg_match("!image!", $_FILES['avatar']['type'])) {

			if (copy($_FILES['avatar']['tmp_name'], $avatar_path)) {

				$_SESSION['username'] = $username;
				$_SESSION['avatar'] = $avatar_path;

				$sql = "INSERT INTO users (username, email, password, avatar)"
				. "VALUES ('$username', '$email', 'password', 'avatar_path')";

				//If the query is successful than redirect to welcome page
				if ($mysqli-)query($sql === true) {
					$_SESSION['message'] = 'Registration successful! Added $username to the database';
					header("location: welcome.php");

				}
				else {
					$_SESSION['message'] = "User could not be added to the database!";
				}

			}
			else {
				$_SESSION['message'] = "File upload failed!";
			}

		}
		else {
			$_SESSION['message'] = "Please only upload GIF, PNG or JPG images!";
		}
	}
	$_SESSION['message'] = "Two passwords did not match!";
}
?>