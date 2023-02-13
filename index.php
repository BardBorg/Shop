<!DOCTYPE html>
<html lang="en">
<head>
<script
  src="https://code.jquery.com/jquery-3.6.1.js"
  integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
  crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="shop.css">
    <title>Home page</title>
</head>
<body>
    <div>
    <button class="button-3" id="delete-product-btn" onclick="del()">MASS DELETE</button>
    <button class="button-2" id="addition" onclick="redirect()">ADD</button>
    <h1>Product List</h1>
</div>
<hr>

<div class="grid-container">
    
    <?php

    class DBC{
    protected $con;

    public function __construct()
    {
        $this->db = new PDO("mysql:host=localhost;dbname=scan", "root", "");
    }

    public function select()
    {

        //Selecting everything from DB.
        $stmt=$this->db->query("SELECT * FROM doc");

        return $stmt->fetchAll();

        
    
        
    }

    }

    class Ret{

    protected $sku;

      
      //Creating constructors and getters for each data
    public function __construct($data){
        $this->id=$data['id'];
        $this->sku=$data['SKU'];
        $this->name=$data['Name'];
        $this->price=$data['Price'];
        $this->type=$data['Type'];
    }
    public function getID()
    {

        return  $this->id;
    }
    public function getSku()
    {

        return  $this->sku;
    }
    public function getName()
    {

    return  $this->name;
    }
    public function getPrice()
    {

        return  $this->price;
    }
    public function getType()
    {

        return  $this->type;
    }

    }
    class Manager{


        protected $db;
        
        //New connection to DB. No need to call the method.
        public function __construct()
        {

            $this->db=new DBC;
        }
        public function getDB() 
        {

            //Data variable holds all the retrieved data from DB.
            //Calling the select method and assign it to data.
            $data = $this->db->select();

            //Creating empty array for holding the values from table.
            $shop = array();

            //Looping through table and setting values to array
            //Shop now holds the data from Ret class.
            //Functions as rows.
            foreach($data as $row){
                $shop[] = new Ret($row);
            }
            return $shop;
        }
    }
    //New class object
    $Manager = new Manager();

    //Calling the getDB method from Manager, and setting output to variable.
    $output = $Manager->getDB();
    
    foreach($output as $item) {
        $ID= $item->getID();
        echo "<br>";
        $sku= $item->getSku();
        echo "<br>";
        $name= $item->getName();
        echo "<br>";
        $price= $item->getPrice();
        echo "<br>";
        $type= $item->getType();

        //Display products in grid with checkboxes.
       echo "<div class='grid-item'  style='margin-bottom:5vw;'>$sku<br>$name<br>$price$<br>$type<br><input id='$ID'  style='float:left; position:relative; top:-130px;' class='delete-checkbox' type='checkbox'></div>";


    }

    ?>
</div>

<script>
  
function redirect(){
    window.location.replace("add-product.php");
    
}    
  var arr=[]





function del(){
  
  
  //Checking which checkbox is actually checked
  //And creating array of ID's
  var checkboxes = document.querySelectorAll('.delete-checkbox');
   for (var i = 0; i < checkboxes.length; i++) {
    if (checkboxes[i].checked) {
        arr.push(checkboxes[i].id);
        }
     }

    var array_json = JSON.stringify(arr)
    //Passing array to file where is deleting logic.
    
        $.ajax({
        url: 'massd.php',
        type: 'POST',
        data: {
        'array': array_json


        },
        success: function(response){
        
        
        }

        })
        
        
        }
            }
    
</script>
