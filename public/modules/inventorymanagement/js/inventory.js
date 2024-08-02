$(document).ready(function() {

    $("#undoneProducts").parents('div.dataTables_wrapper').first().hide();

    $("#inventoryDone").on("click" , function(){
        $("#undoneProducts").parents('div.dataTables_wrapper').first().hide();
        $("#doneProducts").parents('div.dataTables_wrapper').first().show();
    });

    $("#inventoryUndone").on("click" , function(){
        $("#undoneProducts").parents('div.dataTables_wrapper').first().show();
        $("#doneProducts").parents('div.dataTables_wrapper').first().hide();
    });

    $("#closeProductQuantityModal").on("click" , function(){
        $('#addProductQuantityModal').modal('hide');
    });


    if ($('#search_product_inventory').length > 0) {
        var url = $(location).attr('href');
        var parts = url.split("/");
         last_part = parts[parts.length-1];
        if(last_part == ""){
            last_part = parts[parts.length-2];
        }
        $('#search_product_inventory')
            .autocomplete({
                source: function (request, response) {
                    $.getJSON(
                        '/inventory/get_products/'+last_part,
                        {term: request.term},
                        response
                    );
                },
                minLength: 2,
                response: function (event, ui) {

                    if(ui.content[0].NotFound ==  true){
                        alert ("Product doesn't exist");
                    }
                    else if (ui.content.length == 1) {
                        ui.item = ui.content[0];
                        $(this)
                            .data('ui-autocomplete')
                            ._trigger('select', 'autocompleteselect', ui);
                        $(this).autocomplete('close');
                    }
                },
                select: function (event, ui) {

                    $(this).val(null);
                    get_purchase_entry_row(ui.item.product_id, ui.item.variation_id , last_part);
                },
            })
            .autocomplete('instance')._renderItem = function (ul, item) {
            return $('<li>')
                .append('<div>' + item.text + '</div>')
                .appendTo(ul);
        };
    }

    function get_purchase_entry_row(product_id, variation_id , last_part) {
        productID = product_id;
        if (product_id) {

            var data = {
                product_id: product_id,
                variation_id: variation_id,
                inventory_id : last_part
            };

            if ($('#is_purchase_order').length) {
                data.is_purchase_order = true;
            }
            $.ajax({
                method: 'POST',
                url: '/inventory/get_purchase_entry_row',
                dataType: 'html',
                data: data,
                success: function(result) {
                    if(result == "zero qauntity"){
                        var protocol = $(location).attr('protocol');
                        var hostName = $(location).attr('hostname');
                        var port = $(location).attr('port');
                        var url = "href=" + protocol +"//"+ hostName +":"+port +"/products";
                        Swal.fire({
                            icon: 'error',
                            title: 'This product cannot be included in the inventory process because there is no quantity entered..',
                            text: 'Please enter quantity for this product...',
                            footer: '<a '+url+' target="_blank" rel="noopener noreferrer">Products</a>'
                        })

                    }else if(result == "Product already exists in the branch"){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'This product already exists...',
                        })
                    }else{
                    $('#purchase_entry_table > tbody:last-child').append(result);
                    // $("#saveProducts").css("display","block");
                    }

                },
            });
        }
    }



});

function updateInventoryAmount(e,product_id){
    var productQuantity = $("#productQuantity_"+product_id).text();
    var productAfterInventory = $("#productAfterInventory_"+product_id).val();
    var result = parseInt(productQuantity) - parseInt(productAfterInventory);
    $("#difference_"+product_id).text(result);
}
$("#saveProducts").on("click" , function(e){

    var array = new Array();
    var objectToBeSaved = [];
    var amountAfterInventory = 0;
    var amountAfterInventoryFlag = false;
    $("#purchase_entry_table tr").each(function () {

        var productId = this.id;
        if(this.id > 0){
            amountAfterInventory = $("#productAfterInventory_"+productId).val();
            if(parseInt(amountAfterInventory) <= 0){
                amountAfterInventoryFlag = true;
            }

            var amountDifference = $("#difference_"+productId).text();
            var data = {
                inventory_id: last_part,
                product_id: productId,
                amountAfterInventory: amountAfterInventory,
                amountDifference : amountDifference
            };

            array.push(data);
        }




    });
    objectToBeSaved= array;
    if(amountAfterInventoryFlag){
        console.log("Please be sure to enter all inventory quantities for products before saving...");
    }
    else{


        sendAjaxCall(objectToBeSaved);
    }

});

function sendAjaxCall(obj){
    $.ajax({
        type: 'POST',
        url: '/saveInventoryProducts',
        dataType: "json",
        data: {info: obj},
        success: function(result) {
            if(result.status == 200){
              window.location.href = 'inv/showInventoryList';
            }
        },
        error:function(exception){
            alert('Exception:'+exception);
        }
    });
}
