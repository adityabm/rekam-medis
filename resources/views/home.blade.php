@extends('layouts.dashboard')

@section('content')
<fieldset>
    <legend>Jumlah Pasien Berdasarkan Jenjang</legend>
    <div class="row">
      @foreach($total as $t)
      <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
          <div class="card-body">
            <div class="clearfix">
              <div class="float-left">
                <i class="mdi mdi-account icon-lg"></i>
              </div>
              <div class="float-right">
                <p class="mb-0 text-right">{{$t->name}}</p>
                <div class="fluid-container">
                  <h3 class="font-weight-medium text-right mb-0">{{$t->jumlah}} Orang</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach

      @if($other > 0)
      <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
          <div class="card-body">
            <div class="clearfix">
              <div class="float-left">
                <i class="mdi mdi-account text-danger icon-lg"></i>
              </div>
              <div class="float-right">
                <p class="mb-0 text-right">Lainnya</p>
                <div class="fluid-container">
                  <h3 class="font-weight-medium text-right mb-0">{{$other}} Orang</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endif
    </div>
</fieldset>
@endsection
