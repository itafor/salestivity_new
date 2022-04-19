function editInventory(inventory_id) {
    // alert(inventory_id);
    // $("#invoice-payment-modal-form").modal("show");
    $.ajax({
        url: baseUrl + "/inventory/fetch/" + inventory_id,
        type: "GET",
        dataType: "json",
        success: function (data) {
            $("#inventory_id").val(data.inventory.id);
            $("#quantity").val(data.inventory.quantity);
            $("#product_id").val(data.inventory.product.id);
            $("#product_name").val(data.inventory.product.name);
        },
    });
}

