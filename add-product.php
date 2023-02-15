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
    <div style="left:40%; position:relative;">
      <form id="product_form" method="post">
        <label for="fname">SKU</label>
        <br>
        <input type="text" id="sku" name="sku">
        <br>
        <label for="fname">Name</label>
        <br>
        <input type="text" id="name" name="name">
        <br>
        <div id="notificationn"></div>
        <label for="fname">Price</label>
        <br>
        <input type="text" id="price" name="price">
        <br>
        <br>
        <div id="notificationp"></div>
      </form>
      <div id="app">
        <form v-if="form1" method="post">
          <label for="fname">Product-DVD</label>
          <br>
          <br>
          <label for="fname">Please provide DVD size in megabytes</label>
          <br>
          <input type="number" id="size" name="dvd">
          <label>MB</label>
          <br>
          <br>
          <br>
        </form>
        <form v-if="form2">
          <label for="fname">Product-Furniture</label>
          <br>
          <br>
          <label for="fname">Please provide dimension in HxWxL format.</label>
          <br>
          <br>
          <label for="Height">Height</label>
          <br>
          <input type="number" id="Height" name="furn">
          <br>
          <label for="Width">Width</label>
          <br>
          <input type="number" id="Width" name="furn">
          <br>
          <label for="Length">Length</label>
          <br>
          <input type="number" id="Length" name="furn">
          <br>
          <br>
          <br>
        </form>
        <form v-if="form3">
          <label>Product-Book</label>
          <br>
          <br>
          <label>Please provide weight in kilograms</label>
          <br>
          <input type="number" id="weight" name="book">
          <label>KG</label>
          <br>
          <br>
          <br>
        </form>
        <label style="font-weight:bold;">Select another product</label>
        <br>
        <select v-model="selectedOption">
          <option id="productType" v-for="option in options" :key="option.value">{{ option.text }}</option>
        </select>
      </div>
    </div> <?php


  ?> <script>
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
          // Get the selected option value
          selectedOption: function(newValue, oldValue) {
            // Hiding/showing product forms
            if (newValue === 'DVD') {
              this.form1 = true;
              this.form3 = false;
              this.form2 = false;
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
              //Checking for correct input, type and if not empty.
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
