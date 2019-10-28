<?php
require("db_connection.php");
global $connection;
$conn = $connection;
$error="";

    if(isset($_POST['signup'])) {
        if (isset($_POST['username'])) {
            $username = $_POST["username"];
        }
        if (isset($_POST['password'])) {
            $password = password_hash($_POST['password'],PASSWORD_BCRYPT);
        }
        if (isset($_POST['name'])) {
            $name = $_POST["name"];
        }
        if (isset($_POST['phone'])) {
            $phone = $_POST["phone"];
        }
        if (isset($_POST['email'])) {
            $email = $_POST["email"];
        }
        if (isset($_POST['gender'])) {
            $gender = $_POST["gender"];
        }
        if ($username == "" || $name == "" || $phone == "" || $email == "" || $gender == "" || $password == "") {
            if ($username == ""){
                $username_msg = "Enter username";
                header("Location: register.php?uername_msg=$username_msg");
            }

            if($name == ""){
                $name_msg = "Enter name";
                header("Location: register.php?name_msg=$name_msg");
            }

            if($phone == ""){
                $phone_msg = "Enter phone";
                header("Location: register.php?phone_msg=$phone_msg");
            }

            if($email == ""){
                $email_msg = "Enter email";
                header("Location: register.php?email_msg=$email_msg");
            }

            if($gender == ""){
                $gender_msg = "Enter gender";
                header("Location: register.php?gender_msg=$gender_msg");
            }

            if($password == ""){
                $password_msg = "Enter password";
                header("Location: register.php?password_    msg=$password_msg");
            }
        }
        else {
            $sql = "SELECT * FROM person where username='".$username."' or email='".$email."'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                    $msg = "User or email already exists";
                    header("Location: register.php?msg=$msg");
                }

            else {
                $sql = "INSERT INTO person (NAME,gender,username,email,pass,phone) VALUES ('".$name."','".$gender."','".$username."','".$email."','".$password."','".$phone."')";
                $conn->query($sql);
                header("location: login.php");
            }
        }

}

    if(isset($_POST['user'])) {
        $username = $_POST['user'];
        $query1 = "SELECT * FROM person where username='".$username."'";
        $result = $connection->query($query1);
        if($result->num_rows>0){
            echo "username already exists!!";

        }
    }

    if(isset($_POST['email'])) {
        $email = $_POST['email'];
        $query = "SELECT * FROM person where email='".$email."'";
        $result = $connection->query($query);

        if($result->num_rows){
            echo "email already exists!!";
        }
    }
$conn->close();

?>