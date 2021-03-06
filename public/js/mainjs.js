// $('.datatable').DataTable({
//     dom: '<"html5buttons" B>lTfgitp',

// });

//hide and show bill remark date
    $("#bill_remark_id").change(function () {
    var bill_remark = $(this).val();
        // alert(bill_remark);

    if (bill_remark === "Customer to make payment") {
        $("#bill_remark_date_label").show();
        $("#bill_remark_date_id").show();
        
        
        $("div.update_date_label").removeClass('col-md-6');

        $("div.bill_remark_class").removeClass('col-md-6');

        $("div.update_date_label").addClass('col-md-4');

        $("div.bill_remark_class").addClass('col-md-4');


        
    } else {
        $("#bill_remark_date_id").val("");
         $("#bill_remark_date_label").hide();
        $("#bill_remark_date_id").hide();
         $("div.update_date_label").addClass('col-md-6');

        $("div.bill_remark_class").addClass('col-md-6');
    }
});

//hide and show bill remark date when editing it

$(".edit_bill_remark_class").change(function () {
    var bill_remark = $(this).val();
    if (bill_remark === "Customer to make payment") {
        $("#bill_remark_date_label").show();
        $(".bill_remark_date_class").show();
        
    } else {
        $(".bill_remark_date_class").val("");
        $(".bill_remark_date_class").hide();
        
    }
});



//Datatable
$(document).ready(function () {
    $(".datatable").DataTable({
        dom: "lTfgitp",
         
        "oLanguage": {
               "sInfo" : "Showing _START_ to _END_ of _TOTAL_ entries",// text you want show for info section
            },
        language: {
            paginate: {
                next: "<i class='las la-angle-double-right'></i>",
                previous: "<i class='las la-angle-double-left'></i>",
            },
        },
        aLengthMenu: [
            [10, 25, 50, 75, 100, -1],
            [10, 25, 50, 75, 100, "All"],
        ],
        iDisplayLength: 10,
        
    });
});

//Datatable
$(document).ready(function () {
    $(".invoices").DataTable({
        dom: "lTfgitp",
          "infoCallback": function( row, data, start, end, display, max ) {
    var api = this.api();
    var pageInfo = api.page.info();
                data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === "string"
                    ? i.replace(/[\$,]/g, "") * 1
                    : typeof i === "number"
                    ? i
                    : 0;
            };

            // Total over all pages
            total = api
                .column(3)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Total over this page
            pageTotal = api
                .column(3, { page: "current" })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
 
    return   max + '<br>' + 'Total Amount: '+ "&#8358;" + pageTotal.toLocaleString() + " of  &#8358;" + total.toLocaleString();
  
  },
        "oLanguage": {
               "sInfo" : "Showing _START_ to _END_ of _TOTAL_ entries",// text you want show for info section
            },
        language: {
            paginate: {
                next: "<i class='las la-angle-double-right'></i>",
                previous: "<i class='las la-angle-double-left'></i>",
            },
        },
        aLengthMenu: [
            [10, 25, 50, 75, 100, -1],
            [10, 25, 50, 75, 100, "All"],
        ],
        iDisplayLength: 10,
        footerCallback: function (row, data, start, end, display) {
            var api = this.api(),
                data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === "string"
                    ? i.replace(/[\$,]/g, "") * 1
                    : typeof i === "number"
                    ? i
                    : 0;
            };

            // Total over all pages
            total = api
                .column(4)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Total over this page
            pageTotal = api
                .column(4, { page: "current" })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Update footer
            $(api.column(4).footer()).html(
                "&#8358;" + pageTotal.toLocaleString() + " of &#8358;" + total.toLocaleString()
            );
        },
    });
});
$("select").not(".reportselectOption, .user").select2({
    theme: "bootstrap",
});

var Datepicker = (function () {
    var $datepicker = $(".datepicker");
    function init($this) {
        var options = {
            disableTouchKeyboard: true,
            autoclose: false,
            format: "dd/mm/yyyy",
        };
        $this.datepicker(options);
    }
    if ($datepicker.length) {
        $datepicker.each(function () {
            init($(this));
        });
    }
})();

// Autoupdate the usertype while creating a new sub user
// Primary user must be included in the reports to dropdown

function updateUserType() {}

// Autofill a unit when a dept is picked while creating a new user.
function selectDeptAjax(value) {
    $.get(baseUrl + "/getdept/" + value, function (data) {
        console.log(data.units);
        $("#input-unit").html("");
        $("#input-unit").append("<option value=''>Select Unit</option>");
        jQuery.each(data.units, function (i, val) {
            $("#input-unit").append(
                "<option value='" + val.id + "'>" + val.name + "</option>"
            );
        });
    });
}

$("#input-dept").change(function () {
    selectDeptAjax($(this).val());
    $("#input-unit").prop("disabled", false);
});

