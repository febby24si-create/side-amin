<!-- resources/views/lembaga/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Lembaga Desa')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-building"></i> Lembaga Desa
    </h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Lembaga Desa</h6>
                </div>
                <div class="col-md-6 text-right">
                    <a href="{{ route('admin.lembaga.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Lembaga
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Form Pencarian -->
            <form action="{{ route('admin.lembaga.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari berdasarkan nama lembaga atau deskripsi..." 
                           name="search" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </div>
            </form>

            <div class="row">
                @foreach($lembagas as $lembaga)
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-{{ $loop->index % 3 == 0 ? 'primary' : ($loop->index % 3 == 1 ? 'success' : 'info') }} shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-{{ $loop->index % 3 == 0 ? 'primary' : ($loop->index % 3 == 1 ? 'success' : 'info') }} text-uppercase mb-1">
                                        {{ $lembaga->nama_lembaga }}
                                    </div>
                                    <div class="mb-1 text-muted small">
                                        {{ Str::limit($lembaga->deskripsi, 80) }}
                                    </div>
                                    <div class="mb-2">
                                        <span class="badge badge-primary">
                                            <i class="fas fa-users"></i> {{ $lembaga->anggotas_count }} Anggota
                                        </span>
                                        <span class="badge badge-secondary">
                                            <i class="fas fa-tag"></i> {{ $lembaga->jabatans_count }} Jabatan
                                        </span>
                                    </div>
                                    @if($lembaga->kontak)
                                    <div class="mb-2">
                                        <span class="badge badge-light">
                                            <i class="fas fa-phone"></i> {{ $lembaga->kontak }}
                                        </span>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-building fa-2x text-gray-300"></i>
                                </div>
                            </div>
                            <div class="mt-3 text-right">
                                <a href="{{ route('admin.lembaga.show', $lembaga->id) }}" 
                                   class="btn btn-info btn-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.lembaga.anggota.index', $lembaga->id) }}" 
                                   class="btn btn-success btn-sm" title="Kelola Anggota">
                                    <i class="fas fa-users"></i>
                                </a>
                                <a href="{{ route('admin.lembaga.edit', $lembaga->id) }}" 
                                   class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.lembaga.destroy', $lembaga->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Hapus lembaga ini?')"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($lembagas->isEmpty())
            <div class="text-center py-4">
                <i class="fas fa-building fa-3x text-muted mb-3"></i>
                <p class="text-muted">Belum ada lembaga desa yang terdaftar.</p>
                <a href="{{ route('admin.lembaga.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Lembaga Pertama
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection