<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action([\App\Http\Controllers\TypesOfServiceController::class, 'store']), 'method' => 'post', 'id' => 'types_of_service_form' ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'lang_v1.add_type_of_service' )</h4>
    </div>

    <div class="modal-body">
      <div class="row">
      <div class="form-group col-md-12">
        {!! Form::label('name', __( 'tax_rate.name' ) . ':*') !!}
          {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'tax_rate.name' )]); !!}
      </div>

      <div class="form-group col-md-12">
        {!! Form::label('description', __( 'lang_v1.description' ) . ':') !!}
          {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __( 'lang_v1.description' ), 'rows' => 3]); !!}
      </div>

      <div class="form-group col-md-12">
      <table class="table table-slim">
        <thead>
          <tr>
            <th>@lang('sale.location')</th>
            <th>@lang('lang_v1.price_group')</th> 
          </tr>
          @foreach($locations as $key => $value)
            <tr>
              <td>{{$value}}</td>
              <td>{!! Form::select('location_price_group[' . $key . ']', $price_groups, null, ['class' => 'form-control input-sm select2', 'style' => 'width: 100%;']); !!}</td>
            </tr>
          @endforeach
        </thead>
      </table>
      </div>
       <div class="form-group col-md-6">
        {!! Form::label('packing_charge_type', __( 'lang_v1.packing_charge_type' ) . ':') !!}
          {!! Form::select('packing_charge_type', ['fixed' => __('lang_v1.fixed'), 'percent' => __('lang_v1.percentage')], 'fixed', ['class' => 'form-control']); !!}
      </div>
      <div class="form-group col-md-6">
        {!! Form::label('packing_charge', __( 'lang_v1.packing_charge' ) . ':') !!}
          {!! Form::text('packing_charge', null, ['class' => 'form-control input_number', 'placeholder' => __( 'lang_v1.packing_charge' )]); !!}
      </div>
      <div class="form-group col-md-12">
          <div class="checkbox">
            <label>
               {!! Form::checkbox('enable_custom_fields', 1, false); !!} @lang( 'lang_v1.enable_custom_fields' )
            </label> @show_tooltip(__('lang_v1.types_of_service_custom_field_help'))
          </div>
      </div>
      </div>
    </div>

    <div class="modal-footer">
      <button type="submit" class="tw-dw-btn tw-dw-btn-primary tw-text-white">@lang( 'messages.save' )</button>
      <button type="button" class="tw-dw-btn tw-dw-btn-neutral tw-text-white" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->