@extends('layouts.app')

@section('title', 'Configuration')

@section('content')

<div class="home-content">
    <div class="overview-boxes">
        <div class="box">
        <a href="" class="list-group-item list-group-item-action">
            Company Information
        </a>
        <a href="" class="list-group-item list-group-item-action">
            Profile Settings
        </a>
        <a href="{{ route('depot.settings') }}" class="list-group-item list-group-item-action">
            Depot Settings
        </a>
        </div>
    </div>
</div>

@endsection