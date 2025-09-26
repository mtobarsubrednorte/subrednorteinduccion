@extends('layouts.app')

@section('title', 'Panel de Administración')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">


@endsection

@section('content')

    <div class="admin-dashboard">
        <h2>Bienvenido al Panel de Administración</h2>
        <p>Desde aquí puedes gestionar usuarios, roles y permisos.</p>

        <div class="admin-actions">
            <a href="#" class="btn btn-primary">Gestionar Usuarios</a>
            <a href="#" class="btn btn-secondary">Gestionar Roles</a>
            <a href="#" class="btn btn-success">Gestionar Permisos</a>
            <a href="#" class="btn btn-danger">Crear Cursos</a>
        </div>
    </div>




@endsection