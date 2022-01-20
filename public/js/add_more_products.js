 //Assign billing amount to payment due
    $("#productPrice").on("keyup", function(){
      let   productPrice = $(this).val();
    $("#billingAmount").val(productPrice);
    $("#payment_due").val(productPrice);
    $("#discount").val('');
     $("#withholding_tax").val('');
    $("#value_added_tax").val('');
    })

//Assign billing amount to payment due
    $("#billingAmount").on("keyup", function(){
      let   billingAmount = $(this).val();
    $("#payment_due").val(billingAmount);
    $("#discount").val('');
    })

    //auto input billing balance when amout paid is entered
$("body").on("keyup", "#payment_due", function () {
    let paymentdue = $(this).val();
    // alert(paymentdue);
    let balance = 0;
    let billingAmount = $("#billingAmount").val();
    if (parseFloat(paymentdue) > parseFloat(billingAmount)) {
        alert(
            "Ooops!! Payment due exceed Billing Amount, please check and try again"
        );
        
        $("#payment_due").val("");
        $("#payment_due").val(billingAmount);

    } else {
        // $("#payment_due").val(billingAmount);
    }
});
// disallow negative or zero input
$(document).on("keyup", "#payment_due", function (e) {
    e.preventDefault();
    let value = e.target.value;
    if (value <= 0) {
        $(this).val("");
    }
});


 $("#value_added_tax").on("keyup", function(){
      var  vat = $(this).val();
       calculateVat(vat);
      
    })

   $("#withholding_tax").on("keyup", function(){
      let  wht = $(this).val();
     
      calculateWht(wht);
      
    })


   function identifier() {
    return Math.floor(Math.random() * (99999999 - 10000000 + 1)) + 10000000;
}

//loop over sub categories and display them
function displayCategories(){
    var product_options;
       $.each(product_categories, function (i, val) {

            product_options = product_options +  "<option value='" + val.id + "'>" + val.name + "</option>";
            
        });

   return product_options

}

var row = 1;

$("#addMoreProduct").click(function (e) {
    e.preventDefault();


    if (row >= 10) {
        alert("You've reached the maximum limit");
        return;
    }

    var rowId = identifier();

    $("#product_container_id").append(
        "<div>" +
            '<div style="float:right" class="remove_product" onclick="removeProductCostFromSum('+rowId+')"><span style="cursor:pointer" class="btn btn-danger btn-sm" border="2"><i class="fa fa-minus-circle"></i> Remove</span></div>' +
            '<div style="clear:both"></div>' +
            '<div class="row" id="rowNumber' +
            rowId +
            '" data-row="' +
            rowId +
            '">' +
            '<div class="form col-xl-3">' +
            '<div class="form-group">' +
            '<label class="form-control-label" for="input-category">Category</label>' +
            '<select name="products[' +
            rowId +
            '][category_id]"  class="form-control category_id' +
            rowId +
            '" id="category_id'+rowId+'" required onchange="getProductSubcategories('+rowId+')">' +
            '<option value="" >Select Category</option>' + 

               displayCategories() +
               
            "</select>" +
            "</div>" +
            "</div>" +


               '<div class="form col-xl-3">' +
            '<div class="form-group">' +
            '<label class="form-control-label" for="input-category">Sub Category</label>' +
            '<select name="products[' +
            rowId +
            '][sub_category_id]"  class="form-control sub_category_id' +
            rowId +
            '"  id="sub_category_id' +
            rowId +
            '" onchange="getProducts('+rowId+')" required>' +
            '<option value="">Select Sub Category</option>' +
            
            "</select>" +
            "</div>" +
            "</div>" +

                   '<div class="form col-xl-3">' +
            '<div class="form-group">' +
            '<label class="form-control-label" for="input-category">Product</label>' +
            '<select name="products[' +
            rowId +
            '][product_id]"  class="form-control product_id' +
            rowId +
            '" id="product_id' +
            rowId +
            '"  onchange="getProductCost('+rowId+')" required>' +
            '<option value="">Select a product</option>' +
           
            "</select>" +
            "</div>" +
            "</div>" +

                 '<div class="form col-xl-3">' +
            '<div class="form-group">' +
            '<label class="form-control-label" for="input-category">Product Cost</label>' +
            '<input type="number" name="products[' +
            rowId +
            '][product_cost]"  class="form-control product_cost' +
            rowId +
            '"  id="product_cost' +
            rowId +
            '"  placeholder="Product Cost" readonly required>' +
           
           
            "</div>" +
            "</div>" +
          
         
           
            '<div style="clear:both"></div>' +
            "</div>" +
            "</div>"
    );
    row++;


    $(".select" + rowId).select2({
        theme: "bootstrap",
    });
});

