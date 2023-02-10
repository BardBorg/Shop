<?php
class Exists{
//Function for checking if SKU already taken.
    public function provide($sku)
	{

		
		$db = mysqli_connect("localhost", "root", "","scan");



		$sql = "SELECT * FROM doc WHERE SKU='$sku'";

		$results = mysqli_query($db, $sql);
		//If full-taken if empty-available
		if (mysqli_num_rows($results) > 0) {
			echo "taken";	

		}else{
			echo 'not_taken';
		}
		}

	}

$obj=new Exists();

$obj->provide($_POST["sku"]);