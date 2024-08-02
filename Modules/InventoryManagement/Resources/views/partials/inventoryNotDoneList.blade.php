@foreach($notExistsProducts as $product)
    <tr id="{{$loop->iteration}}">
        <td>{{$loop->iteration}}</td>
        @php
            $varname='';
            $varname = $product->var_name ;
            $varname = ($varname == 'DUMMY'?'':' ( '. $product->var_name .' )') ;
            $skuAndSubSku = ($product->type =='single'?$product->sku  : $product->sub_sku) ;
        @endphp
        <td>{{$product->name . $varname}}</td>
        <td>{{$skuAndSubSku}}</td>
        <td>{{intval($product->qty_left)}}</td>
    </tr>
@endforeach
