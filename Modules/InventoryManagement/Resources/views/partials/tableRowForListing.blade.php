
@foreach($inventories->products as $product)

    <tr id="{{$product->id}}" data-skip="1">
        @php
            $vars = $products->where('var_id',$product->pivot->variation_id)->first();
            $varname = $vars->var_name ;
            $skuAndSubSku = ($product->type =='single'?$vars->sku  : $vars->sub_sku) ;
        @endphp
        <td >{{$product->name. ($varname == 'DUMMY'?'':' ( '. $varname .' )')}}</td>
        <td>{{$skuAndSubSku}}</td>

        <td>{{number_format($product->pivot->qty_before)}}</td>
        <td>
            <input value="{{$product->pivot->amount_after_inventory}}" type="text"  disabled="true"/>
            <input type="hidden" name="product_id" value="{{$product->pivot->variation_id}}" disabled readonly>
            <input type="hidden" value="{{$product->pivot->variation_id}}" disabled readonly>
        </td>
        @php
            $amountDifference = $product->pivot->amount_after_inventory - $product->pivot->qty_before ;
            $encValues = Crypt::encrypt([
                'var_id'=>$product->pivot->variation_id,
                'product_inv_id'=>$product->id,
                'inv_id'=>$inventories->id
            ]);
        @endphp
        <td>{{number_format($amountDifference)}}</td>
        <td>
            <button class="btn btn-primary edit_current_row" data-values="{{$encValues}}">
                <i class="fa-solid fa-pencil"></i>
            </button>
            <button class="btn btn-danger delete_current_row" data-values="{{$encValues}}">
                <i class="fa-solid fa-trash-can"></i>
            </button>
            <i class="fa-thin fa-badge-check"></i></td>
    </tr>
    <i class="fa-thin fa-badge-check"></i>
@endforeach


