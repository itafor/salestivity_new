


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
            '<div style="float:right" class="remove_product"><span style="cursor:pointer" class="btn btn-danger btn-sm" border="2"><i class="fa fa-minus-circle"></i> Remove</span></div>' +
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
            '" required>' +
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
            '" required>' +
            '<option value="">Select title</option>' +
            '<option value="Mr.">Mr.</option>' +
            '<option value="Mrs.">Mrs.</option>' +
            '<option value="Miss">Miss</option>' +
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
            '" required>' +
           
           
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




function getProductSubcategories(row_id){
    // alert(row_id);

    $("#product_container_id").on("change", "#category_id"+row_id, function (e) {
    e.preventDefault();
     var category = $(this).val();
    alert(category)
});
// $("#category_id1").change(function () {
//     var category = $(this).val();
//     alert(category)
    // if (category) {
    //     $("#sub_category_id").empty();
    //     $("<option>").val("").text("Loading...").appendTo("#sub_category_id");
    //     $.ajax({
    //         url: baseUrl + "/get-product-subcategory/" + category,
    //         type: "GET",
    //         dataType: "json",
    //         success: function (data) {
    //             $("#sub_category_id").empty();
    //             $("<option>")
    //                 .val("")
    //                 .text("Select Product Sub Category")
    //                 .appendTo("#sub_category_id");
    //             $.each(data.prod_sub_categories, function (k, v) {
    //                 $("<option>")
    //                     .val(v.id)
    //                     .text(v.name)
    //                     .appendTo("#sub_category_id");
    //             });
    //         },
    //     });
    // }
// });
}