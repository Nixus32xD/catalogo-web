@extends('layouts.admin')

@section('title', 'Editar categoria')
@section('admin_title', 'Editar categoria')
@section('admin_kicker', 'Organizacion')

@section('content')
    <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-6">
        @csrf
        @method('PUT')
        @include('admin.categories._form')

        <div class="flex flex-wrap justify-end gap-3">
            <a href="{{ route('admin.categories.index') }}" class="btn-secondary">Cancelar</a>
            <button type="submit" class="btn-primary">Actualizar categoria</button>
        </div>
    </form>
@endsection
