 <table style="width:100%; color: #000000 !important;">

    <tbody>

        <td>

            <!-- business information here -->
            <div class="row invoice-info">

                <div class="col-md-6 invoice-col width-40" style="font-size:11px">
                    @if (empty($receipt_details->letter_head))
                        <!-- Logo -->
                        @if (!empty($receipt_details->logo))
                            <img style="max-height: 100px; width: auto;" src="{{ $receipt_details->logo }}"
                                class="img center-block">
                        @endif

                        <!-- Shop & Location Name  -->
                        <p>
                            @if (!empty($receipt_details->display_name))
                                <b>{{ $receipt_details->display_name }}</b>
                            @endif
                            <br>
                            {{-- Información de la empresa --}}
                            @if (!empty($receipt_details->nit))
                                <b> {!! $receipt_details->type_document !!}:</b> {!! $receipt_details->nit !!}-{!! $receipt_details->dv !!} <br>
                            @endif
                            @if (!empty($receipt_details->address))
                                <b>Dirección: </b> {!! $receipt_details->address !!} <br>
                            @endif
                            @if (!empty($receipt_details->type_organization))
                                {!! $receipt_details->type_organization !!} <br>
                            @endif
                            @if (!empty($receipt_details->type_regime))
                                {!! $receipt_details->type_regime !!} <br>
                            @endif
                           

                            {{-- @if (!empty($receipt_details->tax_info1))
			<br/><b>{{ $receipt_details->tax_label1 }}</b> {{ $receipt_details->tax_info1 }}
		@endif --}}

                            {{-- @if (!empty($receipt_details->address))
				{!! $receipt_details->address !!}
			@endif --}}

                            @if (!empty($receipt_details->contact))
                                {!! $receipt_details->contact !!}<br />
                            @endif

                            @if (!empty($receipt_details->website))
                                {{ $receipt_details->website }}
                            @endif
                            {{-- 
			@if (!empty($receipt_details->tax_info1))
				<br/>{{ $receipt_details->tax_label1 }} {{ $receipt_details->tax_info1 }}
			@endif

			@if (!empty($receipt_details->tax_info2))
				<br/>{{ $receipt_details->tax_label2 }} {{ $receipt_details->tax_info2 }}
			@endif --}}

                            @if (!empty($receipt_details->location_custom_fields))
                                <br />{{ $receipt_details->location_custom_fields }}
                            @endif
                        </p>
                    @endif

                    <!-- Table information-->
                    @if (!empty($receipt_details->table_label) || !empty($receipt_details->table))
                        <p>
                            @if (!empty($receipt_details->table_label))
                                {!! $receipt_details->table_label !!}
                            @endif
                            {{ $receipt_details->table }}
                        </p>
                    @endif

                    <!-- Waiter info -->
                    @if (!empty($receipt_details->service_staff_label) || !empty($receipt_details->service_staff))
                        <p>
                            @if (!empty($receipt_details->service_staff_label))
                                {!! $receipt_details->service_staff_label !!}
                            @endif
                            {{ $receipt_details->service_staff }}
                        </p>
                    @endif



                    <div class="word-wrap">

                        <p class="text-right ">
                            @if (!empty($receipt_details->brand_label) || !empty($receipt_details->repair_brand))
                                @if (!empty($receipt_details->brand_label))
                                    <span class="pull-left">
                                        <strong>{!! $receipt_details->brand_label !!}</strong>
                                    </span>
                                @endif
                                {{ $receipt_details->repair_brand }}<br>
                            @endif


                            @if (!empty($receipt_details->device_label) || !empty($receipt_details->repair_device))
                                @if (!empty($receipt_details->device_label))
                                    <span class="pull-left">
                                        <strong>{!! $receipt_details->device_label !!}</strong>
                                    </span>
                                @endif
                                {{ $receipt_details->repair_device }}<br>
                            @endif

                            @if (!empty($receipt_details->model_no_label) || !empty($receipt_details->repair_model_no))
                                @if (!empty($receipt_details->model_no_label))
                                    <span class="pull-left">
                                        <strong>{!! $receipt_details->model_no_label !!}</strong>
                                    </span>
                                @endif
                                {{ $receipt_details->repair_model_no }} <br>
                            @endif

                            @if (!empty($receipt_details->serial_no_label) || !empty($receipt_details->repair_serial_no))
                                @if (!empty($receipt_details->serial_no_label))
                                    <span class="pull-left">
                                        <strong>{!! $receipt_details->serial_no_label !!}</strong>
                                    </span>
                                @endif
                                {{ $receipt_details->repair_serial_no }}<br>
                            @endif
                            @if (!empty($receipt_details->repair_status_label) || !empty($receipt_details->repair_status))
                                @if (!empty($receipt_details->repair_status_label))
                                    <span class="pull-left">
                                        <strong>{!! $receipt_details->repair_status_label !!}</strong>
                                    </span>
                                @endif
                                {{ $receipt_details->repair_status }}<br>
                            @endif

                            @if (!empty($receipt_details->repair_warranty_label) || !empty($receipt_details->repair_warranty))
                                @if (!empty($receipt_details->repair_warranty_label))
                                    <span class="pull-left">
                                        <strong>{!! $receipt_details->repair_warranty_label !!}</strong>
                                    </span>
                                @endif
                                {{ $receipt_details->repair_warranty }}
                                <br>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="col-md-6 invoice-col width-60" style="font-size:11px">

                    <div class="text-right font-17">
                        @if (!empty($receipt_details->invoice_no_prefix))
                            <b><span class="pull-left">{!! $receipt_details->invoice_no_prefix !!}</span></b>
                        @endif

                        {{ $receipt_details->invoice_no }}
                    </div>
                    <br>
                    @if (!empty($receipt_details->all_due))
                        <div class="bg-light-blue-active text-right font-size: 15px padding-5">
                            <span class="pull-left bg-light-blue-active">
                                {!! $receipt_details->all_bal_label !!}
                            </span>

                            {{ $receipt_details->all_due }}
                        </div>
                    @endif


                    <!-- Date-->
                    @if (!empty($receipt_details->date_label))
                        <div class="text-right font-size: 15px ">
                            <span class="text-right">
                                <b>{{ $receipt_details->date_label }}</b>
                            </span>

                            {{ $receipt_details->invoice_date }}
                        </div>
                    @endif

                    @if (!empty($receipt_details->due_date_label))
                        <div class="text-right font-size: 15px ">
                            <span class="text-right">
                                <b>{{ $receipt_details->due_date_label }}</b>
                            </span>

                            {{ $receipt_details->due_date ?? '' }}
                        </div>
                    @endif

                    @if (!empty($receipt_details->sell_custom_field_1_value))
                        <div class="text-right font-size: 15px ">
                            <span class="pull-left">
                                {{ $receipt_details->sell_custom_field_1_label }}
                            </span>

                            {{ $receipt_details->sell_custom_field_1_value }}
                        </div>
                    @endif
                    @if (!empty($receipt_details->sell_custom_field_2_value))
                        <div class="text-right font-size: 15px ">
                            <span class="pull-left">
                                {{ $receipt_details->sell_custom_field_2_label }}
                            </span>

                            {{ $receipt_details->sell_custom_field_2_value }}
                        </div>
                    @endif
                    @if (!empty($receipt_details->sell_custom_field_3_value))
                        <div class="text-right font-size: 15px ">
                            <span class="pull-left">
                                {{ $receipt_details->sell_custom_field_3_label }}
                            </span>

                            {{ $receipt_details->sell_custom_field_3_value }}
                        </div>
                    @endif
                    @if (!empty($receipt_details->sell_custom_field_4_value))
                        <div class="text-right font-size: 15px ">
                            <span class="pull-left">
                                {{ $receipt_details->sell_custom_field_4_label }}
                            </span>

                            {{ $receipt_details->sell_custom_field_4_value }}
                        </div>
                    @endif

                    <br>
                    <div class="word-wrap">
                        @if (!empty($receipt_details->customer_label))
                            <b>{{ $receipt_details->customer_label }}</b><br />
                        @endif

                        <!-- customer info -->

                        @if (!empty($receipt_details->customer_info))
                            {!! $receipt_details->customer_info !!}
                        @endif
                        @if (!empty($receipt_details->client_id_label))
                            <br />
                            <strong>{{ $receipt_details->client_id_label }}</strong> {{ $receipt_details->client_id }}
                        @endif


                        @if (!empty($receipt_details->customer_tax_label))
                            <br />
                            <strong>{{ $receipt_details->customer_tax_label }}</strong>
                            {{ $receipt_details->customer_tax_number }}
                        @endif
                        @if (!empty($receipt_details->customer_custom_fields))
                            <br />{!! $receipt_details->customer_custom_fields !!}
                        @endif
                        @if (!empty($receipt_details->sales_person_label))
                            <br />
                            <strong>{{ $receipt_details->sales_person_label }}</strong>
                            {{ $receipt_details->sales_person }}
                        @endif
                        @if (!empty($receipt_details->commission_agent_label))
                            <br />
                            <strong>{{ $receipt_details->commission_agent_label }}</strong>
                            {{ $receipt_details->commission_agent }}
                        @endif

                        @if (!empty($receipt_details->customer_rp_label))
                            <br />
                            <strong>{{ $receipt_details->customer_rp_label }}</strong>
                            {{ $receipt_details->customer_total_rp }}
                        @endif

                        <!-- Display type of service details -->
                        @if (!empty($receipt_details->types_of_service))
                            <span class="pull-left text-left">
                                <strong>{!! $receipt_details->types_of_service_label !!}:</strong>
                                {{ $receipt_details->types_of_service }}
                                <!-- Waiter info -->
                                @if (!empty($receipt_details->types_of_service_custom_fields))
                                    <br>
                                    @foreach ($receipt_details->types_of_service_custom_fields as $key => $value)
                                        <strong>{{ $key }}: </strong> {{ $value }}@if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                @endif
                            </span>
                        @endif
                    </div>

                </div>
            </div>
            @if (!empty($receipt_details->shipping_custom_field_1_label) || !empty($receipt_details->shipping_custom_field_2_label))
                <div class="row">
                    <div class="col-xs-6">
                        @if (!empty($receipt_details->shipping_custom_field_1_label))
                            <strong>{!! $receipt_details->shipping_custom_field_1_label !!} :</strong> {!! $receipt_details->shipping_custom_field_1_value ?? '' !!}
                        @endif
                    </div>
                    <div class="col-xs-6">
                        @if (!empty($receipt_details->shipping_custom_field_2_label))
                            <strong>{!! $receipt_details->shipping_custom_field_2_label !!}:</strong> {!! $receipt_details->shipping_custom_field_2_value ?? '' !!}
                        @endif
                    </div>
                </div>
            @endif
            @if (!empty($receipt_details->shipping_custom_field_3_label) || !empty($receipt_details->shipping_custom_field_4_label))
                <div class="row">
                    <div class="col-xs-6">
                        @if (!empty($receipt_details->shipping_custom_field_3_label))
                            <strong>{!! $receipt_details->shipping_custom_field_3_label !!} :</strong> {!! $receipt_details->shipping_custom_field_3_value ?? '' !!}
                        @endif
                    </div>
                    <div class="col-xs-6">
                        @if (!empty($receipt_details->shipping_custom_field_4_label))
                            <strong>{!! $receipt_details->shipping_custom_field_4_label !!}:</strong> {!! $receipt_details->shipping_custom_field_4_value ?? '' !!}
                        @endif
                    </div>
                </div>
            @endif
            @if (!empty($receipt_details->shipping_custom_field_5_label))
                <div class="row">
                    <div class="col-xs-6">
                        @if (!empty($receipt_details->shipping_custom_field_5_label))
                            <strong>{!! $receipt_details->shipping_custom_field_5_label !!} :</strong> {!! $receipt_details->shipping_custom_field_5_value ?? '' !!}
                        @endif
                    </div>
                </div>
            @endif
            @if (!empty($receipt_details->sale_orders_invoice_no) || !empty($receipt_details->sale_orders_invoice_date))
                <div class="row">
                    <div class="col-xs-6">
                        <strong>@lang('restaurant.order_no'):</strong> {!! $receipt_details->sale_orders_invoice_no ?? '' !!}
                    </div>
                    <div class="col-xs-6">
                        <strong>@lang('lang_v1.order_dates'):</strong> {!! $receipt_details->sale_orders_invoice_date ?? '' !!}
                    </div>
                </div>
            @endif
            <div class="row">
                @includeIf('sale_pos.receipts.partial.common_repair_invoice')
            </div>
			
            {{-- Informacion de Resolución --}}
					<div class="text-right font-12">
						<small>
                            @if ($receipt_details->resolution != '-')
                            <b>Resolución N°: </b> {!! $receipt_details->resolution !!} <b>Prefijo:</b> {!!$receipt_details->resolution_prefix!!}  <b>Consecutivo: </b>{!! $receipt_details->resolution_start_number !!} Hasta {!! $receipt_details->resolution_end_number !!}<b> Fecha:</b> {!! $receipt_details->resolution_date !!} Hasta {!! $receipt_details->resolution_end_date !!}
                            @endif
						</small>
					</div>