//Auto fill product price when a product has been picked
let product_price = 0;
let billinga_amount = 0;
$("#product_id").change(function () {
    var product_id = $(this).val();
    $("#discount").val("");

    if (product_id != "" && !isNaN(parseFloat(product_id))) {
        $.ajax({
            url: baseUrl + "/fetch-product-price/" + product_id,
            type: "GET",
            dataType: "json",
            success: function (data) {
                // console.log(data);
                if (data.category == "") {
                    $("#renewal_description").val("");
                }
                $("#productPrice").empty();
                product_price = data.products.standard_price;
                $("#productPrice").val(data.products.standard_price.toFixed(2));
                $("#billingAmount").val(
                    data.products.standard_price.toFixed(2)
                );
                 $("#payment_due").val(
                    data.products.standard_price.toFixed(2)
                );
                $("#renewal_description").val(
                    data.category + ", " + data.subcategory
                );
                billinga_amount = data.products.standard_price.toFixed(2);
                $('.currency').empty();
                $('.currency').append("(" + data.currency + ")");

               $("term_condition").empty();

               $("#term_condition").text(data.products.description)
            },
        });
    } else {
        $("#productPrice").val("");
        $("#billingAmount").val("");
        $("#renewal_description").val("");
        $("#discount").val("");
        $("term_condition").text("");

        product_price = 0;
        billinga_amount = 0;
    }
});

$("body").on("keyup", "#discount", function () {
    product_price = $("#productPrice").val();
     $("#withholding_tax").val('');
       $("#value_added_tax").val('');
    let discount = $(this).val();
    if (0 <= discount && discount < 101) {
        if (parseFloat(product_price) <= 0) {
            swal(
                "Select a Product!",
                "...Please select a product to display product price!"
            );
            $("#discount").val("");
        } else {
            let discountedPrice = (discount / 100) * product_price;
            let final_price = (product_price - discountedPrice).toFixed(0);
            $("#billingAmount").val(final_price);
           $("#payment_due").val(final_price);

            if (final_price == "" || discount == "") {
                $("#billingAmount").val(billinga_amount);
                $("#payment_due").val(billinga_amount);
            }
        }
    } else {
        $("#billingAmount").val("");
        $("#discount").val("");
        $("#billingAmount").val(billinga_amount);
       

        //alert('Discount must not be more than 100')
        swal("Maximun Discount!", "...Discount must not be more than 100 %!");
    }
});

$(document).on("keyup", "#discount", function (e) {
    e.preventDefault();
    let value = e.target.value;
    product_price = $("#productPrice").val();
    if (value <= 0) {
        $(this).val("");
        $("#billingAmount").val(
            billinga_amount ? billinga_amount : product_price
        );
         $("#payment_due").val(
            billinga_amount ? billinga_amount : product_price
        );
    }
});
$(document).on("keyup", "#productPrice", function (e) {
    e.preventDefault();
    let value = e.target.value;
    //alert(value)
    if (value <= 0) {
        $(this).val("");
    }
});

//renewal payment: display renewal payment details on a modal
function renewalPayment(id) {
    //$('#modal-form form')[0].reset();
    $("#modal-form").modal("show");

    $.ajax({
        url: baseUrl + "/fetch-renewal-details/" + id,
        type: "GET",
        dataType: "json",
        success: function (data) {
            console.log(data.renewal);
            $(".modal-title").text("Renewal Payment");
            $("#customer_id").val(data.renewal.customer_id);
            $("#product_id").val(data.renewal.product_id);
            // $('#main_acct_id').val(data.renewal.main_acct_id)
            $("#productPrice").val(data.renewal.productPrice);
            $("#billingAmount").val(data.renewal.billingBalance);
            $("#discount").val(data.renewal.discount);
            $("#renewal_id").val(data.renewal.id);
        },
    });
}

function fetchCompanyEmail(id) {
    //$('#modal-form form')[0].reset();
    $("#modal-form").modal("show");

    $.ajax({
        url: baseUrl + "/fetch-company-email/" + id,
        type: "GET",
        dataType: "json",
        success: function (data) {
            console.log(data.email);
            $(".modal-title").text("Update Company Email");
            $("#company_email_id").val(data.email.id);
            $("#company_email").val(data.email.email);
            $("#email_driver").val(data.email.driver);
            $("#email_hostname").val(data.email.host);
            $("#email_username").val(data.email.user_name);
            $("#email_password").val(data.email.password);
            $("#email_port").val(data.email.port);
            $("#email_encryption").val(data.email.encryption);
            $("#sender_name").val(data.email.sender_name);
        },
    });
}

function fetchCompanyBankAccount(id) {
    //$('#modal-form form')[0].reset();
    $("#bank-account-modal-form").modal("show");

    $.ajax({
        url: baseUrl + "/fetch-company-bank-detail/" + id,
        type: "GET",
        dataType: "json",
        success: function (data) {
            console.log(data.detail);
            $(".modal-title").text("Update company bank account detail");
            $("#company_bank_account_id").val(data.detail.id);
            $("#bank_name").val(data.detail.bank_name);
            $("#account_name").val(data.detail.account_name);
            $("#account_number").val(data.detail.account_number);
        },
    });
}
//auto input billing balance when amout paid is entered
$("body").on("keyup", "#amount_paid", function () {
    let amountPaid = $(this).val();
    let balance = 0;
    let billingAmount = $("#billingAmount").val();
    if (parseFloat(amountPaid) > parseFloat(billingAmount)) {
        alert(
            "Ooops!! Amount paid exceed billing amount, please check and try again"
        );
        $("#billingbalance").val("");
        $("#amount_paid").val("");
    } else {
        balance = billingAmount - amountPaid;
        $("#billingbalance").val(balance);
    }
});
//disallow negative or zero input
$(document).on("keyup", "#amount_paid", function (e) {
    e.preventDefault();
    let value = e.target.value;
    if (value <= 0) {
        $(this).val("");
    }
});

