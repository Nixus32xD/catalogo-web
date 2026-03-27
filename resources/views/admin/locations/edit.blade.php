@extends('layouts.admin')

@section('title', 'Editar sucursal')
@section('admin_title', 'Editar sucursal')
@section('admin_kicker', 'Ubicaciones')

@section('content')
    <form method="POST" action="{{ route('admin.locations.update', $location) }}" class="space-y-6">
        @csrf
        @method('PUT')
        @include('admin.locations._form')

        <div class="flex flex-wrap justify-end gap-3">
            <a href="{{ route('admin.locations.index') }}" class="btn-secondary">Cancelar</a>
            <button type="submit" class="btn-primary">Actualizar sucursal</button>
        </div>
    </form>
@endsection
