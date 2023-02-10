<?php
class Massd
{

  public function dele($ar)
  {
      $conn = new mysqli("localhost", "root", "","scan");
      
      if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
      };
      echo "Connected successfully";
      //json array contains the clicked id's.
      $array = json_decode($ar, true);

      print_r($array);

      $artr=implode(',', $array);

      $dele=mysqli_query($conn, "delete from doc where id IN ($artr)");

  }
}

$obj=new Massd();
//Passing array
$obj->dele($_POST['array']);
?>