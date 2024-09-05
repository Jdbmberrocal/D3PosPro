@extends('layouts.app')

@section('title','Reenviar factura por correo')

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
              <h5 class="card-title">Reenviar factura a otro correo</h5>
              <form method="POST" action="{{route('send_invoice')}}">
                @csrf
                <span class="badge bg-info text-dark">{{$sell->contact->email}}</span>
                <span class="badge bg-info text-dark">{{$sell->invoice_no}}</span>
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="" class="form-label">Cliente</label>
                      <input type="text" class="form-control" disabled value="{{$sell->contact->supplier_business_name}}">
                    </div>
                  </div>
   
                  <div class="col-md-3">
                    <div class="mb-3">
                      <label for="" class="form-label">Prefijo</label>
                      <input type="text" class="form-control" name="prefix" id="" value="">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="mb-3">
                      <label for="" class="form-label">Número</label>
                      <input type="text" class="form-control" name="number" id="" value="">
                    </div>
                  </div>
                  
                </div>
                <button type="submit" class="btn btn-primary mt-5">Reenviar correo</button>
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
