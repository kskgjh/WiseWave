@extends('layouts.mainLayout')

@section('links')
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
@endsection

@section('title', 'Home - WiseWave')

@section('main')

    @component('components.site.carrossel')@endcomponent
    @component('components.site.most-saled-products')@endcomponent

@endsection

