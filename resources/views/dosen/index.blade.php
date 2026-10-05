@extends('layouts.dosen')

@section('content-header')
  <h1>Beranda</h1><hr>
@endsection

@section('content')
  <p>Selamat datang, pengguna {{ session('nama') }}!</p>
@endsection