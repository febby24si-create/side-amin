<!-- resources/views/lembaga/anggota_index.blade.php -->
@extends('layouts.admin')

@section('title', 'Anggota Lembaga')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-users"></i> Anggota {{ $lembaga->nama_lembaga }}
    </h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Daftar Anggota - {{ $lembaga->nama_lembaga }}
                    </h6>
                </div>
                <div class="col-md-6 text-right">
                    <a href="{{ route('admin.lembaga.anggota.create', $lembaga->id) }}" 
                       class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Anggota
                    </a>
                    <a href="{{ route('admin.lembaga.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Statistik -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Anggota</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $anggotas->count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Ketua</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $anggotas->where('jabatan.level', 'Ketua')->count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-crown fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Aktif</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $anggotas->where('tgl_selesai', null)->count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Anggota -->
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama Anggota</th>
                            <th>Jabatan</th>
                            <th>Level</th>
                            <th>Periode</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($anggotas as $anggota)
                        <tr>
                            <td>
                                <strong>{{ $anggota->warga->nama }}</strong>
                                <br>
                                <small class="text-muted">NIK: {{ $anggota->warga->nik }}</small>
                            </td>
                            <td>
                                {{ $anggota->jabatan->nama_jabatan }}
                            </td>
                            <td>
                                @switch($anggota->jabatan->level)
                                    @case('Ketua')
                                        <span class="badge badge-success">
                                            <i class="fas fa-crown"></i> {{ $anggota->jabatan->level }}
                                        </span>
                                        @break
                                    @case('Sekretaris')
                                        <span class="badge badge-info">
                                            <i class="fas fa-pen"></i> {{ $anggota->jabatan->level }}
                                        </span>
                                        @break
                                    @case('Bendahara')
                                        <span class="badge badge-warning">
                                            <i class="fas fa-money-bill"></i> {{ $anggota->jabatan->level }}
                                        </span>
                                        @break
                                    @case('Anggota')
                                        <span class="badge badge-secondary">
                                            <i class="fas fa-user"></i> {{ $anggota->jabatan->level }}
                                        </span>
                                        @break
                                    @default
                                        <span class="badge badge-dark">
                                            <i class="fas fa-star"></i> {{ $anggota->jabatan->level }}
                                        </span>
                                @endswitch
                            </td>
                            <td>
                                <span class="badge badge-light">
                                    {{ $anggota->tgl_mulai->format('d/m/Y') }}
                                </span>
                                @if($anggota->tgl_selesai)
                                <br>
                                <span class="badge badge-light">
                                    s/d {{ $anggota->tgl_selesai->format('d/m/Y') }}
                                </span>
                                @endif
                            </td>
                            <td>
                                @if($anggota->tgl_selesai && $anggota->tgl_selesai < now())
                                    <span class="badge badge-danger">
                                        <i class="fas fa-times-circle"></i> Tidak Aktif
                                    </span>
                                @elseif($anggota->tgl_selesai && $anggota->tgl_selesai > now())
                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock"></i> Akan Berakhir
                                    </span>
                                @else
                                    <span class="badge badge-success">
                                        <i class="fas fa-check-circle"></i> Aktif
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.lembaga.anggota.edit', [$lembaga->id, $anggota->id]) }}" 
                                       class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.lembaga.anggota.destroy', [$lembaga->id, $anggota->id]) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('Hapus anggota ini?')"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($anggotas->isEmpty())
            <div class="text-center py-4">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <p class="text-muted">Belum ada anggota untuk lembaga ini.</p>
                <a href="{{ route('admin.lembaga.anggota.create', $lembaga->id) }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Anggota Pertama
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection