<?php 
session_name("client");
session_start();
//connect to database
define('host', 'localhost');
define('user', 'root');
define('password', '');
define('db', 'deliverades');


$con= mysqli_connect(host,user,password,db);
mysqli_query($con, "SET NAMES 'utf8'");//for greek

$data =$_REQUEST["name"];
$place=$_REQUEST["placeaddress"];
$name = mysqli_real_escape_string($con, $data);

$i = 0;
$proionta= ['Κέικ','Κουλούρι','Τοστ','Τυρόπιτα','Χορτόπιτα'];

	for ($i = 0; $i <= 4; $i++){	
		$sql= "SELECT amount FROM stock WHERE NameOfProduct_fk= '".$proionta[$i]."' and NameOfStore_fk= '".$name."'";

		$result = mysqli_query($con,$sql);
		$row=mysqli_fetch_array($result);

		$newamount=$row['amount']- $_SESSION[$proionta[$i]];

		$sql= "UPDATE stock SET amount='".$newamount."' WHERE NameOfProduct_fk= '".$proionta[$i]."' and NameOfStore_fk= '".$name."'";
		$result=mysqli_query($con, $sql);	
			//echo $result;
		}	
		
$sql = "INSERT into orders (StoreName,Address,Price) VALUES ('".$name."','".$place."','".$_SESSION['total']."')";
$result=mysqli_query($con, $sql);
//echo '<script language="javascript">';
//echo 'alert("Η παραγγελία ολοκληρώθηκε")';
//echo '</script>'; 

?>