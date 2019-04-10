
<?php 
session_name("manager");
session_start();

//connect to database
$con= mysqli_connect("localhost","root","","deliverades");
mysqli_query($con, "SET NAMES 'utf8'"); //greek

  if(!isset($_SESSION['login_user'])){ //must first login
      header("location: ./login.php");
   }
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

 

<style>
body{
	font-family: sens-serif;
}


.sidenav {
    height: 100%;
    width: 200px;
    position: fixed;
    top: 110;
    left: 0;
    background-color: #116760;
    padding-top: 70px;
	padding-left: 0px;
}

.sidenav a {
    padding: 4px 10px 4px 4px;
    font-size: 20px;
    color: #F4F4E6;
    display: block;
	text-decoration:none;
}

.sidenav a:hover {
    color: #400505;
}


.sidenavcontent{
	
	margin-left: 200px; /* Same as the width of the sidenav */
    font-size: 28px; /* Increased text to enable scrolling */
    padding: 0px 10px;
}

@media screen and (max-height: 450px) {
    .sidenav {padding-top: 15px;}
    .sidenav a {font-size: 18px;}
}

input[type=number]{
    width: 50px;
} 

table {
	text-align: left;	
    height: 40%;
	background-color:#f5f5f5;
    padding: 20px 70px; 	
}

th {
    height: 50px;
	font-size: 18px;
	color: #400505;	
}

.button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 10px 24px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    margin: 6px 4px;
    cursor: pointer;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.4s;
}
.button2:hover {
    box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24),0 17px 50px 0 rgba(0,0,0,0.19);
}
</style>

<title> Σελίδα Διαχείρισης Καταστημάτων </title>
</head>

<body>
<!-- emfanish onomatos katastimatos-->
<h1 align=center> 
<?php 
$sql="SELECT * FROM stores INNER JOIN managers ON stores.manager_afm_fk= managers.ΑΦΜ WHERE username = '".$_SESSION['login_user']."'";
$result = mysqli_query($con,$sql);
 $row=mysqli_fetch_array($result);
 echo $row['Name'];
 $_SESSION['store'] = $row['Name'];
?>
</h1>

<!-- emfanish onomatos ypeuthinou-->
<h3 align=center> Υπεύθυνος
<?php 
 $sql ="SELECT * FROM `managers` WHERE username = '".$_SESSION['login_user']."' ";
 $result = mysqli_query($con,$sql);
 $row=mysqli_fetch_array($result);
 echo $row['Όνομα'];
 echo "&nbsp";
 echo $row['Επώνυμο'];
 echo "<br>";
?>
</h3>

<hr>

<!-- CREATE navigation Tabs -->
<div class="sidenav" align=center>
  <a href="#stock" onclick="MyFunction('stock')" id="defaultOpen"> ΑΠΟΘΕΜΑ ΚΑΤΑΣΤΗΜΑΤΟΣ</a>
   <br>
  <a href="#orders" onclick="MyFunction('orders')"> ΠΑΡΑΓΓΕΛΙΕΣ ΚΑΤΑΣΤΗΜΑΤΟΣ</a>
  <hr style="height:120pt; visibility:hidden;" /> <!--instead of <br> -->
  <a href="#logout" onclick="location.href = 'logout.php'"> LOG OUT </a> <!--redirect to logout page -->
</div>


<!-- navigation content for apothema katastimatos-->

