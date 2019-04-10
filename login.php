<?php
session_name("manager");
session_start();

//connect to database
define('host', 'localhost');
define('user', 'root');
define('password', '');
define('db', 'deliverades');

$con= mysqli_connect(host,user,password,db);

$error = "";
if($_SERVER["REQUEST_METHOD"] == "POST") {
	
      // username and password sent from form 
	  $myusername = mysqli_real_escape_string($con,$_POST['username']);
      $mypassword = mysqli_real_escape_string($con,$_POST['password']); 
      $sql = "SELECT username FROM managers WHERE username = '".$myusername."' AND password = '".$mypassword."'";
      $result = mysqli_query($con,$sql);

      

      // If result matched $myusername and $mypassword, table row must be 1 row
      if(mysqli_num_rows($result) == 1) {
		   $_SESSION['login_user'] = $myusername;
           header("location: sitemanager.php");

      }else {
		  $error = "Λάθος στοιχεία";
		  
      }

  }
?>


<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title> Login </title>

<style>
body{
    background-size: cover;	
}

h1{
	font-family: Papyrus;
}

form {
  position: absolute;
  box-sizing: border-box;
  padding: 35px;

}

.login-box{
width:220px;
height: 220px;
background: rgba(0,0,0,0.5);
position: relative;
margin: 3% auto;
box-sizing: border-box;
border-radius: 2px;
}


</style>

</head>

<body style="background-image:url('manager.jpg')">

<h1 align="center" > ΚΑΤΑΣΤΗΜΑΤΑ Deliverades</h1>
<hr>
<h3 align="center"> Σελίδα Διαχείρισης Καταστημάτων </h3 >

<div class="login-box">

<form action="" method="post">

Username:
<br>
<input type="text" name = "username" placeholder="Όνομα χρήστη">
<br>
Password:
<br>
<input type="password" name = "password" placeholder="Κωδικός">
<br><br>
<input type="submit" value="Login">
<br>
<br>

<?php echo "<font color='red'>$error</font>";?>

</form>
</div>


</body>
</html>