<!-- CABECERA DE PRODUCTOS -->
<div class="row  mt-5 font-10">
	<div class="col-xs-12 ">
		<!-- <table class="table table-bordered table-no-top-cell-border table-slim mb-12">  SIN LINEAS ENTRE LOS ARTICULOS-->
		<table class="table table-bordered table-top-cell-border table-slim mb-12">
			<thead>
				<!-- <tr style="background-color: #D8D8D8 !important; color: black !important" class="table-no-side-cell-border table-no-top-cell-border text-center"> -->
				<tr style="background-color: #D8D8D8 !important; color: black !important" class="table-side-cell-border table-top-cell-border text-center">
					<td style="background-color: #D8D8D8 !important; color: black !important; width: 3% !important"><b>#</b></td>
					
					@php
						$p_width = 40;
					@endphp
					@if($receipt_details->show_cat_code == 1)
						@php
							$p_width -= 10;
						@endphp
					@endif
					@if(!empty($receipt_details->item_discount_label))
						@php
							$p_width -= 10;
						@endphp
					@endif
					@if(!empty($receipt_details->discounted_unit_price_label))
						@php
							$p_width -= 5;
						@endphp
					@endif

					<td style="background-color: #D8D8D8 !important; color: black !important; width: 50% !important">
						<b>{{$receipt_details->table_product_label}}</b>
					</td>

					@if($receipt_details->show_cat_code == 1)
						<td style="background-color: #D8D8D8 !important; color: black !important; width: 7% !important;"><b>{{$receipt_details->cat_code_label}}</b></td>
					@endif
					
					<td style="background-color: #D8D8D8 !important; color: black !important; width: 10% !important;">
					<b>{{$receipt_details->table_qty_label}}</b>
					</td>
					<td style="background-color: #D8D8D8 !important; color: black !important; width: 10% !important;">
					<b>{{$receipt_details->table_unit_price_label}}</b>
					</td>
					@if(!empty($receipt_details->discounted_unit_price_label))
					<td style="background-color: #D8D8D8 !important; color: black !important; width: 7% !important;">
					<b>{{$receipt_details->discounted_unit_price_label}}</b>
					</td>
					@endif
					@if(!empty($receipt_details->item_discount_label))
					<td style="background-color: #D8D8D8 !important; color: black !important; width: 7% !important;">
					<b>{{$receipt_details->item_discount_label}}</b>
					</td>
					@endif
					<!-- <td style="background-color: #D8D8D8 !important; color: black !important; width: {{$p_width}}% !important;"> -->
					<td style="background-color: #D8D8D8 !important; color: black !important; width: 10% !important;">
					<b>{{$receipt_details->table_subtotal_label}}</b>
					</td>
				</tr>
			</thead>

