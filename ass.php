<!DOCTYPE HTML>


<html>
<head>
<title> Assignment1 </title>
<meta charset="utf-8">
</head>

<style>
body{
  background-color: #DDDDDD ;
  text-align: center;
}
</style>


<body>


<?php

$servername = "127.0.0.1";
$username = "root";
$password = "root";
$dbname = "mydb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
$_SESSION["comment"]= "";

if (isset($_POST['Submit']) && $_POST["comment"]!= ""){
 $_SESSION["comment"]=$_POST['comment'];
 if(!isset($_POST['name']) || $_POST['name'] == ""){
   $_POST['name'] = "Unknow";
 }
 $query = "INSERT INTO `guestbook` (`id`, `name`, `comment`) VALUES (NULL,'".$_POST['name']."', '" . $_POST['comment'] . "')";
 if ($conn->query($query) === TRUE){
  $_SESSION['last_id'] = $conn->insert_id;

 } else {
   echo "Error:" .$sql . "<br>" . $conn->error;
 }
}

if (isset($_POST['Revise'])){
 $_SESSION["comment"]= $_POST['comment'];
 $query = "UPDATE guestbook SET name = '".$_POST['name']."' ,comment= '" .$_POST['comment'] . "'WHERE id=" . $_SESSION['last_id'];
 $conn->query($query);
}


// define variables and set to empty values
$name = $comment = "";


?>


<h2>Guestbook</h2>
<form method="post">
  Name:
  <br><br>
  <input type="text" name="name" value="<?php echo $_POST["name"] ?>"/>
  <br><br>
  Comment:
  <br><br>
  <textarea name="comment" rows="5" cols="40"><?php
  echo $_SESSION["comment"];
  ?></textarea>
  <br><br>
  <?php
  if ($_SESSION["comment"] != "")
    echo "<input type=\"submit\" name=\"Revise\" value=\"Revise\" />";
  else
    echo "<input type=\"submit\" name=\"Submit\" value=\"Submit\" />";
  ?>


</form>

<?php
 $query = "SELECT id, comment, name FROM guestbook";
 $results = $conn->query($query);
?>
<br/><br><br>

<?php
echo "<h2>The History:</h2>";
foreach($results as $result){
  echo $result['name']." <b>Says: </b>".$result['comment'];
  echo "<br/><br/>";
}
$conn->close();
?>


</body>
</html>