//validate payment dates, check if a user select future dates
$(document).ready(function () {
    $("#payment_date").datepicker();
    $("#payment_date").on("change", function (event) {
        event.preventDefault();
        var selected_date = $(this).val();
        var fist_date = selected_date.replace("/", "-");
        var second_date = fist_date.replace("/", "-");
        $.ajax({
            url: baseUrl + "/validate-selected-date/" + second_date,
            type: "GET",
            data: { selected_date: selected_date },
            success: function (data) {
                if (data === "invalidate") {
                    alert(
                        "Ooops!! Invalid date. Future date (" +
                            selected_date +
                            ") detected"
                    );
                    $("#payment_date").val("");
                }
            },
        });
    });
});

//increase renewal start date by one yr. and display on endate field
$(document).ready(function () {
    $("#startdate").datepicker();
    $("#startdate").on("change", function (event) {
        event.preventDefault();
        var selected_date = $(this).val();
        var fist_date = selected_date.replace("/", "-");
        var second_date = fist_date.replace("/", "-");
        $.ajax({
            url: baseUrl + "/increase-start-date-by-oneyear/" + second_date,
            type: "GET",
            data: { selected_date: selected_date },
            success: function (data) {
                if (data) {
                    $("#end_date").val(data);
                }
            },
        });
    });
});

// Delete data with ajax
function deleteData(url1, url2, id) {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover the selected data!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                url: baseUrl + "/" + url1 + "/" + url2 + "/" + id,
                type: "GET",
                data: { id: id },
                success: function (data) {
                    swal("Poof! The selected data has been deleted!", {
                        icon: "success",
                    });
                    window.location.href = window.location.href; // refresh page
                },
            });
        } else {
            swal("Your data is safe!");
        }
    });
}

//display payment completed status, when a payment button is clicked
function completelypayAlert() {
    swal("Payment completed!");
}

//display payment completed status, when a payment button is clicked
function deletePaidRenewalAlert() {
    swal(
        "You can't delete the selected renewal because some payments has been recorded!"
    );
}

//display payment completed status, when a payment button is clicked
function editPaidRenewalAlert() {
    swal(
        "You can't edit the selected renewal because some payments has been recorded!"
    );
}

//Auto fill state when a country has been picked
$("#country_id").change(function () {
    var country = $(this).val();
    if (country) {
        $("#state_id").empty();
        $("<option>").val("").text("Loading...").appendTo("#state_id");
        $.ajax({
            url: baseUrl + "/getstates/" + country,
            type: "GET",
            dataType: "json",
            success: function (data) {
                $("#state_id").empty();
                $("<option>")
                    .val("")
                    .text("Select State")
                    .appendTo("#state_id");
                $.each(data.states, function (k, v) {
                    $("<option>").val(v.id).text(v.name).appendTo("#state_id");
                });
            },
        });
    }
});
//Auto fill city when a state has been picked
$("#state_id").change(function () {
    var state = $(this).val();
    if (state) {
        $("#city_id").empty();
        $("<option>").val("").text("Loading...").appendTo("#city_id");
        $.ajax({
            url: baseUrl + "/getcities/" + state,
            type: "GET",
            dataType: "json",
            success: function (data) {
                $("#city_id").empty();
                $("<option>").val("").text("Select City").appendTo("#city_id");
                $.each(data.cities, function (k, v) {
                    $("<option>").val(v.id).text(v.name).appendTo("#city_id");
                });
            },
        });
    }
});

//searchable select dropdown
$(".selectpicker").selectpicker({
    dropdownAlignRight: false,
    liveSearch: true,
    actionsBox: true,
    header: "Choose an option",
    liveSearchNormalize: true,
    liveSearchPlaceholder: "Choose an option",
    liveSearchStyle: "contains",
});

//Auto fill contact_emails when a customer has been picked
$("#customer").change(function () {
    var customerId = $(this).val();
    if (customerId) {
        $("#contact_emails").empty();
        $("<option>")
            .attr("selected", true)
            .val("")
            .text("Loading...")
            .appendTo("#contact_emails");
        $.ajax({
            url: baseUrl + "/get-contact-emails/" + customerId,
            type: "GET",
            dataType: "json",
            success: function (data) {
                if (data.contacts != "") {
                    // console.log('contacts', data.contacts)
                    // console.log('cutomer', data.customer)
                    $("#contact_emails").empty();
                    $("<option>")
                        .attr("selected", true)
                        .val("")
                        .text("Select contacts")
                        .appendTo("#contact_emails");
                    localStorage.setItem(
                        "contact_emails",
                        JSON.stringify(data.contacts)
                    );
                    $.each(data.contacts, function (k, contact) {

                        if(data.customer.email != contact.email){
                        $("<option>")
                            .attr("selected", false)
                            .val(contact.id)
                            .text(contact.surname && contact.surname + " " + contact.name )
                            .appendTo("#contact_emails");
                        }

                    });
                } else {
                    $("#contact_emails").empty();
                    $("<option>")
                        .attr("selected", true)
                        .val(" ")
                        .text("No contact emails found")
                        .appendTo("#contact_emails");
                    localStorage.removeItem("contact_emails");
                }
            },
        });
    }
});

