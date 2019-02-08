@extends('layouts.dashboard')

@section('content')
<form-pasien-edit :item="{{$pasien}}"></form-pasien-edit>
@endsection