<!-- gia ananevsh timvn sthn vash dedomenvn-->
<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
  $keik = (int) $_POST['keik'];
  $koulouri = (int) $_POST['koulouri'];
  $tost = (int) $_POST['tost'];
  $tyropita = (int) $_POST['tyropita'];
  $xortopita = (int) $_POST['xortopita'];
      $sql = "UPDATE stock SET amount='$keik' WHERE NameOfStore_fk = '".$_SESSION['store']."' AND NameOfProduct_fk='Κέικ'"; 
	  $result = mysqli_query($con,$sql);
      $sql = "UPDATE stock SET amount='$koulouri' WHERE NameOfStore_fk = '".$_SESSION['store']."' AND NameOfProduct_fk='Κουλούρι'";  
	  $result = mysqli_query($con,$sql);
      $sql = "UPDATE stock SET amount='$tost' WHERE NameOfStore_fk = '".$_SESSION['store']."' AND NameOfProduct_fk='Τοστ'";
	  $result = mysqli_query($con,$sql);
      $sql = "UPDATE stock SET amount='$tyropita' WHERE NameOfStore_fk = '".$_SESSION['store']."' AND NameOfProduct_fk='Τυρόπιτα'";  
	  $result = mysqli_query($con,$sql);
      $sql = "UPDATE stock SET amount='$xortopita' WHERE NameOfStore_fk = '".$_SESSION['store']."' AND NameOfProduct_fk='Χορτόπιτα'";	  
      $result = mysqli_query($con,$sql);
	  echo '<script language="javascript">';
	  echo 'alert("Τα αποθέματα ανανεώθηκαν")';
	  echo '</script>'; 
}
 ?>
 
<!-- gia emfanish tvn timwn twn apothematvn-->
<?php 
$sql="SELECT * FROM stock WHERE NameOfStore_fk = '".$_SESSION['store']."'";
$result = mysqli_query($con,$sql);
 $arr = array();
	if(mysqli_num_rows($result) != 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$arr[$row["NameOfProduct_fk"]] = $row["amount"];
		}
	}
?>

<div id="stock" class="sidenavcontent" align=center>
<form action="" method="post" ">   
<table style="width:40%"> 
   <thead>
   <tr>
    <th>Προϊόν</th>
    <th>Απόθεμα</th> 
  </tr>
    </thead>
	    <tbody>
  <tr>
    <td> Κέικ </td>
    <td><input type="number" name="keik" value="<?php  echo $arr['Κέικ'];?>"></td>
  </tr> 
 
    <tr>
    <td> Κουλούρι </td>
    <td><input type="number" name="koulouri" value="<?php  echo $arr['Κουλούρι'];?>"></td>
	<br>
  </tr> 
  
    <tr>
    <td> Τοστ</td>
    <td><input type="number" name="tost" value="<?php  echo $arr['Τοστ'];?>"></td>
  </tr> 
	
    <tr>
    <td> Τυρόπιτα </td>
    <td><input type="number" name="tyropita" value="<?php  echo $arr['Τυρόπιτα'];?>"></td>
  </tr> 
	
    <tr>
    <td> Χορτότoπιτα </td>
    <td><input type="number" name="xortopita" value="<?php  echo $arr['Χορτόπιτα'];?>"></td>
  </tr> 
      </tbody>
	  </table>
	  <br>
	  <button class="button button2">Ανανέωση αποθέματος</button>
</form>


</div>


<?php 
$sql="SELECT * FROM orders WHERE StoreName= '".$_SESSION['store']."'";
$result = mysqli_query($con,$sql);
 $order = array();
	if(mysqli_num_rows($result) != 0) {
		while($row = mysqli_fetch_assoc($result)) {
				$order[] = $row;
		}
		}
?>

<div id="orders" class="sidenavcontent">
<h4 align=center>Παραγγελίες προς παράδοση</h4>
<table align="center" style="width:55%"> 
   <thead>
   <tr>
    <th>Κωδικός Παραγγελίας</th>
    <th>Διεύθυνση Παράδοσης</th>
	<th>Ποσό Παραγγελίας</th>
  </tr>
	
	<?php  foreach($order as $row): ?>
        <tr>
            <td>Παραγγελία#<?=$row['id'];?></td>
            <td><?=$row['Address'];?></td>
			<td><?=$row['Price'];?></td>
        </tr>
	<?php endforeach;?>	
    </thead>
</div>


<!-- navigation orders,stock-->
<script>
function MyFunction(idcontent) {
    var i, sidenavcontent, sidenav;
    sidenavcontent = document.getElementsByClassName("sidenavcontent");
    for (i = 0; i < sidenavcontent.length; i++) {
        sidenavcontent[i].style.display = "none";
    }
    document.getElementById(idcontent).style.display = "block"; //show the sidenavcontent that you clicked on
	//if (idcontent=='orders'){
		
	//}
}
// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>




</body>
</html>