@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('pageTitle', 'Dashboard Overview')
@section('pageSubTitle', 'Selamat datang di panel admin sistem presensi')
@section('content')
    @switch(auth()->user()->role)
        @case('admin')
            @include('admin.dashboard.admin')
        @break

        @case('sdm')
            @include('admin.dashboard.sdm')
        @break

        @case('pegawai')
            @include('admin.dashboard.pegawai')
        @break

        @default
            <p>Role tidak dikenal.</p>
    @endswitch
@endsection
