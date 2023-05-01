@extends('layouts.mainLayout')

@section('links')
<link rel="stylesheet" href="{{asset('css/adminPanel.css')}}">
@endsection

@section('title', 'Admin - WiseWave')

@section('main')
    @component('components.admin.selector', ['products'=> $products])@endcomponent
@endsection