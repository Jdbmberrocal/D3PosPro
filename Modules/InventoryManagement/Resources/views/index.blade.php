@extends('layouts.app')
@section('title', __('inventorymanagement::inventory.inventory'))

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>@lang('inventorymanagement::inventory.inventory')</h1>
        <h3>@lang('inventorymanagement::inventory.create_new_inventory')</h3>
    </section>

    <!-- Main content -->
    <section class="content">
        <form method="post" action="{{url("inventorymanagement/createNewInventory")}}">
            @csrf
        <div class="row">
            <label style="margin:17px">@lang("inventorymanagement::inventory.inventory_start_date")</label></br>
            <div class="col-md-6">
                <div class="input-group">
						<span class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</span>
                    <input style="height: 45px" class="form-control"  required="" name="inventory_start_date" type="date" >
                </div>
            </div>
        </div>
        <div class="row">
            <label style="margin:17px">@lang("inventorymanagement::inventory.inventory_end_date")</label></br>
            <div class="col-md-6">
                <div class="input-group">
						<span class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</span>
                    <input style="height: 45px" class="form-control"  required="" name="inventory_end_date" type="date" >
                </div>
            </div>
        </div>
        <div class="row">
            <label style="margin:17px">@lang("inventorymanagement::inventory.inventory_branch")</label></br>
            <div class="col-md-6">
                <div class="input-group">
						<span class="input-group-addon">
							<i class="fa fa-code-branch"></i>
						</span>
                    <select class="form-control" name="branch">
                        @foreach($branches as $branch)
                            <option id="1" value="{{ $branch->id }}">{{$branch->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </br>
    </br>
        <button type="submit" class="btn btn-primary">@lang('inventorymanagement::inventory.save')</button>
        </form>
    </section>
    <!-- /.content -->
@include('inventorymanagement::partials.mainscript')
@endsection
