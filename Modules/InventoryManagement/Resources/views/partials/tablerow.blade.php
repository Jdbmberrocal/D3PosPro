
    <tr id="{{$variations->id}}" >
        <td >{{$product->name. ($variations->name == 'DUMMY'?'':' ( '. $variations->name .' )')}}</td>
        <td>{{$variations->sub_sku}}</td>
        <td id="productQuantity_{{$variations->id}}">{{$productQuantity}}</td>
        <td onchange="updateInventoryAmount(this , {{$variations->id}})">
            <input type="hidden" value="{{$variations->id}}" name="variation_id">
        <input type="hidden" value="{{$product->id}}" name="product_id">
            <input value="0" type="text" id="productAfterInventory_{{$variations->id}}"/>
        </td>
        <td id="difference_{{$variations->id}}"></td>
        <td>
            <button class="btn btn-danger delete_row" name="delete" >
                <i class="fa-solid fa-trash-can"></i>
                <span class="m-2">@lang('inventorymanagement::inventory.delete')</span>
            </button>
            <i class="fa-thin fa-badge-check"></i>
        </td>
    </tr>
    <i class="fa-thin fa-badge-check"></i>




