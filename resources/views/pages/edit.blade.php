@extends('layouts.dashboard')

@section('content')
<form-pasien-edit :item="{{$pasien}}" :jenjang="{{$jenjang}}"></form-pasien-edit>
@endsection