{{-- //TABLA DONDE VAN LOS DATOS --}}
			<tbody class="font-10" >
			
				@php
					$subtotal = 0;
				@endphp
				@foreach($receipt_details->lines as $line)
					<tr>
						<td class="text-center">
							{{$loop->iteration}}
						</td>
						<td>
							@if(!empty($line['image']))
								<img src="{{$line['image']}}" alt="Image" width="25" style="float: left; margin-right: 8px;">
							@endif

							<div class="text-left font-10">
                            {{$line['name']}} {{$line['product_variation']}} {{$line['variation']}} 
                            @if(!empty($line['sub_sku'])),<b> CÓD: </b> {{$line['sub_sku']}} @endif @if(!empty($line['brand'])), {{$line['brand']}} @endif
                            @if(!empty($line['product_custom_fields'])), {{$line['product_custom_fields']}} @endif
                            @if(!empty($line['product_description']))
                            	<small>
                            		{!!$line['product_description']!!}
                            	</small>
                            @endif
                            @if(!empty($line['sell_line_note']))
                            <br>
                            <small>{!!$line['sell_line_note']!!}</small>
                            @endif
                            @if(!empty($line['lot_number']))<br> {{$line['lot_number_label']}}:  {{$line['lot_number']}} @endif 
                            @if(!empty($line['product_expiry'])), {{$line['product_expiry_label']}}:  {{$line['product_expiry']}} @endif 

                            @if(!empty($line['warranty_name'])) <br><small>{{$line['warranty_name']}} </small>@endif @if(!empty($line['warranty_exp_date'])) <small>- {{@format_date($line['warranty_exp_date'])}} </small>@endif
                            @if(!empty($line['warranty_description'])) <small> {{$line['warranty_description'] ?? ''}}</small>@endif

                            @if($receipt_details->show_base_unit_details && $line['quantity'] && $line['base_unit_multiplier'] !== 1)
                            <br><small>
                            	1 {{$line['units']}} = {{$line['base_unit_multiplier']}} {{$line['base_unit_name']}} <br>
                            	{{$line['base_unit_price']}} x {{$line['orig_quantity']}} = {{$line['line_total']}}
                            </small>
                            @endif
							
							
                        </td>

						@if($receipt_details->show_cat_code == 1)
	                        <td>
	                        	@if(!empty($line['cat_code']))
	                        		{{$line['cat_code']}}
	                        	@endif
	                        </td>
	                    @endif
						</div>
						<td class="text-right text-center font-10 padding-3">
							{{$line['quantity']}} {{$line['units']}}

							@if($receipt_details->show_base_unit_details && $line['quantity'] && $line['base_unit_multiplier'] !== 1)
                            <br><small>
                            	{{$line['quantity']}} x {{$line['base_unit_multiplier']}} = {{$line['orig_quantity']}} {{$line['base_unit_name']}}
                            </small>
                            @endif
						</td>
						<td class="text-right padding-3">
							{{$line['unit_price_before_discount']}} 
						</td>
						@if(!empty($receipt_details->discounted_unit_price_label))
						<td class="text-right padding-3">
							{{$line['unit_price_inc_tax']}} 
						</td>
						@endif

						@if(!empty($receipt_details->item_discount_label))
						<td class="text-right padding-3">
							{{$line['total_line_discount'] ?? '0.00'}}
							@if(!empty($line['line_discount_percent']))
								 ({{$line['line_discount_percent']}}%)
							@endif
						</td>
						@endif
						<td class="text-right padding-3">
							{{$line['line_total_exc_tax']}}
						</td>
					</tr>
					@if(!empty($line['modifiers']))
						@foreach($line['modifiers'] as $modifier)
							<tr>
								<td class="text-center padding-3">
									&nbsp;
								</td>
								<td>
		                            {{$modifier['name']}} {{$modifier['variation']}} 
		                            @if(!empty($modifier['sub_sku'])), {{$modifier['sub_sku']}} @endif 
		                            @if(!empty($modifier['sell_line_note']))({!!$modifier['sell_line_note']!!}) @endif 
		                        </td>

								@if($receipt_details->show_cat_code == 1)
			                        <td>
			                        	@if(!empty($modifier['cat_code']))
			                        		{{$modifier['cat_code']}}
			                        	@endif
			                        </td>
			                    @endif

								<td class="text-right padding-3">
									{{$modifier['quantity']}} {{$modifier['units']}}
								</td>
								<td class="text-right padding-3">
									{{$modifier['unit_price_exc_tax']}}
								</td>
								@if(!empty($receipt_details->discounted_unit_price_label))
									<td class="text-right padding-3">{{$modifier['unit_price_exc_tax']}}</td>
								@endif
								@if(!empty($receipt_details->item_discount_label))
									<td class="text-right padding-3">0.00</td>
								@endif
								<td class="text-right padding-3">
									{{$modifier['line_total']}}
								</td>
							</tr>
						@endforeach
					@endif
				@endforeach

				@php
					$lines = count($receipt_details->lines);
				@endphp

				<!-- SON LOS ESPACIOS QUE HAY CUANDO EL DOCUMENTO QUE TIENE MENOS DE 10 ARTICULOS-->
					
				@for ($i = $lines; $i < 1; $i++)
    				<tr>
    					<td>&nbsp;</td>
    					<td>&nbsp;</td>
    					<td>&nbsp;</td>
    					<td>&nbsp;</td>
    					<td>&nbsp;</td>
						
    					@if(!empty($receipt_details->discounted_unit_price_label))
    					<td></td>
    					@endif
    					@if(!empty($receipt_details->item_discount_label))
    					<td></td>
    					@endif
    					<td>&nbsp;</td>
    				</tr>
				@endfor

			</tbody>
		</table>
	</div>
</div>

<div class="row invoice-info" style="page-break-inside: avoid !important">
	<div class="col-md-6 invoice-col width-60 font-12">
		<b>Método de pago</b>
		<table class="table table-slim">
			@if (!empty($receipt_details->payments))
				@foreach ($receipt_details->payments as $payment)
					<tr>
						<td>{{ $payment['method'] }}</td>
						<td><b>{{ $payment['amount'] }}</b></td>
						<td>{{ $payment['date'] }}</td>

					</tr>
				@endforeach
			@endif

		</table>
		<!-- Total Paid-->
		@if (!empty($receipt_details->total_paid))
			<div class="text-letf font-size: 15px ">
				<b><span class="pull-left">{!! $receipt_details->total_paid_label !!}</span></b>
			 : {{ $receipt_details->total_paid }}
			</div>
		@endif
		<!-- Total Due-->
		@if (!empty($receipt_details->total_due) && !empty($receipt_details->total_due_label))
			<div class=" text-left font-size:20px">
				<span>
					<b>{!! $receipt_details->total_due_label !!}</b>
				</span>

				{{ $receipt_details->total_due }}
			</div>
		@endif

		<br>
		<br>
		
________________________________
		<br>
		<b class="pull-left">{{__('lang_v1.authorized_signatory')}}</b>
		<br>
		<br>
	</div>

	<div class="col-md-6 invoice-col width-40 font-10">
		<table class="table-no-side-cell-border table-no-top-cell-border width-100 table-slim">
			<tbody>
				@if(!empty($receipt_details->total_quantity_label))
					<tr>
						<td style="width:50%">
							{!! $receipt_details->total_quantity_label !!}
						</td>
						<td class="text-right">
							{{$receipt_details->total_quantity}}
						</td>
					</tr>
				@endif
				@if(!empty($receipt_details->total_items_label))
					<tr>
						<td style="width:50%">
							{!! $receipt_details->total_items_label !!}
						</td>
						<td class="text-right">
							{{$receipt_details->total_items}}
						</td>
					</tr>
				@endif
				<tr>
					<td style="width:50%">
						{!! $receipt_details->subtotal_label !!}
					</td>
					<td class="text-right">
						{{$receipt_details->subtotal_exc_tax}}
					</td>
				</tr>
				
				<!-- Shipping Charges -->
				@if(!empty($receipt_details->shipping_charges))
					<tr >
						<td style="width:50%">
							{!! $receipt_details->shipping_charges_label !!}
						</td>
						<td class="text-right">
							{{$receipt_details->shipping_charges}}
						</td>
					</tr>
				@endif

				@if(!empty($receipt_details->packing_charge))
					<tr >
						<td style="width:50%">
							{!! $receipt_details->packing_charge_label !!}
						</td>
						<td class="text-right">
							{{$receipt_details->packing_charge}}
						</td>
					</tr>
				@endif

				<!-- BASE ANTES DE IMPUESTOS -->
				@if(!empty($receipt_details->taxes))
					@foreach($receipt_details->taxes as $k => $v)
						<tr >
							<td>{{$k}}</td>
							<td class="text-right">(+) {{$v}}</td>
						</tr>
					@endforeach
				@endif
				

				<!-- Discount -->
				@if( !empty($receipt_details->discount) )
					<tr >
						<td>
							{!! $receipt_details->discount_label !!}
						</td>

						<td class="text-right">
							(-) {{$receipt_details->discount}}
						</td>
					</tr>
				@endif

				@if( !empty($receipt_details->total_line_discount) )
					<tr >
						<td>
							{!! $receipt_details->line_discount_label !!}
						</td>

						<td class="text-right">
							(-) {{$receipt_details->total_line_discount}}
						</td>
					</tr>
				@endif

				@if( !empty($receipt_details->additional_expenses) )
					@foreach($receipt_details->additional_expenses as $key => $val)
						<tr >
							<td>
								{{$key}}:
							</td>

							<td class="text-right">
								(+) {{$val}}
							</td>
						</tr>
					@endforeach
				@endif

				@if( !empty($receipt_details->reward_point_label) )
					<tr >
						<td>
							{!! $receipt_details->reward_point_label !!}
						</td>

						<td class="text-right">
							(-) {{$receipt_details->reward_point_amount}}
						</td>
					</tr>
				@endif

				@if(!empty($receipt_details->group_tax_details))
					@foreach($receipt_details->group_tax_details as $key => $value)
						<tr >
							<td>
								{!! $key !!}
							</td>
							<td class="text-right">
								(+) {{$value}}
							</td>
						</tr>
					@endforeach
				@else
					@if( !empty($receipt_details->tax) )
						<tr >
							<td>
								{!! $receipt_details->tax_label !!}
							</td>
							<td class="text-right">
								(+) {{$receipt_details->tax}}
							</td>
						</tr>
					@endif
				@endif

				@if( $receipt_details->round_off_amount > 0)
					<tr >
						<td>
							{!! $receipt_details->round_off_label !!}
						</td>
						<td class="text-right">
							{{$receipt_details->round_off}}
						</td>
					</tr>
				@endif
				
				<!-- Total -->
				<tr >
					<th style="background-color: #D8D8D8 !important; color:black !important" class="font-13 padding-3">
					<b>{!! $receipt_details->total_label !!}</b>
					</th>
					<td class="text-right font-13 padding-3" style="background-color: #D8D8D8 !important; color: black !important">
					<b>{{$receipt_details->total}}</b>
					</td>
				</tr>
				@if(!empty($receipt_details->total_in_words))
				<tr>
					<td colspan="2" class="text-right">
						<b><small>Valor en Letras: </small></b>
						<small>{{$receipt_details->total_in_words}} pesos m/cte</small>
					</td>
				</tr>
				@endif
			</tbody>
        </table>
	</div>
</div>

<div class="border-bottom col-md-8 ">
	@if (empty($receipt_details->hide_price) && !empty($receipt_details->tax_summary_label))
		<!-- tax -->
		@if (!empty($receipt_details->taxes))
			<table class="table table-slim table-bordered ">
				<tr>
					<th colspan="2" class="text-center " style="font-size:10px">{{ $receipt_details->tax_summary_label }}
					</th>
				</tr>
				@foreach ($receipt_details->taxes as $key => $val)
					<tr>
						<td class="text-center " style="font-size:10px"><b>{{ $key }}</b></td>
						<td class="text-center" style="font-size:10px">{{ $val }}</td>
					</tr>
				@endforeach
			</table>
		@endif
	@endif
</div>

@if (!empty($receipt_details->additional_notes))
	<div class="row ">
		<div class="col-xs-12">
			<br>
			<p>{!! nl2br($receipt_details->additional_notes) !!}</p>
		</div>
	</div>
@endif

<div class="row font-10" style="color: #000000 !important;">
	@if(!empty($receipt_details->footer_text))
	<div class="@if($receipt_details->show_barcode || $receipt_details->show_qr_code) col-xs-8 @else col-xs-12 @endif">
		{!! $receipt_details->footer_text !!}
	</div>
	@endif
	@if($receipt_details->show_barcode || $receipt_details->show_qr_code)
		<div class="@if(!empty($receipt_details->footer_text)) col-xs-4 @else col-xs-12 @endif text-center">
			@if($receipt_details->show_barcode)
				{{-- Barcode --}}
				<img class="center-block" src="data:image/png;base64,{{DNS1D::getBarcodePNG($receipt_details->invoice_no, 'C128', 2,30,array(39, 48, 54), true)}}">
			@endif
			@if ($receipt_details->show_qr_code && !empty($receipt_details->qrstr))
			{{-- @if (empty($receipt_details->qrstr))
				<img class="center-block mt-5" style="max-height: 130px; width: auto;"
				src="data:image/png;base64,{{ DNS2D::getBarcodePNG($receipt_details->qr_code_text, 'QRCODE') }}">
			@else --}}
			<b class="font-13">Representación Gráfica de Facturación Electrónica</b>
				<img class="center-block mt-5" style="max-height: 100px; width: auto;"
				src="data:image/png;base64,{{ DNS2D::getBarcodePNG($receipt_details->qrstr, 'QRCODE') }}">
			{{-- @endif --}}
			
		@endif
		
		</div>
		
	@endif
	
</div>

{{-- CUFE --}}
<div>
	@if (!empty($receipt_details->cufe))
		
		<b><p class="text centered font-12">CUFE:</b> <br>
		{!! $receipt_details->cufe !!}</p>
	@endif
</div>
<div style="page-break-inside: avoid !important col-md-12 " class="text-center"><hr/></div>
<div class="text-center">
<small class="">

	Software {{ config('app.name', 'ultimatePOS') }} - V{{config('author.app_version',"title")}} &copy; {{ date('Y') }} | Empresa {{ env('COMPANY', '') }} | Nit {{ env('APP_NIT', '') }} | WhatsApp {{ env('APP_CONTACT', '') }}
</small>
</div>

</td>


</tr>
												
	</tbody>

</table>