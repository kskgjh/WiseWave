@extends('layouts.mainLayout')

@section('links')
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
@endsection

@section('title', 'Home - WiseWave')

@section('main')
    @livewire('carroussel')
@endsection

