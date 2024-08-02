@extends('layouts.app')
@section('title', __('inventorymanagement::inventory.inventory'))
@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.13.1/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ url('css/inventory.css') }}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
@endsection
@section('content')

    <section class="content-header">
        <h1>@lang('inventorymanagement::inventory.stock_inventory')</h1>
        <!-- <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
            <li class="active">Here</li>
        </ol> -->
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header text-center" style="background-color:#484848;color:#EDAF11;font-size: 30px;">
                @lang("inventorymanagement::inventory.products_inventory")
            </div>
        </div>

        
        
       
            <div class="text-center">@lang('inventorymanagement::inventory.closed_inventory')</div>
    </section>

@endsection

@section('javascript')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.2.0/js/dataTables.dateTime.min.js"></script>


    <script src="{{ asset('js/purchase.js?v=' . $asset_v) }}"></script>

    @include('inventorymanagement::partials.mainscript')

    <script src="{{ asset('js/vendor.js?v=' . $asset_v) }}"></script>
    <script type="text/javascript">__page_leave_confirmation('#purchase_return_form');</script>
    {{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

@endsection

