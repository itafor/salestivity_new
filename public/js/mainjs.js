
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

//renewal payment
function renewalPayment (id) {
    //$('#modal-form form')[0];
    $('#modal-form').modal("show");

    $.ajax({
        url: baseUrl+'/fetch-renewal-details/'+id,
        type: "GET",
        dataType: 'json',
        success: function(data) {
           console.log(data.renewal)
           $('.modal-title').text('Renewal Payment')
           $('#customer_id').val(data.renewal.customer_id)
           $('#product_id').val(data.renewal.product)
           $('#main_acct_id').val(data.renewal.main_acct_id)
           $('#productPrice').val(data.renewal.productPrice)
           $('#billingAmount').val(data.renewal.billingAmount)
           $('#discount').val(data.renewal.discount)
           $('#renewal_id').val(data.renewal.id)
                    }
                });
}

$('body').on('keyup', '#amount_paid', function(){
            let amountPaid = $(this).val();
           //alert(amountPaid)
            let balance = 0;
            let billingAmount = $('#billingAmount').val();



            if( parseFloat(amountPaid) > parseFloat(billingAmount) ){
                alert('Ooops!! Amount paid exceed billing amount, please check and try again')
              $('#balance').val('')
              $('#amount_paid').val('');
            }else{
                 balance = billingAmount - amountPaid;
              $('#balance').val(balance)
              
            }
        })
$(document).on('keyup', '#amount_paid', function(e){
    e.preventDefault();
    let value = e.target.value;
    //alert(value)
if(value <= 0){
     $(this).val('');
    
}
 });