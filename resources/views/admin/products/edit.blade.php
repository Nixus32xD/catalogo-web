@extends('layouts.admin')

@section('title', 'Editar producto')
@section('admin_title', 'Editar producto')
@section('admin_kicker', 'Catalogo interno')

@section('content')
    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        @include('admin.products._form')

        <div class="flex flex-wrap justify-end gap-3">
            <a href="{{ route('admin.products.index') }}" class="btn-secondary">Cancelar</a>
            <button type="submit" class="btn-primary">Actualizar producto</button>
        </div>
    </form>
@endsection
