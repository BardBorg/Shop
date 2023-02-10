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
    <button class="button-3" id="delete-product-btn" role="button">Mass delete</button>
    <button class="button-2" onclick="location.href='add-product.php';">Add</button>
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
        
        //New connection to DB. No need to call it.
        public function __construct()
        {

            $this->db=new DBC;
        }
        public function getDB() 
        {

            //Data variable holds all the retrieved data from DB.
            //Calling the select method and assign to data.
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
        echo "<div  class='grid-item' style='margin-bottom:5vw;'>$sku<br>$name<br>$price$<br>$type<br><input id='$ID' onClick='reply_click(this.id)' style='float:left; position:relative; top:-130px;visibility:visible;' class='delete-checkbox' type='checkbox'></div>";

    }

    ?>
</div>

<script>
var arr=[]

//Finding id of clicked element passing the id's to json array
//than passed to massd.php file where given ids are deleted.
function reply_click(clicked_id){
        


        document.getElementById("delete-product-btn").addEventListener("click", del)
        
    
        arr.push(clicked_id)
        console.log(arr)


function del(){

    var array_json = JSON.stringify(arr)
    //Passing array to file where is deleting logic.
    
        $.ajax({
        url: 'massd.php',
        type: 'POST',
        data: {
        'array': array_json


        },
        success: function(response){
        location.reload()
        
        }

        })
        
        
        }
            }
    
</script>
