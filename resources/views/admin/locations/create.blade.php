@extends('layouts.admin')

@section('title', 'Nueva sucursal')
@section('admin_title', 'Nueva sucursal')
@section('admin_kicker', 'Ubicaciones')

@section('content')
    <form method="POST" action="{{ route('admin.locations.store') }}" class="space-y-6">
        @csrf
        @include('admin.locations._form')

        <div class="flex flex-wrap justify-end gap-3">
            <a href="{{ route('admin.locations.index') }}" class="btn-secondary">Cancelar</a>
            <button type="submit" class="btn-primary">Guardar sucursal</button>
        </div>
    </form>
@endsection
