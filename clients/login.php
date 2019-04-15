<?php
session_name("client");
session_start();

//connect to database
define('host', 'localhost');
define('user', 'root');
define('password', '');
define('db', 'deliverades');

$con= mysqli_connect(host,user,password,db);

$error ="";

if($_SERVER["REQUEST_METHOD"] == "POST") {
	
	//for sign out
	if (array_key_exists('phone',$_POST)) {
	  $myemail = mysqli_real_escape_string($con,$_POST['email']);
	  $_SESSION['email'] = $myemail;
      $mypassword = mysqli_real_escape_string($con,$_POST['password']);
	  $myphone = mysqli_real_escape_string($con,$_POST['phone']);		  
	  $sql ="INSERT INTO clients(email, phone, password) VALUES ('".$myemail."','".$myphone."','".$mypassword."')";	
	  $result = mysqli_query($con,$sql);
	  header("location: clients_site.php");
	}

//for sign in
	else{
	  // email and password sent from form 
	  $myemail = mysqli_real_escape_string($con,$_POST['email']);
	  $_SESSION['email'] = $myemail;
      $mypassword = mysqli_real_escape_string($con,$_POST['password']); 
      $sql = "SELECT email FROM clients WHERE email= '".$myemail."' and password = '".$mypassword."'";
      $result = mysqli_query($con,$sql);

      // If result matched $myemail and $mypassword, table row must be 1 row
      if(mysqli_num_rows($result) == 1) {
           header("location: clients_site.php");

      }else {
		  $error = "Λάθος στοιχεία";		  
      }	
}
}

?>


<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title> DELIVERADES </title>
<style>

body {
  margin: 0;
  padding: 0;
  background: #DDD;
  font-size: 16px;
  color: #222;
  font-family: 'Roboto', sans-serif;
  font-weight: 300;

}
h3{
	font-family: Papyrus;
}

#login-box {
  position: relative;
  margin: 3% auto;
  width: 600px;
  height: 350px;
  background: #FFF;
  border-radius: 2px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
}

.left {

  position: absolute;
  top: 0;
  left: 0;
  box-sizing: border-box;
  padding: 40px;
  width: 300px;
  height: 350px;
  background-size: cover;
  background-position: center;


}

h1 {
  margin: 0 0 20px 0;
  font-weight: 300;
  font-size: 28px;
}

input[type="text"],
input[type="password"],
input[type="tel"] {
  display: block;
  box-sizing: border-box;
  margin-bottom: 20px;
  padding: 4px;
  width: 220px;
  height: 32px;
  border: none;
  border-bottom: 1px solid #AAA;
  font-family: 'Roboto', sans-serif;
  font-weight: 400;
  font-size: 15px;
  transition: 0.2s ease;
}



input[type="submit"] {
  margin-top: 12px;
  width: 120px;
  height: 32px;
  background: #16a085;
  border: none;
  border-radius: 2px;
  color: #FFF;
  font-family: 'Roboto', sans-serif;
  font-weight: 500;
  text-transform: uppercase;
  transition: 0.1s ease;
  cursor: pointer;
}

input[type="submit"]:hover,
input[type="submit"]:focus {
  opacity: 0.8;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
  transition: 0.1s ease;
}


.or {
  position: absolute;
  top: 120px;
  left: 280px;
  width: 45px;
  height: 45px;
  background: #DDD;
  border-radius: 50%;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
  line-height: 40px;
  text-align: center;
}

.right {
  position: absolute;
  top: 0;
  right: 0;
  box-sizing: border-box;
  padding: 40px;
  width: 300px;
  height: 350px;
  border-radius: 0 2px 2px 0; 
  background-size: cover;
  background-position: center;


}

.right .loginwith {

  display: block;
  margin-bottom: 40px;
  font-size: 28px;
  color: #FFF;
  text-align: center;
}


</style>
</head>

<body>
<br>
<h3 align="center">Welcome to DELIVERADES</h3>
<div id="login-box">
  <div class="left">
  <form action="" method="post">
    <h1 align="center">Sign in</h1>
<br>

    <input type="text" name="email" placeholder="E-mail" />
    <input type="password" name="password" placeholder="Password" />
    
    <input type="submit" name="signin_submit" value="Login" />
	<br>
	<br>
	<?php echo "<font color='red'>$error</font>";?>
	</form>
  </div>
  
  <div class="right" style="background-image:url('clients1.jpg')">
  <form action="" method="post">
    <h1 align="center" style="background-color:#872d21">Sign up</h1>


    <input type="text" name="email" placeholder="E-mail*" required/>
    <input type="password" name="password" placeholder="Password*" required/>
	<input type="tel" name="phone" placeholder="Phone number*" required/>
    <input type="submit" name="signup_submit" value="Sign me up" />
	</form>
  </div>
  <div class="or">OR</div>
</div>
</body>
</html>