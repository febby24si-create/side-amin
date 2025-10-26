<!-- resources/views/lembaga/create.blade.php -->
@extends('layouts.admin')

@section('title', 'Tambah Lembaga Desa')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-plus-circle"></i> Tambah Lembaga Desa
    </h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.lembaga.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama_lembaga">Nama Lembaga</label>
                    <input type="text" class="form-control @error('nama_lembaga') is-invalid @enderror" 
                           id="nama_lembaga" name="nama_lembaga" value="{{ old('nama_lembaga') }}" required>
                    @error('nama_lembaga')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                              id="deskripsi" name="deskripsi" rows="3" required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="kontak">Kontak</label>
                    <input type="text" class="form-control @error('kontak') is-invalid @enderror" 
                           id="kontak" name="kontak" value="{{ old('kontak') }}">
                    @error('kontak')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.lembaga.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection