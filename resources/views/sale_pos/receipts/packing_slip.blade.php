<table style="width:100%; color: #000000 !important;">
	<thead>
		<tr>
			<td>

			<p class="text-right font-30">
				<b>@lang('lang_v1.packing_slip')</b>
			</p>

			</td>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>

<!-- business information here -->
<div class="row invoice-info">

	<div class="col-md-6 invoice-col width-50">
		
		<!-- Logo -->
		@if(!empty($receipt_details->logo))
			<img style="max-height: 100px; width: auto;" src="{{$receipt_details->logo}}" class="img">
			<br/>
		@endif

		<!-- Shop & Location Name  -->
		@if(!empty($receipt_details->display_name))
			<p>
				<span style="font-size:20px;"><b>{{$receipt_details->display_name}}</b></span>
				@if(!empty($receipt_details->address))
					<br/>{!! $receipt_details->address !!}
				@endif

				@if(!empty($receipt_details->contact))
					<br/>{!! $receipt_details->contact !!}
				@endif

				@if(!empty($receipt_details->website))
					<br/>{{ $receipt_details->website }}
				@endif

				@if(!empty($receipt_details->tax_info1))
					<br/>{{ $receipt_details->tax_label1 }} {{ $receipt_details->tax_info1 }}
				@endif

				@if(!empty($receipt_details->tax_info2))
					<br/>{{ $receipt_details->tax_label2 }} {{ $receipt_details->tax_info2 }}
				@endif

				@if(!empty($receipt_details->location_custom_fields))
					<br/>{{ $receipt_details->location_custom_fields }}
				@endif
			</p>
		@endif
	</div>

	<div class="col-md-6 invoice-col width-50">

		<p class="text-right font-23">
			@if(!empty($receipt_details->invoice_no_prefix))
				<span class="pull-left"><b>{!! $receipt_details->invoice_no_prefix !!}</b></span>
			@endif

			<b>{{$receipt_details->invoice_no}}</b>
		</p>
		<!-- Date-->
		@if(!empty($receipt_details->date_label))
			<p class="text-right font-15">
				<span class="pull-left">
					{{$receipt_details->date_label}}
				</span>

				{{$receipt_details->invoice_date}}
			</p>
		@endif
	</div>
	<br>
	<br><br>
	<div class="row invoice-info ">
		<br/>
		<div class="col-md-6 invoice-col width-50 word-wrap">
			@if(!empty($receipt_details->customer_label))
				<b>{{ $receipt_details->customer_label }}</b><br/>
			@endif
	
			<!-- customer info -->
			@if(!empty($receipt_details->customer_name))
				{{ $receipt_details->customer_name }}<br>
			@endif
			@if(!empty($receipt_details->customer_info))
				{!! $receipt_details->customer_info !!}
			@endif
			@if(!empty($receipt_details->client_id_label))
				<br/>
				<strong>{{ $receipt_details->client_id_label }}</strong> {{ $receipt_details->client_id }}
			@endif
			@if(!empty($receipt_details->customer_tax_label))
				<br/>
				<strong>{{ $receipt_details->customer_tax_label }}</strong> {{ $receipt_details->customer_tax_number }}
			@endif
			@if(!empty($receipt_details->customer_custom_fields))
				<br/>{!! $receipt_details->customer_custom_fields !!}
			@endif
			@if(!empty($receipt_details->sales_person_label))
				<br/>
				<strong>{{ $receipt_details->sales_person_label }}</strong> {{ $receipt_details->sales_person }}
			@endif
		</div>
		<br>
		<div class="col-md-6 invoice-col width-50 word-wrap">
			<strong>@lang('lang_v1.shipping_address'):</strong><br>
			{!! $receipt_details->shipping_address !!}
			<br>
			@if(!empty($receipt_details->shipping_custom_field_1_label))
				<br><strong>{!!$receipt_details->shipping_custom_field_1_label!!} :</strong> {!!$receipt_details->shipping_custom_field_1_value ?? ''!!}
			@endif
	
			@if(!empty($receipt_details->shipping_custom_field_2_label))
				<br><strong>{!!$receipt_details->shipping_custom_field_2_label!!}:</strong> {!!$receipt_details->shipping_custom_field_2_value ?? ''!!}
			@endif
	
			@if(!empty($receipt_details->shipping_custom_field_3_label))
				<br><strong>{!!$receipt_details->shipping_custom_field_3_label!!}:</strong> {!!$receipt_details->shipping_custom_field_3_value ?? ''!!}
			@endif
	
			@if(!empty($receipt_details->shipping_custom_field_4_label))
				<br><strong>{!!$receipt_details->shipping_custom_field_4_label!!}:</strong> {!!$receipt_details->shipping_custom_field_4_value ?? ''!!}
			@endif
	
			@if(!empty($receipt_details->shipping_custom_field_5_label))
				<br><strong>{!!$receipt_details->shipping_custom_field_2_label!!}:</strong> {!!$receipt_details->shipping_custom_field_5_value ?? ''!!}
			@endif
		</div>
	</div> 
	
