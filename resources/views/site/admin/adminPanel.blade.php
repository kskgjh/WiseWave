@extends('layouts.mainLayout')

@section('links')
    <link rel="stylesheet" href="{{asset('css/adminPanel.css')}}">
@endsection

@section('title', 'Admin - WiseWave')

@section('main')
    @livewire('admin.selector')
@endsection