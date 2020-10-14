<?php
//fetch.php
$con=mysqli_connect('localhost','root','','ville');
$output = '';
if(isset($_POST["query"]))
{
 $search = mysqli_real_escape_string($con, $_POST["query"]);
 $query = "
  SELECT * FROM ville 
 LIKE '%".$search."%'
  
 ";
}
else
{
 $query = "
 SELECT * FROM ville 
 ";
}

?>