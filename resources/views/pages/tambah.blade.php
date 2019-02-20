@extends('layouts.dashboard')

@section('content')
<form-pasien :jenjang="{{$jenjang}}"></form-pasien>
@endsection
