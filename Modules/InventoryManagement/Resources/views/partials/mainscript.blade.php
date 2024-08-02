<script>

$(document).ready(function() {

$("#undoneProducts").parents('div.dataTables_wrapper').first().hide();

function active_menu_item(elem){
    elem.parents('ul').find('li').removeClass('active');
    elem.parent().addClass('active');
}
$("#inventoryDone").on("click" , function(){
    active_menu_item($(this));
    $("#undoneProducts").parents('div.dataTables_wrapper').first().hide();
    $("#doneProducts").parents('div.dataTables_wrapper').first().show();
});

$("#inventoryUndone").on("click" , function(){
    active_menu_item($(this));
    $("#undoneProducts").show().parents('div.dataTables_wrapper').first().show();
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
                    '/inventorymanagement/inventory/get_products/'+last_part,
                    {term: request.term},
                    response
                );
            },
            minLength: 2,
            response: function (event, ui) {

                if(ui.content[0]?.NotFound ==  true){
                    
                    return toastr.error("@lang('inventorymanagement::inventory.product_notfound')");
//  ("");
                }
                else if (ui.content.length == 1) {
                    ui.item = ui.content[0];
                    // console.log('Test 1:',ui.content);
                    $(this)
                        .data('ui-autocomplete')
                        ._trigger('select', 'autocompleteselect', ui);
                    $(this).autocomplete('close');
                }
            },
            select: function (event, ui) {

                $(this).val(null);
                // console.log('Test xxx',ui.item);
                get_purchase_entry_row(ui.item.product_id, ui.item.variation_id , last_part);
            },
        })
        .autocomplete('instance')._renderItem = function (ul, item) {
            if(!item.NotFound){
                // console.log('Test 2', item);
                return $('<li>')
                    .append('<div>' + item.text + '</div>')
                    .appendTo(ul);
            }
            return $('<span>');
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
            url: '/inventorymanagement/inventory/get_purchase_entry_row',
            dataType: 'html',
            data: data,
            success: function(result) {
                if(result) {
                    try {
                        result = JSON.parse(result);
                        if(result.status == false){
                            if(result.msg){
                                toastr.error(result.msg.text);
                            }
                }
                    } catch(e) {
                        $('#purchase_entry_table > tbody:last-child').append(result);
                    }
                }
        },
        });
    }
}



});

function updateInventoryAmount(e,product_id){
    var productQuantity = $("#productQuantity_"+product_id).text();
    var productAfterInventory = $("#productAfterInventory_"+product_id).val();
    var result =   parseInt(productAfterInventory) -  parseInt(productQuantity) ;
    $("#difference_"+product_id).text(result);
}
$("#saveProducts").on("click" , function(e){

var array = new Array();
var objectToBeSaved = [];
var amountAfterInventory = 0;
var amountAfterInventoryFlag = false;
$("#purchase_entry_table tr:not([data-skip])").each(function () {

    let productId = $(this).find('[name=product_id]').val();
    var variation_id = $(this).find('[name=variation_id]').val();
    if(this.id > 0){
        amountAfterInventory = $("#productAfterInventory_"+variation_id).val();
        if(parseInt(amountAfterInventory) <= 0){amountAfterInventoryFlag = true;}

        var amountDifference = $("#difference_"+variation_id).text();
        var variation_id = $(this).find('[name=variation_id]').val();
        var data = {
            inventory_id: last_part,
            product_id: productId,
            amountAfterInventory: amountAfterInventory,
            amountDifference : amountDifference,
            variation_id : variation_id,
        };

        array.push(data);
    }




});
objectToBeSaved= array;
if(amountAfterInventoryFlag){
    toastr.error("@lang('inventorymanagement::inventory.check_qty_added_msg')");
}
else{

    sendAjaxCall(objectToBeSaved);
}

});

function sendAjaxCall(obj){
$.ajax({
    type: 'POST',
    url: '/inventorymanagement/saveInventoryProducts',
    dataType: "json",
    data: {info: obj},
    success: function(result) {
        if(result.status == 200){
          window.location.href = '/inventorymanagement/showInventoryList';
        }
    },
    error:function(exception){
        alert('Exception:'+exception);
    }
});
}
$(document).on('click','.delete_row',function(e){
            e.preventDefault();
            $(this).parents('tr').fadeOut().remove()
    });
let qty_inv ;
let current_qty;
let current_different;
$(document).on('click','.edit_current_row',function (e){
    e.preventDefault();
    let values = $(this).data('values');
    $.ajax({
    type: 'GET',
    url: '/inventorymanagement/getProductData',
    data: {values: values},
    success: function(result) {
        $('#editProductModal_product_name').text(result.product_name)
        $('#new_product_qty').val(result.qty_now)
        qty_inv = result.qty_after;
        current_qty = result.qty_now;
        $('#produ_after_inv').val(result.qty_after)
        $('#inv_product_before_qty').val(result.qty_before);
        $('#product_fa_qty').val(result.diff_product);
        current_different = result.diff_product;
        $('#values_in').val(values);
        $('#editProductModal').modal('show');
    },
    error:function(exception){
        alert('Exception:'+exception);
    }
});

});
$('#produ_after_inv').change(function (e){
    let thisVal = parseInt($(this).val());
    $('#product_fa_qty').val(parseInt(thisVal - parseInt(current_qty)) );
    
});
$('#editProductModal').on('hidden.bs.modal', function (e) {
    $('#save_new_inv_qty').attr('disabled','true');
})
$(document).on('click','#save_new_inv_qty',function (e){
    e.preventDefault();
    let $btn = $(this);
    let $qty = parseInt($('#produ_after_inv').val());
    let $value = $('#values_in').val();
    // $btn.attr('disabled','true')
    if($qty !=  qty_inv){
        swal({
            title: `"@lang('inventorymanagement::inventory.alert_modal_msg')" : (${$qty})`,
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then(willDelete => {
            if (willDelete) {
                $btn.attr('disabled','true');
                $.ajax({
                    url:'/inventorymanagement/updateProductQuantity',
                    method:'POST',
                    data:{ values:$value,new_qty:$qty },
                    success:function (response){
                        if(response.status){
                            $('#editProductModal').modal('hide');
                            location.reload()
                        }
                            console.log(response);
                    },
                    complete:function (){
                        $btn.attr('disabled',false);

                    },
                    error:function (errs){
                        alert(`Exception : ${errs}`);
                    }
                })
            }
        });
    }else{
        $('#editProductModal').modal('hide');
    }
  
});
</script>