// Remove parent of 'remove' link when link is clicked.
$("#product_container_id").on("click", ".remove_product", function (e) {
    e.preventDefault();
    $(this).parent().remove();
    row--;
});

//object that holds all product cost and it associated row id
    var product_cost_object = {};


//auto populate subcategories when a category is selected
function getProductSubcategories(row_id){

    var invoiceproductLenght = parseInt($('#invoiceproductLenght').val());
   //Insert all editable products cost to product_cost_object variable
    for (var i = 0; i < invoiceproductLenght; i++) {
        product_cost_object[i] = parseInt($("#product_cost"+i).val());

    }


    $("#product_container_id").on("change", "#category_id"+row_id, function (e) {
    e.preventDefault();

    $("#product_id"+row_id).empty();
        $("<option>").val("").text("Select product").appendTo("#product_id"+row_id);

         delete product_cost_object[row_id];

    console.log('new product_cost_object', product_cost_object);
         $("#product_cost"+row_id).val("");



     var category = $(this).val();
    if (category) {
        $(".sub_category_id"+row_id).empty();
        $("<option>").val("").text("Loading...").appendTo(".sub_category_id"+row_id);
        $.ajax({
            url: baseUrl + "/get-product-subcategory/" + category,
            type: "GET",
            dataType: "json",
            success: function (data) {
                $(".sub_category_id"+row_id).empty();
                $("<option>")
                    .val("")
                    .text("Select Product Sub Category")
                    .appendTo(".sub_category_id"+row_id);
                $.each(data.prod_sub_categories, function (k, v) {
                    $("<option>")
                        .val(v.id)
                        .text(v.name)
                        .appendTo(".sub_category_id"+row_id);
                });
            },
        });
    }
         SumProductCost();

});

}

//auto populate products  when a subcategory is selected
function getProducts(row_id){

      $("#product_container_id").on("change", "#sub_category_id"+row_id, function (e) {
    e.preventDefault();
     var sub_category_id = $(this).val();
        if (sub_category_id) {
        $("#product_id"+row_id).empty();
        $("<option>").val("").text("Loading...").appendTo("#product_id"+row_id);
        $.ajax({
            url: baseUrl + "/get-product-by-subcategoryid/" + sub_category_id,
            type: "GET",
            dataType: "json",
            success: function (data) {
                $("#product_id"+row_id).empty();
                $("<option>")
                    .val("")
                    .text("Select Product")
                    .appendTo("#product_id"+row_id);
                $.each(data.products, function (k, v) {
                    $("<option>")
                        .val(v.id)
                        .text(v.name)
                        .appendTo("#product_id"+row_id);
                });
            },
        });
    }
        });

    }

 

    function getProductCost(row_id){
        $("#product_container_id").on("change", "#product_id"+row_id, function (e) {
    e.preventDefault();
    var product_id = $(this).val();
         if (product_id != "" && !isNaN(parseFloat(product_id))) {
        $.ajax({
            url: baseUrl + "/fetch-product-price/" + product_id,
            type: "GET",
            dataType: "json",
            success: function (data) {
                
                $("#product_cost"+row_id).empty();
                $("#product_cost"+row_id).val(data.products.standard_price.toFixed(2));

                product_cost_object[row_id]=data.products.standard_price;
                console.log('product_cost_object', product_cost_object);

                    SumProductCost();
                
            },
        });
    } 

            });

    }

    
// Sum all selected products costs
    function SumProductCost(){

    var total_product_price = obj => Object.values(obj).reduce((a,b)=>a+b);

    $("#productPrice").val('');
    $("#productPrice").val(total_product_price(product_cost_object));
  

    var vat =  $("#withholding_tax").val();
    var wht = $("#value_added_tax").val();
    
     calculateVat(vat)
     
     calculateWht(wht)
    }

// Remove selected product cost from total sum and sum the remaining objects values
function removeProductCostFromSum(row_id)
{

     var product_price = $('#product_cost'+row_id).val();

        delete product_cost_object[row_id];

    console.log('new product_cost_object', product_cost_object);


         var total_product_price = obj => Object.values(obj).reduce((a,b)=>a+b);


    $("#productPrice").val('');
    $("#productPrice").val(total_product_price(product_cost_object));
    

    var vat =  $("#withholding_tax").val();
    var wht = $("#value_added_tax").val();
    
     calculateVat(vat)
    
     calculateWht(wht)

}