// fill company email whan a cutomer is picked
$("#customer").change(function () {
    var customerId = $(this).val();
    if (customerId) {
        $("#company_email").empty();
        $("<option>")
            .attr("selected", true)
            .val("")
            .text("Loading...")
            .appendTo("#company_email");
        $.ajax({
            url: baseUrl + "/get-company-email/" + customerId,
            type: "GET",
            dataType: "json",
            success: function (data) {
                if (data.contact != "") {
                    // console.log(data.contact);
                    $("#company_email").empty();
                    $("<option>")
                        .attr("selected", true)
                        .val("")
                        .text("Select contact")
                        .appendTo("#company_email");
                    localStorage.setItem(
                        "company_email",
                        JSON.stringify(data.contact)
                    );
                    $.each(data.contact, function (k, v) {
                        // $('<option>').attr('selected', false).val(v.id).text(v.email).appendTo('#company_email');
                        $("#company_email").val(v.email);
                    });
                } else {
                    $("#company_email").empty();
                    //  $('<option>').attr('selected', true).val(' ').text('No Email found').appendTo('#company_email');
                    localStorage.removeItem("company_email");
                }
            },
        });
    }
});

function selectAllcontactEmails() {
    var contactemails = localStorage.getItem("contact_emails");
    $("#contact_emails").empty();
    $.each(JSON.parse(contactemails), function (k, v) {
        $("<option>")
            .attr("selected", true)
            .val(v.id)
            .text(v.email)
            .appendTo("#contact_emails");
    });
}

function deSelectAllcontactEmails() {
    $("#contact_emails").empty();
    $("<option>")
        .attr("selected", true)
        .val("")
        .text("Select contacts")
        .appendTo("#contact_emails");

    var contactemails = localStorage.getItem("contact_emails");
    $.each(JSON.parse(contactemails), function (k, v) {
        $("<option>")
            .attr("selected", false)
            .val(v.id)
            .text(v.email)
            .appendTo("#contact_emails");
    });
}

function identifier() {
    return Math.floor(Math.random() * (99999999 - 10000000 + 1)) + 10000000;
}

var row = 1;

