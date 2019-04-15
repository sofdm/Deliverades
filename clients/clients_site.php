<?php
session_name("client");
session_start();

  if(!isset($_SESSION['email'])){
      header("location: ./login.php");
   }
//connect to database
define('host', 'localhost');
define('user', 'root');
define('password', '');
define('db', 'deliverades');

$con= mysqli_connect(host,user,password,db);
mysqli_query($con, "SET NAMES 'utf8'");//for greek

$total =0;
$error = "";
if($_SERVER["REQUEST_METHOD"] == "POST") {
	
if((int)$_POST['Κέικ']==0&&(int)$_POST['Κουλούρι']==0&&(int)$_POST['Τοστ']==0&&(int)$_POST['Τυρόπιτα']==0&&(int)$_POST['Χορτόπιτα']==0&&(int)$_POST['Espresso']==0&&(int)$_POST['Cappuccino']==0&&(int)$_POST['Filter']==0&&(int)$_POST['Frappe']==0&&(int)$_POST['Greek-coffee']==0) {
$error = "Πρέπει να επιλέξεις το προίον και τη ποσότητα που επιθυμείς";
}

else{
	$proionta= ['Κέικ','Κουλούρι','Τοστ','Τυρόπιτα','Χορτόπιτα','Cappuccino','Espresso','Filter','Frappe','Greek-coffee'];
	for ($i = 0; $i <= 4; $i++){
		$_SESSION[$proionta[$i]]=(int)$_POST[$proionta[$i]];
	}	

	for ($i = 0; $i <= 9; $i++){
		$sql = "SELECT Price FROM products WHERE Name = '".$proionta[$i]."' ";
		$result = mysqli_query($con,$sql);
		$row=mysqli_fetch_array($result);
		$total = $total +(int)$_POST[$proionta[$i]] *$row['Price'];    
		$_SESSION['total']=$total ;
	}
	//echo $_SESSION['total'];

	header("location: completeorder.php");
}



}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title> WELCOME </title>
<style>

input[type=number]{
    width: 40px;
} 

p{
 font-size: 24px;	
}

table{
	background-size: cover;
	background-position: center;
}

#orders {   
    border-collapse: collapse;
	width: 50%;
margin-top: -15%;

}

#orders th {
    border-bottom:1px solid;
    padding: 10px;
}

#orders td {
border-bottom: 1px #ddd solid;
   padding-top: 12px;
    padding-bottom: 12px;
}

#orders tr:hover {background-color: #ddd;}

#orders th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
	background-color:white;
}

input[type="submit"] {
  width: 180px;
  height: 35px;
  background: #811305;
  border: none;
  border-radius: 2px;
  color: #FFF;
  font-family: 'Roboto', sans-serif;
  font-weight: 550;
  transition: 0.1s ease;
  cursor: pointer;
  font-size: 15px;
}



</style>
</head>

<body>


<p align="right"><a href="#logout" onclick="location.href = 'logout.php'"> LOG OUT </a> <!--redirect to login page --></p>

 <h1 align="center">ΠΑΡΑΓΓΕΙΛΕ ONLINE</h1>
<br>
 <h2 align="center">ΚΑΤΑΛΟΓΟΣ</h2>

  <form action="" method="post">
  <table align="center" id="orders" style="background-image:url('delivery15.jpg')"> 
 
    <thead>
   <tr>
    <th>ΚΑΦΕΣ</th>   
	<th>ΠΟΣΟΤΗΤΑ</th>  
   </tr>
    </thead>
	
	<tbody>
    <tr>
    <td> Ελληνικός </td>
    <td><input type="number" name="Greek-coffee" value="0" min="0"></td>
	<br>
	</tr> 
	
	<tr>
    <td> Φραπέ	</td>
    <td><input type="number" name="Frappe" value="0" min="0"></td>
	<br>
	</tr> 
	
	<tr>
    <td> Εσπρέσο</td>
    <td><input type="number" name="Espresso" value="0" min="0"></td>
	<br>
	</tr> 
	
	<tr>
    <td> Καπουτσίνο</td>
    <td><input type="number" name="Cappuccino" value="0" min="0"></td>
	<br>
	</tr> 

	<tr>
    <td> Φίλτρου</td>
    <td><input type="number" name="Filter" value="0" min="0"></td>
	<br>
	</tr> 	
   </tbody>

    <thead>
    <tr>
    <th>ΜΙΚΡΑ ΓΕΥΜΑΤΑ</th>  
	<th></th>	
    </tr>
    </thead>
	
	<tbody>
    <tr>
    <td> Τυρόπιτα </td>
    <td><input type="number" name="Τυρόπιτα" value="0" min="0"></td>
	<br>
	</tr> 
	
	<tr>
    <td> Χορτόπιτα</td>
    <td><input type="number" name="Χορτόπιτα" value="0" min="0"></td>
	<br>
	</tr> 
	
	<tr>
    <td> Κουλούρι</td>
    <td><input type="number" name="Κουλούρι" value="0" min="0"></td>
	<br>
	</tr> 
	
	<tr>
    <td>Τοστ</td>
    <td><input type="number" name="Τοστ" value="0" min="0"></td>
	<br>
	</tr> 

	<tr>
    <td>Κέικ</td>
    <td><input type="number" name="Κέικ" value="0" min="0"></td>
	<br>
	</tr> 	
    </tbody> 
	</table>   
     <br>
	 <br>
	 <div align="center">
	<input type="submit" name="done" value="Παραγγελία" />
	<br>
	<br>
	</div>
	<div align=center><?php echo "<font color='red'>$error</font>";?></div>
	</form>


</body>
</html>
