<div class="modal" tabindex="-1" id="editProductModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">@lang('inventorymanagement::inventory.edit_inv') <span id="editProductModal_product_name"></span></h4>

            </div>
            <div class="modal-body">
              <input type="hidden" id="values_in">
                <div class="form-group">
                    <label for="new_product_qty">@lang('inventorymanagement::inventory.current_product_qty')</label>
                    <input type="number" class="form-control" id="new_product_qty" readonly>
                  </div>
                <div class="form-group">
                    <label for="inv_product_before_qty">@lang('inventorymanagement::inventory.current_amount')</label>
                    <input type="number" class="form-control" id="inv_product_before_qty" readonly>
                  </div>
                  <div class="form-group">
                      <label for="produ_after_inv">@lang('inventorymanagement::inventory.amount_after_inventory')</label>
                      <input type="number" class="form-control" id="produ_after_inv" >
                    </div>
                  
                <div class="form-group">
                    <label for="product_fa_qty">@lang('inventorymanagement::inventory.amount_difference')</label>
                    <input type="number" class="form-control" id="product_fa_qty" readonly>
                  </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" aria-label="@lang('inventorymanagement::inventory.close')" data-dismiss="modal" id="editProductModalClose">@lang('inventorymanagement::inventory.close')</button>
                <button type="button" class="btn btn-primary" id="save_new_inv_qty">@lang('inventorymanagement::inventory.save_changes')</button>
            </div>
        </div>
    </div>
</div>
