<?php

//File for inserting data to DB.

abstract class Universal
{


        
        public static $host="localhost";
        public static $user="root";
        public static $pass="";
        public static $db="scan";
   
    
        abstract public function connect();
        abstract public function setValues($sku, $name, $price,$typeinfo);
   
}

$con=null;


class DVD extends Universal 
{
     

    
	public function connect()
	{
        global $con;
        
    
        $con=mysqli_connect(self::$host,self::$user,self::$pass,self::$db); 

    
   
	}
   
    public function setValues($sku, $name, $price,$typeinfo)
    {
      
        global $con;
        //Concatenate with appropriate formating
        $size="Size: ";
        $mb="MB";
        $type=$size . " " .$typeinfo . " " . $mb;
        //
        if(!empty($_POST["dvd"])){
            $insert=mysqli_query($con,"insert into doc(id,SKU, Name, Price, Type) values(default, '$sku', '$name','$price','$type')");
      }
        
    }

  

}

class Book extends Universal
{
    
	public function connect()
	{
        global $con;
        
	    $con=mysqli_connect(self::$host,self::$user,self::$pass,self::$db); 
	
	}

    
    
    public function setValues($sku, $name, $price,$typeinfo)
    {
            global $con;
            //Concatenate with appropriate formating
            $weight="Weight: ";
            $kg="KG";
            $type=$weight . " " .$typeinfo . " " . $kg;
        
        if(!empty($_POST["book"])){
            $insert=mysqli_query($con,"insert into doc (id, SKU, Name, Price, Type) values(DEFAULT, '$sku', '$name','$price','$type')");
        }
          
      }
    
}

class Furniture extends Universal
{
    
	public function connect()
    {
	
        global $con;
        
        $con=mysqli_connect(self::$host,self::$user,self::$pass,self::$db); 
        
        }

    
    
    public function setValues($sku, $name, $price,$typeinfo)
    {
        global $con;
        //Concatenate with appropriate formatting, setting the x sign between sizes, and cutting last unnecessary sign.
        $dim="Dimension: ";

        $result='';

        for ($i = 0; $i < strlen($typeinfo); $i += 2) {
             $result .= substr($typeinfo, $i, 2) . 'x';
        }

        $last=substr_replace($result,"", -1);

        $type=$dim . " " .$last;

        if(!empty($_POST["furniture"])){
            $insert=mysqli_query($con,"insert into doc (id, SKU, Name, Price, Type) values(DEFAULT, '$sku', '$name','$price','$type')");
        }
      
  }

}


   


$obj=new DVD();
$obj->connect();
$obj->setValues($_POST["sku"], $_POST["name"], $_POST["price"], $_POST["dvd"]);
$nob=new Book();
$nob->connect();
$nob->setValues($_POST["sku"], $_POST["name"], $_POST["price"], $_POST["book"]);
$bob=new Furniture();
$bob->connect();
$bob->setValues($_POST["sku"], $_POST["name"], $_POST["price"], $_POST["furniture"]);


