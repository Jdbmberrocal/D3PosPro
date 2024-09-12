@extends('layouts.app')

@section('title','Reenviar factura a la DIAN')

@section('content')
    <section class="content no-print">
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            @if (session('success'))
                <div class="alert alert-success">
                  {{ session('success') }}
                </div>
            @endif
            
            <div class="card-body">
              <h5 class="card-title">Reenviar factura a la DIAN</h5>
              <form method="POST" action="{{route('resend_invoice_data',$sell->id)}}">
                @csrf
                <input type="hidden" name="id" value="{{$sell->id}}">
                <span class="badge bg-info text-dark">{{$sell->contact->email}}</span>
                <span class="badge bg-info text-dark">{{$sell->invoice_no}}</span>
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="" class="form-label">Cliente</label>
                      @if($sell->contact->supplier_business_name)
                      <input type="text" class="form-control" disabled value="{{$sell->contact->supplier_business_name}}">
                      @else
                      <input type="text" class="form-control" disabled value="{{$sell->contact->name}}">
                      @endif
                    </div>
                  </div>
   
                  
                  
                </div>
                <button type="submit" class="btn btn-primary mt-5">Reenviar factura</button>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-6"></div>
      </div>
      
    </section>


@stop
@section('css')
  
@stop
@section('javascript')
   
@endsection