$("#addMore").click(function (e) {
    e.preventDefault();

    if (row >= 10) {
        alert("You've reached the maximum limit");
        return;
    }

    var rowId = identifier();

    $("#container").append(
        "<div>" +
            '<div style="float:right" class="remove_project_file"><span style="cursor:pointer" class="btn btn-danger btn-sm" border="2"><i class="fa fa-minus-circle"></i> Remove</span></div>' +
            '<div style="clear:both"></div>' +
            '<div class="row" id="rowNumber' +
            rowId +
            '" data-row="' +
            rowId +
            '">' +
            '<div class="form col-md-4">' +
            '<label class="form-control-label" for="input-category">Title</label>' +
            '<select name="contacts[' +
            rowId +
            '][contact_title]"  class="form-control select' +
            rowId +
            '" required>' +
            '<option value="">Select title</option>' +
            '<option value="Mr.">Mr.</option>' +
            '<option value="Mrs.">Mrs.</option>' +
            '<option value="Miss">Miss</option>' +
            "</select>" +
            "</div>" +
            '<div class="form col-md-4">' +
            '<div class="form-group{{ $errors->has("contact_surname") ? "has-danger": "" }} col-md-3">' +
            '    <label class="form-control-label" for="input-category">Surname</label>' +
            '<input type="text" name="contacts[' +
            rowId +
            '][contact_surname]" id="input-contact_surname" class="form-control" placeholder="Enter surname" value="" required>' +
            "</div>" +
            "</div>" +
            '<div class="form col-md-4">' +
            '<div class="form-group{{ $errors->has("contact_name") ? "has-danger" : ""}} col-md-3">' +
            '    <label class="form-control-label" for="input-contact_name"> Other names</label>' +
            '    <input type="text"  name="contacts[' +
            rowId +
            '][contact_name]" class="form-control {{ $errors->has("contact_name") ? "is-invalid" : "" }} contact_name" placeholder="Enter other name" value="" required>' +
            "</div>" +
            "</div>" +
            '<div style="clear:both"></div>' +
            '<div class="form col-md-4">' +
            '<div class="form-group{{ $errors->has("contact_email") ? "has-danger" : "" }} col-md-3">' +
            '    <label class="form-control-label" for="input-contact_email">Email</label>' +
            '    <input type="email" name="contacts[' +
            rowId +
            '][contact_email]" class="contact_email form-control {{ $errors->has("contact_email") ? "is-invalid" : "" }} contact_email" placeholder="Enter contact email" value="" required>' +
            "</div>" +
            "</div>" +
            '<div class="form col-md-4">' +
            '<div class="form-group{{ $errors->has("contact_phone") ? "has-danger" : "" }} col-md-2">' +
            '    <label class="form-control-label" for="input-contact_phone">Phone</label>' +
            '    <input type="tel" name="contacts[' +
            rowId +
            '][contact_phone]" class="contact_phone form-control {{ $errors->has("contact_phone") ? "is-invalid" : ""}} contact_phone" placeholder="Enter contact phone" value="" required>' +
            "</div>" +
            "</div>" +
            '<div style="clear:both"></div>' +
            '<div class="form col-md-4">' +
            '<div class="form-group{{ $errors->has("alternative_email") ? "has-danger" : "" }} col-md-3">' +
            '    <label class="form-control-label" for="input-alternative_email">Alternative Email (Optional)</label>' +
            '    <input type="email" name="contacts[' +
            rowId +
            '][alternative_email]" class="alternative_email form-control {{ $errors->has("alternative_email") ? "is-invalid" : "" }} alternative_email" placeholder="Enter contact email" value="" >' +
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
$("#container").on("click", ".remove_project_file", function (e) {
    e.preventDefault();
    $(this).parent().remove();
    row--;
});

// Add more product subcategories
$("#addMoreSubcategory").click(function (e) {
    // console.log('ok')
    e.preventDefault();

    if (row >= 10) {
        alert("You've reached the maximum limit");
        return;
    }

    var rowId = identifier();

    $("#subcaegoryContainer").append(
        "<div>" +
            '<div style="float:right; margin-right:50px; margin-top: 14px;" class="remove_subcategory"><span style="cursor:pointer; " class="badge badge-danger" border="2"><i class="fa fa-minus"></i> Remove</span></div>' +
            '<div style="clear:both"></div>' +
            ' <label class="form-control-label" for="input-property_type">Sub Category</label>' +
            "<br>" +
            "<br>" +
            '<input type="text" name="subcategories[' +
            rowId +
            '][name]" class="form-control" required style="margin-top: -30px;">' +
            '<div style="clear:both"></div>' +
            "<br>" +
            "</div>"
    );
    row++;
    $(".select" + rowId).select2({
        theme: "bootstrap",
    });
});

// Remove parent of 'remove' link when link is clicked.
$("#subcaegoryContainer").on("click", ".remove_subcategory", function (e) {
    e.preventDefault();
    $(this).parent().remove();
    row--;
});

// Add more cities
$("#addMoreCities").click(function (e) {
    // console.log('ok')
    e.preventDefault();

    if (row >= 10) {
        alert("You've reached the maximum limit");
        return;
    }

    var rowId = identifier();

    $("#cityContainer").append(
        "<div>" +
            '<div style="float:right; margin-right:50px; margin-top: 14px;" class="remove_city"><span style="cursor:pointer; " class="badge badge-danger" border="2"><i class="fa fa-minus"></i> Remove</span></div>' +
            '<div style="clear:both"></div>' +
            ' <label class="form-control-label" for="input-property_type">City</label>' +
            "<br>" +
            "<br>" +
            '<input type="text" name="cities[' +
            rowId +
            '][name]" class="form-control" required style="margin-top: -30px;">' +
            '<div style="clear:both"></div>' +
            "<br>" +
            "</div>"
    );
    row++;
    $(".select" + rowId).select2({
        theme: "bootstrap",
    });
});

// Remove parent of 'remove' link when link is clicked.
$("#cityContainer").on("click", ".remove_city", function (e) {
    e.preventDefault();
    $(this).parent().remove();
    row--;
});

$("#category_id").change(function () {
    var category = $(this).val();
    if (category) {
        $("#sub_category_id").empty();
        $("<option>").val("").text("Loading...").appendTo("#sub_category_id");
        $.ajax({
            url: baseUrl + "/get-product-subcategory/" + category,
            type: "GET",
            dataType: "json",
            success: function (data) {
                $("#sub_category_id").empty();
                $("<option>")
                    .val("")
                    .text("Select Product Sub Category")
                    .appendTo("#sub_category_id");
                $.each(data.prod_sub_categories, function (k, v) {
                    $("<option>")
                        .val(v.id)
                        .text(v.name)
                        .appendTo("#sub_category_id");
                });
            },
        });
    }
});

$("#sub_category_id").change(function () {
    var sub_category_id = $(this).val();
    if (sub_category_id) {
        $("#product_id").empty();
        $("<option>").val("").text("Loading...").appendTo("#product_id");
        $.ajax({
            url: baseUrl + "/get-product-by-subcategoryid/" + sub_category_id,
            type: "GET",
            dataType: "json",
            success: function (data) {
                console.log(data.products);
                $("#product_id").empty();
                $("<option>")
                    .val("")
                    .text("Select Product")
                    .appendTo("#product_id");
                $.each(data.products, function (k, v) {
                    $("<option>")
                        .val(v.id)
                        .text(v.name)
                        .appendTo("#product_id");
                });
            },
        });
    }
});

// Calculate percentage achieved
let unit_price = 0;
let quantity = 0;
let achieved_amount = 0;
$(document).on("keyup", "#unit-input", function (e) {
    e.preventDefault();
    unit_price = $(this).val();
    $("#input-percentage").val("");
    if (unit_price <= 0) {
        $(this).val("");
    }
});

$(document).on("keyup", "#qty", function (e) {
    e.preventDefault();
    quantity = $(this).val();
    $("#input-percentage").val("");
    $("#total_amount").val("");
    if (quantity <= 0) {
        $(this).val("");
    }
});

$(document).on("keyup", "#input-achieve_amount", function (e) {
    e.preventDefault();
    achieved_amount = $(this).val();
    let target_amount = unit_price * quantity;
    let percentage = (achieved_amount / target_amount) * 100;

    $("#input-percentage").val(parseFloat(percentage.toFixed(2)));
    if (achieved_amount <= 0) {
        $(this).val("");
    }
});

//auto fill total amount when adding sales when price and quantity are filled
$(document).on("keyup", "#input-price", function (e) {
    e.preventDefault();
    let price = $(this).val();
    let total_amount = price * quantity;

    $("#total_amount").val(total_amount);
    if (price <= 0 || quantity <= 0) {
        $(this).val("");
    }
});

//invoice payment: display invoice payment details on a modal
function invoice_payment(id) {
    //$('#modal-form form')[0].reset();
    $("#invoice-payment-modal-form").modal("show");

    $.ajax({
        url: baseUrl + "/fetch-invoice-details/" + id,
        type: "GET",
        dataType: "json",
        success: function (data) {
            console.log(data.invoice);
            $(".modal-title").text("invoice Payment");
            $("#customer_id").val(data.invoice.customer);
            $("#product_id").val(data.invoice.product_id);
            // $('#main_acct_id').val(data.invoice.main_acct_id)
            $("#productPrice").val(data.invoice.cost);
            $("#billingAmount").val(data.invoice.billingBalance);
            $("#discount").val(data.invoice.discount);
            $("#invoice_id").val(data.invoice.id);
        },
    });
}

function editPaidinvoiceAlert() {
    swal(
        "You can't edit the selected invoice because some payments has been recorded!"
    );
}

function deletePaidinvoiceAlert() {
    swal(
        "You can't delete the selected invoice because some payments has been recorded!"
    );
}

function confirm_delete() {
    return confirm("Are you sure?");
}

$(function () {
    $(document).on("click", "#checkAll", function () {
        if ($(this).val() == "Check All") {
            $(".button input").prop("checked", true);
            $(this).val("Uncheck All");
        } else {
            $(".button input").prop("checked", false);
            $(this).val("Check All");
        }
    });
});

function add_product() {
    //$('#modal-form form')[0].reset();
    $("#addProduct").modal("show");
}

function show_add_product_to_target_form() {
    $("#addProductToTarget").modal("show");
}

function hide_product_form() {
    //$('#modal-form form')[0].reset();
    $("#addProduct, #addProductToTarget").modal("hide");
}

function resetOpportunityReport() {
    $(":input", "#opportunityReportForm")
        .not(":button, :submit, :reset, :hidden")
        .val("")
        .prop("checked", false)
        .prop("selected", false);
}

//Check user level

$("#userId").change(function () {
    var user_id = $(this).val();
    let level = parseInt($("#level").val());

    if (user_id) {
        $.ajax({
            url: baseUrl + "/check-user-level/" + user_id,
            type: "GET",
            dataType: "json",
            success: function (data) {
                if (data.user == null) {
                    swal(
                        "The selected  user has not been assigned to a level!"
                    );
                }

                if (data.user && data.user.level > level) {
                    swal(
                        "A user can only report to another user with a lower or equal level i.e 2 can report to 1, 1 can also report to 1, but 1 cannot report to 2 respectively!"
                    );
                }
            },
        });
    }
});

//select renewal duration type
$("#duration_type").change(function () {
    var durationType = $(this).val();
    if (durationType != "") {
        $("#startdate, #end_date").removeAttr("disabled");
        durationType == "Annually"
            ? $("#end_date").attr("disabled", "disabled")
            : $("#startdate, #end_date").val("");
        durationType == "Annually"
            ? $("#AnnualReminderDuration").show()
            : $("#AnnualReminderDuration").hide();
        $("#first_duration, #second_duration, #third_duration").val("");
        durationType == "Annually"
            ? $("#AnnualReminderDurationHeading").show()
            : $("#AnnualReminderDurationHeading").hide();
    } else {
        $("#startdate, #end_date").val("");
        $("#startdate, #end_date").attr("disabled", "disabled");
        $("#AnnualReminderDuration").hide();
        $("#AnnualReminderDurationHeading").hide();
        $("#first_duration, #second_duration, #third_duration").val("");
    }
});
//Remove disabled attr from enddate and hide renewal submit button
function removeDisabledAttr() {
    $("#end_date").removeAttr("disabled");
    $("#submitRenewalButton").hide();
    $("#loader").show();
}

$("#first_duration, #second_duration, #third_duration").on(
    "keyup",
    function () {
        let data = $(this).val();
        if (data >= 500 || data <= -1 || isNaN(parseInt(data))) {
            alert(
                "Invalid number entered! Please enter a number between 0 and 364"
            );
            // $("#first_duration, #second_duration, #third_duration").val('');
        }
    }
);

// opportunity updates
function editOpportunityUpdate(id) {
    $.ajax({
        url: baseUrl + "/fetch-opport-update/" + id,
        type: "GET",
        dataType: "json",
        success: function (data) {
            console.log(data.opportUpdate);
            $("#commments_id" + id).empty();
            $("#opp_update_id" + id).empty();
            $("#update_date" + id).empty();
            // $('#type_id'+id+'').empty();
            $("#opp_update_id" + id).val(data.opportUpdate.id);
            $("#update_date" + id).val(data.updateDate);
            $("#commments_id" + id).append(data.opportUpdate.commments);
            $("<option>")
                .attr("selected", true)
                .val(data.opportUpdate.type)
                .text(data.opportUpdate.type)
                .appendTo("#type_id" + id);
        },
    });

    $("#editopportunityupdate" + id + "form").toggle();
}

function replyOpportunityUpdate(id) {
    $("#replytopportunityupdate" + id + "form").toggle();

    // $("#replytopportunityupdate" + id + "form").css('display', 'inline');
}

function editOpportunityUpdateReply(id) {
    $.ajax({
        url: baseUrl + "/fetch-opport-update-reply/" + id,
        type: "GET",
        dataType: "json",
        success: function (data) {
            console.log(data.opportUpdateReply);
            $("#opportunity_update_reply_id" + id + "").empty();
            $("#reply" + id).empty();

            $("#opportunity_update_reply_id" + id).val(
                data.opportUpdateReply.id
            );
            $("#reply" + id).append(data.opportUpdateReply.reply);
        },
    });

    $("#opportunityUpdateReply" + id + "form").toggle();
}

function seeMoreOppUpdateComment(id) {
    $("#lessOppUpdateComment" + id).hide();
    $("#moreOppUpdateComment" + id).show();
}

function seeLessOppUpdateComment(id) {
    $("#lessOppUpdateComment" + id).show();
    $("#moreOppUpdateComment" + id).hide();
}

function seeMoreOppUpdateCommentReply(id) {
    console.log(id);
    $("#lessOppUpdateCommentReply" + id).hide();
    $("#moreOppUpdateCommentReply" + id).show();
}

function seeLessOppUpdateCommentReply(id) {
    $("#lessOppUpdateCommentReply" + id).show();
    $("#moreOppUpdateCommentReply" + id).hide();
}

function opportunityUpdateReplies(id) {
    $("#opportunity_updateReplies" + id).toggle();
    $("#hideOPPReplyLabel" + id).toggle();
}

// Renewal updates
function editRenewalUpdate(id) {
    $.ajax({
        url: baseUrl + "/fetch-renewal-update/" + id,
        type: "GET",
        dataType: "json",
        success: function (data) {
            console.log(data.renewalUpdate);
            $("#commments_id" + id).empty();
            $("#opp_update_id" + id).empty();
            $("#update_date" + id).empty();
            $('#bill_remark_id' + id).empty();
            $("#bill_remark_date_id" + id).empty();
            $("#renewal_update_id" + id).val(data.renewalUpdate.id);
            $("#update_date" + id).val(data.updateDate);
            $("#commments_id" + id).append(data.renewalUpdate.commments);
            $("#bill_remark_date_id" + id).val(data.renewalUpdate.bill_remark_payment_date);
            $("<option>")
                .attr("selected", data.renewalUpdate.bill_remark ? true : false)
                .val(data.renewalUpdate.bill_remark)
                .text(data.renewalUpdate.bill_remark)
                .appendTo("#bill_remark_id" + id);
                 $("<option>")
                .attr("selected", data.renewalUpdate.bill_remark ? false : true)
                .val("")
                .text("Select Bill Remark")
                .appendTo("#bill_remark_id" + id);
            $("<option>")
                .attr("selected", false)
                .val("Customer to make payment")
                .text("Customer to make payment")
                .appendTo("#bill_remark_id" + id);
            $("<option>")
                .attr("selected", false)
                .val("Customer asked to resend invoice")
                .text("Customer asked to resend invoice")
                .appendTo("#bill_remark_id" + id);
            $("<option>")
                .attr("selected", false)
                .val("Customer cancelled service")
                .text("Customer cancelled service")
                .appendTo("#bill_remark_id" + id);
           $("<option>")
                .attr("selected", false)
                .val("Customer not yet satisfied with work")
                .text("Customer not yet satisfied with work")
                .appendTo("#bill_remark_id" + id);
          $("<option>")
                .attr("selected", false)
                .val("Customer not reachable")
                .text("Customer not reachable")
                .appendTo("#bill_remark_id" + id);
        },
    });
    // $(".edit_bill_remark_date" + id).toggle();
    $("#editRenewalUpdate" + id + "form").toggle();
}

function replyRenewalUpdate(id) {
    $("#replytrenewalupdate" + id + "form").toggle();
}

function editRenewalUpdateReply(id) {
    $.ajax({
        url: baseUrl + "/fetch-renewal-update-reply/" + id,
        type: "GET",
        dataType: "json",
        success: function (data) {
            console.log(data.renewalUpdateReply);
            $("#renewal_update_reply_id" + id + "").empty();
            $("#reply" + id).empty();

            $("#renewal_update_reply_id" + id).val(data.renewalUpdateReply.id);
            $("#reply" + id).append(data.renewalUpdateReply.reply);
        },
    });

    $("#renewalUpdateReply" + id + "form").toggle();
}

function seeMoreRenewalUpdateComment(id) {
    $("#lessRenewalUpdateComment" + id).hide();
    $("#moreRenewalUpdateComment" + id).show();
}

function seeLessRenewalUpdateComment(id) {
    $("#lessRenewalUpdateComment" + id).show();
    $("#moreRenewalUpdateComment" + id).hide();
}

function seeMoreRenewalUpdateCommentReply(id) {
    console.log(id);
    $("#lessRenewalUpdateCommentReply" + id).hide();
    $("#moreRenewalUpdateCommentReply" + id).show();
}

function seeLessRenewalUpdateCommentReply(id) {
    $("#lessRenewalUpdateCommentReply" + id).show();
    $("#moreRenewalUpdateCommentReply" + id).hide();
}

function renewalUpdateReplies(id) {
    $("#renewal_updateReplies" + id).toggle();
    $("#hideRenewalReplyLabel" + id).toggle();
}

function confirm_invoice_payment_resend() {
    return confirm("Do you really want to resend this invoice?");
}

// Add product to target
$("#productId").change(function () {
    var productId = $(this).val();
    $("#target_amount").val("");
    $("#target_quantity").val("");

    if (productId != "" && !isNaN(parseFloat(productId))) {
        $.ajax({
            url: baseUrl + "/fetch-product-price/" + productId,
            type: "GET",
            dataType: "json",
            success: function (data) {
                console.log("products", data);
                $("#unit_price").empty();
                $("#unit_price").val(data.products.standard_price.toFixed(2));
                $("#amount").val(data.products.standard_price.toFixed(2));
            },
        });
    } else {
        $("#unit_price").val("");
    }
});

//auto fill target amount when quantity is entered
$(document).on("keyup", "#target_quantity", function (e) {
    e.preventDefault();
    let quantity = $(this).val();
    console.log(quantity);
    const unitPrice = $("#productPrice").val();
    let target_amount = unitPrice * quantity;
    $("#target_amount").val(target_amount);

    if (quantity <= 0 || quantity <= 0) {
        $(this).val("");
    }
});

//auto populate customers when company or customer name is entered
$(document).ready(function () {
    $("#searchCustomers").keyup(function () {
        var customerName = $(this).val();

        if (customerName !== "") {
            var _token = $('input[name="_token"').val();
            $.ajax({
                url: baseUrl + "/search/customers",
                method: "get",
                data: { customer_name: customerName, _token: _token },
                success: function (customer) {
                    $("#customersList").fadeIn();
                    $("#customersList").html(customer);

                    if ($("#searchCustomers").val() === "") {
                        $("#customersList").empty();
                    }
                },
            });
        }
    });

    $(document).on("click", "li", function (e) {
        // $('#searchCustomers').val($(this).text()); //display search value in input field
        $("#customersList").fadeOut();
    });
});


  function calculateVat(vat){
     let discount = $("#discount").val();
    let productPrice = $("#productPrice").val();
    let discountedPrice = (discount / 100) * productPrice;
    let price = (productPrice - discountedPrice).toFixed(0);
      if(vat <= 0){
        $(this).val("");
    $("#billingAmount").val("");
        let billbal = (parseFloat(price) + withholdingTax(price) + valueAddedTax(price)).toFixed(0);
      $("#billingAmount").val(billbal);
      $("#payment_due").val("");
        $("#payment_due").val(billbal);
      }else{
         // vat = vat == '' ? 0 : vat;
     // vat_Price = (vat / 100) * parseFloat(price);
     final_Price = valueAddedTax(parseFloat(price)) + parseFloat(price) + withholdingTax(parseFloat(price));
    
    $("#billingAmount").val(final_Price.toFixed(0));
     $("#payment_due").val("");
        $("#payment_due").val(final_Price.toFixed(0));
      }
   }

   function calculateWht(wht){
    let discount = $("#discount").val();
    let productPrice = $("#productPrice").val();
    let discountedPrice = (discount / 100) * productPrice;
    let price = (productPrice - discountedPrice).toFixed(0);
      if(wht <= 0){
        $(this).val("");
    $("#billingAmount").val("");
        let bill_bal = (parseFloat(price) + valueAddedTax(price) + withholdingTax(price)).toFixed(0);
      $("#billingAmount").val(bill_bal);
       $("#payment_due").val("");
        $("#payment_due").val(bill_bal);
      }else{
         // wht = wht == '' ? 0 : wht;
     // wht_Price = (wht / 100) * parseFloat(price);
     final_Price = withholdingTax(parseFloat(price)) +  parseFloat(price) + valueAddedTax(parseFloat(price));
    
    $("#billingAmount").val(final_Price.toFixed(0));
     $("#payment_due").val("");
        $("#payment_due").val(final_Price.toFixed(0));
      }
   }

   function valueAddedTax(price){
    let vat = $("#value_added_tax").val();
         vat = vat == '' ? 0 : vat;
    let  vat_Price = (vat / 100) * parseFloat(price);
     return vat_Price;

   }

   function withholdingTax(price){
    let wht = $("#withholding_tax").val();
         wht = wht == '' ? 0 : wht;
    let  wht_Price = (wht / 100) * parseFloat(price);
     return wht_Price;

   }