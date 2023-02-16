<!DOCTYPE html>
<html lang="en">
  <head>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adding products</title>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="shop.css">
  </head>
  <body>
    <div>
      <button class="button-3" id="new" role="button">Save</button>
      <button class="button-2" onclick="location.href='index.php';">Cancel</button>
      <h1>Product List</h1>
    </div>
    <hr>
   <div>
    <form id="product_form" method="post">
      <label for="fname">SKU</label><br>
      <input type="text" id="sku" name="sku"><br>
      <label for="fname">Name</label><br>
      <input type="text" id="name" name="name" required><br>
      <div id="notificationn"></div>
      <label for="fname">Price</label><br>
      <input type="text" id="price" name="price"><br><br>
      <div id="notificationp"></div>


    </form>
    <div id="app">
      <form v-if="form1" method="post">
        <label for="fname">Product-DVD</label><br><br>
        <label for="fname">Please provide DVD size in megabytes</label><br>
        <input type="text" id="size" name="dvd" @input="dvdinput"><label>MB</label><br><br><br>
        <div id="notifications"></div>


      </form>
      <form v-if="form2">
        <label for="fname">Product-Furniture</label><br><br>
        <label for="fname">Please provide dimension in HxWxL format.</label><br><br>
        <label for="Height">Height</label><br>
        <input type="text" id="height" name="furn" @input="hinput"><br>
        <div id="notificationh"></div>
        <label for="Width">Width</label><br>
        <input type="text" id="width" name="furn" @input="winput"><br>
        <div id="notificationw"></div>
        <label for="Length">Length</label><br>
        <input type="text" id="length" name="furn" @input="linput"><br><br>
        <div id="notificationl"></div></br>

      </form>
      <form v-if="form3">
        <label>Product-Book</label><br><br>
        <label>Please provide weight in kilograms</label><br>
        <input type="text" id="weight" name="book" @input="bookinput"><label>KG</label><br><br><br>
        <div id="notificationb"></div>


      </form>
        <label style="font-weight:bold;">Select another product</label>
        <br>
        <select v-model="selectedOption">
          <option id="productType" v-for="option in options" :key="option.value">{{ option.text }}</option>
        </select>
      </div>
    </div> 
  
  <script>
      //Vue component for selecting product type
      var app = new Vue({
        el: '#app',
        data() {
          return {
            selectedOption: '',
            form1: true,
            form2: false,
            form3: false,
            options: [{
              value: 'DVD',
              text: 'DVD'
            }, {
              value: 'Furniture',
              text: 'Furniture'
            }, {
              value: 'Book',
              text: 'Book'
            }]
          }
        },
        watch: {
          //Dynamically rendering forms
      selectedOption: function(newValue, oldValue) {

        if (newValue === 'DVD') {

          this.form1 = true;
          this.form2 = false;
          this.form3 = false;
        } else if (newValue === 'Furniture') {

          this.form2 = true;
          this.form1 = false;
          this.form3 = false;
        } else if (newValue === 'Book') {

          this.form3 = true;
          this.form2 = false;
          this.form1 = false;
        }

      }
    },
    methods: {
  //Here are methods for checking inputs validity
      dvdinput(event) {
        var dvd2 = document.getElementById("size");
        var notsize = document.getElementById("notifications");



        var contain2 = /^[a-zA-Z]+$/.test(dvd2.value);
        if (contain2) {
          notsize.textContent = "Please provide the data of indicated type";
        } else {
          notsize.textContent = "";
        }
      },
      bookinput(event) {
        var book2 = document.getElementById("weight");
        var notbook = document.getElementById("notificationb");



        var contain3 = /^[a-zA-Z]+$/.test(book2.value);
        if (contain3) {
          notbook.textContent = "Please provide the data of indicated type";
        } else {
          notbook.textContent = "";
        }
      },
      hinput(event) {
        var notheight = document.getElementById("notificationh");
        var height2 = document.getElementById("height");




        var contain4 = /^[a-zA-Z]+$/.test(height2.value);
        if (contain4) {
          notheight.textContent = "Please provide the data of indicated type";
        } else {
          notheight.textContent = "";
        }
      },
      winput(event) {
        var width2 = document.getElementById("width");
        var notwidth = document.getElementById("notificationw");


        var contain5 = /^[a-zA-Z]+$/.test(width2.value);
        if (contain5) {
          notwidth.textContent = "Please provide the data of indicated type";
        } else {
          notwidth.textContent = "";
        }
      },
      linput(event) {
        var length2 = document.getElementById("length");
        var notlength = document.getElementById("notificationl");



        var contain6 = /^[a-zA-Z]+$/.test(length2.value);
        if (contain6) {
          notlength.textContent = "Please provide the data of indicated type";
        } else {
          notlength.textContent = "";
        }
      }
    }


  });
      document.getElementById("new").addEventListener("click", send);
      //Function for passing values to insert.php where is the DB logic.
      function send() {
        //Geting values from form
        var sku = $("#sku").val();
        var name = $("#name").val();
        var price = Number($("#price").val());
        var dvdtest = Number($("#size").val());
        var height = Number($("#Height").val());
        var width = Number($("#Width").val());
        var length = Number($("#Length").val());
        //Values initially have to be empty
        if (!isNaN(height) && !isNaN(width) && !isNaN(length)) {
          var furniture = height + "" + width + "" + length
        }
        if (!isNaN(dvdtest)) {
          var dvd = dvdtest;
        }
        var book = $("#weight").val();
        console.log(dvd)
        console.log(typeof(dvd))
        //Passing to php file where checking if SKU exists
        $.ajax({
          url: 'exists.php',
          type: 'POST',
          data: {
            sku: sku
          },
          success: function(response) {
            if (response == 'taken') {
              alert("SKU already exists");
              return;
              //Checking for correct input, if not empty.
            } else if (response == 'not_taken') {
              if (sku !== "" && name !== "" && price !== "" && dvd !== "" && height !== "" && width !== "" && length !== "" && book !== "") {
                //Passing to insert DB
                $.ajax({
                  url: 'insert.php',
                  type: 'POST',
                  data: {
                    sku: sku,
                    name: name,
                    price: price,
                    dvd: dvd,
                    furniture: furniture,
                    book: book
                  },
                  success: function(response) {
                    // Handle success response
                    window.location.href = "index.php";
                  }
                });
              } else {
                alert("Please, submit required data");
              }
            }
          }
        });
      }
    
    //Functionality for testing if given input is correct 
    
    
      var notname = document.getElementById("notificationn");
      var notprice = document.getElementById("notificationp");
      var name2 = document.getElementById("name");
      var price2 = document.getElementById("price");
      
      name2.addEventListener("input", function() {
          
        var contain = /\d/.test(name2.value);
        if (contain) {
          notname.textContent = "Please, provide the data of indicated type ";
        } else {
          notname.textContent = "";
        }
      });
      price2.addEventListener("input", function() {
          
        var contain2 = /[a-zA-Z]/.test(price2.value);
        if (contain2) {
          notprice.textContent = "Please, provide the data of indicated type ";
        } else {
          notprice.textContent = "";
        }
      });
    </script>
  </body>
</html>
