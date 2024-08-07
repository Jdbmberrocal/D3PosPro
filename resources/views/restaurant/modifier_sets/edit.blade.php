<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action([\App\Http\Controllers\Restaurant\ModifierSetsController::class, 'update'], [$modifer_set->id]), 'method' => 'PUT', 'id' => 'edit_form' ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'restaurant.edit_modifier' )</h4>
    </div>

    <div class="modal-body">

      <div class="row">
        
        <div class="col-sm-12">
          <div class="form-group">
            {!! Form::label('name', __( 'restaurant.modifier_set' ) . ':*') !!}
            {!! Form::text('name', $modifer_set->name, ['class' => 'form-control', 'required', 'placeholder' => __( 'lang_v1.name' ) ]); !!}
          </div>
        </div>

        <div class="col-sm-12">
          <h4>@lang( 'restaurant.modifiers' )</h4>
        </div>

        <div class="col-sm-12">
          <table class="table table-condensed" id="add-modifier-table">
            <thead>
              <tr>
                <th>@lang( 'restaurant.modifier')</th>
                <th>
                  @lang( 'lang_v1.price')

                  @php
                    $html = '<tr><td>
                          <div class="form-group">
                            <input type="text" name="modifier_name[]" 
                            class="form-control" 
                            placeholder="' . __( 'lang_v1.name' ) . '" required>
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <input type="text" name="modifier_price[]" class="form-control input_number" 
                            placeholder="' . __( 'lang_v1.price' ) . '" required>
                          </div>
                        </td>
                        <td>
                          <button class="tw-dw-btn tw-dw-btn-xs tw-dw-btn-outline  tw-dw-btn-error pull-right remove-modifier-row" type="button"><i class="fa fa-minus"></i></button>
                        </td>
                        </tr>';
                  @endphp
                </th>
                <th>&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              @foreach($modifer_set->variations as $modifier)
                <tr>
                  <td>
                    <div class="form-group">
                      <input type="text" name="modifier_name_edit[{{$modifier->id}}]" 
                        class="form-control" value="{{$modifier->name}}" placeholder="@lang( 'lang_v1.name' )" required>
                    </div>
                  </td>
                  <td>
                    <div class="form-group">
                      <input type="text" name="modifier_price_edit[{{$modifier->id}}]" 
                      class="form-control input_number" value="{{@num_format($modifier->sell_price_inc_tax)}}" placeholder="@lang( 'lang_v1.price' )" required>
                    </div>
                  </td>
                  <td>
                    @if(!$loop->first)
                      <button class="tw-dw-btn tw-dw-btn-xs tw-dw-btn-outline  tw-dw-btn-error pull-right remove-modifier-row" type="button"><i class="fa fa-minus"></i></button>
                    @else
                      <button class="tw-dw-btn tw-dw-btn-xs tw-dw-btn-outline  tw-dw-btn-primary pull-right add-modifier-row" type="button" data-html="{{ $html }}">
                        <i class="fa fa-plus"></i>
                      </button>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
    </div>

    <div class="modal-footer">
      <button type="submit" class="tw-dw-btn tw-dw-btn-primary tw-text-white">@lang( 'messages.update' )</button>
      <button type="button" class="tw-dw-btn tw-dw-btn-neutral tw-text-white" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->