</div>

<div class="row  font-10">
	<div class="col-xs-12">
		
		<table class="table-slim table-bordered table-top-cell-border">
			<thead>
				<tr style="background-color: #c !important; color: white !important; font-size: 13px !important" class="table-no-side-cell-border table-no-top-cell-border text-center">
					<td style="background-color: #003350 !important; color: white !important; width: 5% !important">#</td>
					
					<td style="background-color: #003350 !important; color: white !important; width: 80% !important">
						{{$receipt_details->table_product_label}}
					</td>
					
					<td style="background-color: #003350 !important; color: white !important; width: 15% !important;">
						{{$receipt_details->table_qty_label}}
					</td>
				</tr>
			</thead>
			<tbody>
				@foreach($receipt_details->lines as $line)
					<tr>
						<td class="text-center">
							{{$loop->iteration}}
						</td>
						<td style="word-break: break-all;">
                            {{$line['name']}} {{$line['product_variation']}} {{$line['variation']}} 
                            @if(!empty($line['sub_sku'])), {{$line['sub_sku']}} @endif @if(!empty($line['brand'])), {{$line['brand']}} @endif
                            @if(!empty($line['product_custom_fields'])), {{$line['product_custom_fields']}} @endif
                            @if(!empty($line['sell_line_note']))({!!$line['sell_line_note']!!}) @endif
                            @if(!empty($line['lot_number']))<br> {{$line['lot_number_label']}}:  {{$line['lot_number']}} @endif 
                            @if(!empty($line['product_expiry'])), {{$line['product_expiry_label']}}:  {{$line['product_expiry']}} @endif 
                        </td>
						<td class="text-center">
							{{$line['quantity']}} {{$line['units']}}
						</td>
					</tr>
					@if(!empty($line['modifiers']))
						@foreach($line['modifiers'] as $modifier)
							<tr>
								<td class="text-center">
									&nbsp;
								</td>
								<td>
		                            {{$modifier['name']}} {{$modifier['variation']}} 
		                            @if(!empty($modifier['sub_sku'])), {{$modifier['sub_sku']}} @endif 
		                            @if(!empty($modifier['sell_line_note']))({!!$modifier['sell_line_note']!!}) @endif 
		                        </td>
								<td class="text-right">
									{{$modifier['quantity']}} {{$modifier['units']}}
								</td>
							</tr>
						@endforeach
					@endif
				@endforeach

				@php
					$lines = count($receipt_details->lines);
				@endphp

				@for ($i = $lines; $i < 7; $i++)
    				<tr>
    					<td>&nbsp;</td>
    					<td>&nbsp;</td>
    					<td>&nbsp;</td>
    				</tr>
				@endfor

			</tbody>
		</table>
	</div>
</div>
<br>
<br>
<br>
<br>
________________________
<div class="row invoice-info " style="page-break-inside: avoid !important">
	<div class="col-md-6 invoice-col width-50">
		<b class="pull-left">@lang('lang_v1.authorized_signatory')</b>
	</div>
</div>

{{-- Barcode --}}
@if($receipt_details->show_barcode)
<br>
<div class="row">
		<div class="col-xs-12">
			<img class="center-block" src="data:image/png;base64,{{DNS1D::getBarcodePNG($receipt_details->invoice_no, 'C128', 2,30,array(39, 48, 54), true)}}">
		</div>
</div>
@endif

{{-- @if(!empty($receipt_details->footer_text))
	<div class="row color-555">
		<div class="col-xs-12">
			{!! $receipt_details->footer_text !!}
		</div>
	</div>
@endif --}}

			</td>
		</tr>
	</tbody>
</table>