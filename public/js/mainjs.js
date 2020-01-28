
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
                        $('#productPrice').val((data.products.standard_price).toFixed(2));
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
               //alert('Please select a product to display product price')
               swal("Select a Product!", "...Please select a product to display product price!");
               $('#discount').val('');
            }else{
                let billingAmount = ((discount/100) * product_price).toFixed(2);
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
    //swal("Here's the title!", "...and here's the text!");
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
    //$('#modal-form form')[0].reset();
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
           // $('#main_acct_id').val(data.renewal.main_acct_id)
           $('#productPrice').val(data.renewal.productPrice)
           $('#billingAmount').val(data.renewal.billingBalance)
           $('#discount').val(data.renewal.discount)
           $('#renewal_id').val(data.renewal.id)
                    }
                });
}

$('body').on('keyup', '#amount_paid', function(){
            let amountPaid = $(this).val();
            let balance = 0;
            let billingAmount = $('#billingAmount').val();
            if( parseFloat(amountPaid) > parseFloat(billingAmount) ){
                alert('Ooops!! Amount paid exceed billing amount, please check and try again')
              $('#billingbalance').val('')
              $('#amount_paid').val('');
            }else{
                 balance = billingAmount - amountPaid;
              $('#billingbalance').val(balance)
              
            }
        })
$(document).on('keyup', '#amount_paid', function(e){
    e.preventDefault();
    let value = e.target.value;
if(value <= 0){
     $(this).val('');
    
}
 });

//validate payment dates
$(document).ready(function(){
 $("#payment_date").datepicker();
    $("#payment_date").on("change",function(event){
        event.preventDefault();
    var selected_date = $(this).val();
    var fist_date = selected_date.replace('/','-');
    var second_date = fist_date.replace('/','-');
    $.ajax({
                    url: baseUrl+'/validate-selected-date/'+second_date,
                    type: "GET",
                    data: {'selected_date':selected_date},
                    success: function(data) {
                      if(data ==='invalidate'){
                   alert( 'Ooops!! Invalid date. Future date ('+ selected_date +') detected');        
                   $("#payment_date").val('')
            }
        }
        });
    });
})

function deleteData (url1,url2,id) {

  swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover the selected data!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {

 $.ajax({
        url: baseUrl+'/'+url1+'/'+url2+'/'+id,
        type: "GET",
        data: {'id':id},
        success: function(data) {
          
           swal("Poof! The selected data has been deleted!", {
            icon: "success",
          });
           window.location.href=window.location.href// refresh page
                    }
                });

        } else {
          swal("Your data is safe!");
        }
      });
 
}

function completelypayAlert(){
  swal("Payment completed!")
}
