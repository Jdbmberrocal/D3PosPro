<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="modalTitle">{{$product->name}}</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-5">
                    <div class="position-relative">
                        <img src="{{$product->image_url}}" alt="Product image" class="img-fluid rounded">
                        @if($product->type == 'single' && !empty($discounts[$product->variations->first()->id]))
                            <span class="badge badge-warning position-absolute top-0 right-0 mt-2 mr-2">
                                -{{@num_format($discounts[$product->variations->first()->id]->discount_amount)}}%
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-7">
                    @if($product->type == 'single' || $product->type == 'combo')
                        <h4 class="mb-3">Precio: <span class="text-primary display_currency" data-currency_symbol="true">{{ $product->variations->first()->sell_price_inc_tax }}</span></h4>
                    @endif
                    <table class="table table-sm">
                        <tr>
                            <th>SKU:</th>
                            <td>{{$product->sku }}</td>
                        </tr>
                        <tr>
                            <th>Categoría:</th>
                            <td>{{$product->category->name ?? '--' }}</td>
                        </tr>
                        <tr>
                            <th>Subcategoría:</th>
                            <td>{{$product->sub_category->name ?? '--' }}</td>
                        </tr>
                        <tr>
                            <th>Marca:</th>
                            <td>{{$product->brand->name ?? '--' }}</td>
                        </tr>
                        <tr>
                            <th>Stock:</th>
                            <td>{{ $product->qty_available ?? 'No disponible' }}</td>
                        </tr>
                        @php 
                            $custom_labels = json_decode(session('business.custom_labels'), true);
                        @endphp
                        @if(!empty($product->product_custom_field1))
                            <tr>
                                <th>{{ $custom_labels['product']['custom_field_1'] ?? __('lang_v1.product_custom_field1') }}: </th>
                                <td>{{$product->product_custom_field1 }}</td>
                            </tr>
                        @endif

                        @if(!empty($product->product_custom_field2))
                            <tr>
                                <th>{{ $custom_labels['product']['custom_field_2'] ?? __('lang_v1.product_custom_field2') }}: </th>
                                <td>{{$product->product_custom_field2 }}</td>
                            </tr>
                        @endif

                        @if(!empty($product->product_custom_field3))
                            <tr>
                                <th>{{ $custom_labels['product']['custom_field_3'] ?? __('lang_v1.product_custom_field3') }}: </th>
                                <td>{{$product->product_custom_field3 }}</td>
                            </tr>
                        @endif

                        @if(!empty($product->product_custom_field4))
                            <tr>
                                <th>{{ $custom_labels['product']['custom_field_4'] ?? __('lang_v1.product_custom_field4') }}: </th>
                                <td>{{$product->product_custom_field4 }}</td>
                            </tr>
                        @endif
                    </table>
                    <p class="mt-3">{!! $product->product_description !!}</p>
                </div>
            </div>
            @if($product->type == 'variable')
                @include('productcatalogue::catalogue.partials.variable_product_details')
            @elseif($product->type == 'combo')
                @include('productcatalogue::catalogue.partials.combo_product_details')
            @endif
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('messages.close')</button>
            <a href="https://wa.me/?text={{ urlencode("¡Mira este producto!\n\n" . $product->name . "\n\nPrecio: " . $product->variations->first()->sell_price_inc_tax . "\nSKU: " . $product->sku . "\nCategoría: " . ($product->category->name ?? '--') . "\nMarca: " . ($product->brand->name ?? '--') . "\n\nDescripción: " . strip_tags($product->product_description) . "\n\nVer más: " . route('products.show', $product->id)) }}" 
            class="btn btn-success" target="_blank">
                <i class="fab fa-whatsapp"></i> Compartir
            </a>
        </div>
    </div>
</div>