
    let product_price =0;
        $('#product_id').change(function(){
            var product_id = $(this).val();
            if(product_id){
                $.ajax({
                    url: baseUrl+'/fetch-product-price/'+product_id,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        console.log(data.products.standard_price)
                        $('#productPrice').empty();
                        product_price=data.products.standard_price;
                        $('#productPrice').val(data.products.standard_price);
                    }
                });
            }
            else{
                $('#productPrice').val('');
                product_price=0;
            }
        });

        $('body').on('keyup', '#discount', function(){

            let discount = $(this).val();
           if(0 < discount && discount < 101){
            if(parseFloat(product_price) <= 0){
               alert('Please select a product to display product price')
               $('#discount').val('');
            }else{
                let billingAmount = (discount/100) * product_price;
              $('#billingAmount').val(billingAmount)
            }
        }else{
             $('#billingAmount').val('');
            alert('discount must not be more than 100')
        }
        })

$(document).on('keyup', '#discount', function(e){
    e.preventDefault();
    let value = e.target.value;
    //alert(value)
if(value <= 0){
     $(this).val('');
    
}
 });
$(document).on('keyup', '#productPrice', function(e){
    e.preventDefault();
    let value = e.target.value;
    //alert(value)
if(value <= 0){
     $(this).val('');
}
 });
