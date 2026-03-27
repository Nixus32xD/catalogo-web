@extends('layouts.admin')

@section('title', 'Nueva categoria')
@section('admin_title', 'Nueva categoria')
@section('admin_kicker', 'Organizacion')

@section('content')
    <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-6">
        @csrf
        @include('admin.categories._form')

        <div class="flex flex-wrap justify-end gap-3">
            <a href="{{ route('admin.categories.index') }}" class="btn-secondary">Cancelar</a>
            <button type="submit" class="btn-primary">Guardar categoria</button>
        </div>
    </form>
@endsection
