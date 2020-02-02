//Auto fill product price when a product has been picked
    let product_price =0;
    let billinga_amount =0;
        $('#product_id').change(function(){
            var product_id = $(this).val();
            if(product_id){
                $.ajax({
                    url: baseUrl+'/fetch-product-price/'+product_id,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $('#productPrice').empty();
                        product_price=data.products.standard_price;
                        $('#productPrice').val((data.products.standard_price).toFixed(2));
                         $('#billingAmount').val((data.products.standard_price).toFixed(2));
                         billinga_amount = (data.products.standard_price).toFixed(2);
                    }
                });
            }
            else{
                $('#productPrice').val('');
                product_price=0;
                billinga_amount =0;
            }
        });

        $('body').on('keyup', '#discount', function(){

            let discount = $(this).val();
           if(0 <= discount && discount < 101){
            if(parseFloat(product_price) <= 0){
               swal("Select a Product!", "...Please select a product to display product price!");
               $('#discount').val('');
             
            }else{
                let billingAmount = ((discount/100) * product_price).toFixed(2);
              $('#billingAmount').val(billingAmount)
              if(billingAmount =='' || discount ==''){
             $('#billingAmount').val(billinga_amount);
              }

            }
        }else{
             $('#billingAmount').val('');
               $('#discount').val('');
             $('#billingAmount').val(billinga_amount);
            //alert('Discount must not be more than 100')
          swal("Maximun Discount!", "...Discount must not be more than 100 %!");
        }
        })

$(document).on('keyup', '#discount', function(e){
    e.preventDefault();
    let value = e.target.value;
if(value <=0){
     $(this).val('');
    $('#billingAmount').val(billinga_amount);
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

//renewal payment: display renewal payment details on a modal
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
//auto input billing balance when amout paid is entered
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
//disallow negative or zero input
$(document).on('keyup', '#amount_paid', function(e){
    e.preventDefault();
    let value = e.target.value;
if(value <= 0){
     $(this).val('');
    
}
 });

//validate payment dates, check if a user select future dates
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



//increase renewal start date by one yr. and display on endate field
$(document).ready(function(){
 $("#startdate").datepicker();
    $("#startdate").on("change",function(event){
        event.preventDefault();
    var selected_date = $(this).val();
    var fist_date = selected_date.replace('/','-');
    var second_date = fist_date.replace('/','-');
    $.ajax({
                  url: baseUrl+'/increase-start-date-by-oneyear/'+second_date,
                  type: "GET",
                  data: {'selected_date':selected_date},
                  success: function(data) {
                  if(data){
                    $('#end_date').val(data);
                }
        }
        });
    });
})


// Delete data with ajax
function deleteData (url1,url2,id) {
  swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover the selected data, and corresponding payment histories will also be deleted!",
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

//display payment completed status, when a payment button is clicked
function completelypayAlert(){
  swal("Payment completed!")
}

//display payment completed status, when a payment button is clicked
function deletePaidRenewalAlert(){
  swal("You can't edit the selected renewal because some payments has been recorded!")
}


 //Auto fill state when a country has been picked
        $('#country_id').change(function(){
            var country = $(this).val();
            if(country){
                $('#state_id').empty();
                $('<option>').val('').text('Loading...').appendTo('#state_id');
                $.ajax({
                    url: baseUrl+'/getstates/'+country,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $('#state_id').empty();
                        $('<option>').val('').text('Select State').appendTo('#state_id');
                        $.each(data.states, function(k, v) {
                            $('<option>').val(v.id).text(v.name).appendTo('#state_id');
                        });
                    }
                });
            }
        });
//Auto fill city when a state has been picked
        $('#state_id').change(function(){
            var state = $(this).val();
            if(state){
                $('#city_id').empty();
                $('<option>').val('').text('Loading...').appendTo('#city_id');
                $.ajax({
                    url: baseUrl+'/getcities/'+state,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        $('#city_id').empty();
                        $('<option>').val('').text('Select City').appendTo('#city_id');
                        $.each(data.cities, function(k, v) {
                            $('<option>').val(v.id).text(v.name).appendTo('#city_id');
                        });
                    }
                });
            }
        });

//searchable select dropdown
$('.selectpicker').selectpicker({
  dropdownAlignRight:false,
  liveSearch:true,
  actionsBox: true,
  header: 'Choose an option',
  liveSearchNormalize: true,
  liveSearchPlaceholder: 'Choose an option',
  liveSearchStyle: 'contains'
});

//Auto fill contact_emails when a customer has been picked
        $('#customer').change(function(){
            var customerId = $(this).val();
            if(customerId){
                $('#contact_emails').empty();
                $('<option>').attr('selected', true).val('').text('Loading...').appendTo('#contact_emails');
                $.ajax({
                    url: baseUrl+'/get-contact-emails/'+customerId,
                    type: "GET",
                    dataType: 'json',
                    success: function(data) {
                        if(data.contacts !=''){
                        $('#contact_emails').empty();
                        $('<option>').attr('selected', true).val('').text('Select contacts').appendTo('#contact_emails');
                       localStorage.setItem('contact_emails',JSON.stringify(data.contacts));
                        $.each(data.contacts, function(k, v) {
                            $('<option>').attr('selected', false).val(v.id).text(v.email).appendTo('#contact_emails');
                        });

                      }else{
                        $('#contact_emails').empty();
                         $('<option>').attr('selected', true).val(' ').text('No contact emails found').appendTo('#contact_emails');
                      localStorage.removeItem('contact_emails');
                      }

                    }
                });
            }
        });

  function selectAllcontactEmails(){
      var contactemails = localStorage.getItem('contact_emails');
        $('#contact_emails').empty();
               $.each(JSON.parse(contactemails), function(k, v) {
        $('<option>').attr('selected', true).val(v.id).text(v.email).appendTo('#contact_emails');
     });
  }

  function deSelectAllcontactEmails(){
        $('#contact_emails').empty();
       $('<option>').attr('selected', true).val('').text('Select contacts').appendTo('#contact_emails');
     
     var contactemails = localStorage.getItem('contact_emails');
        $.each(JSON.parse(contactemails), function(k, v) {
        $('<option>').attr('selected', false).val(v.id).text(v.email).appendTo('#contact_emails');
     });

        }