<!-- resources/views/warga/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Data Warga')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-users"></i> Data Warga
    </h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Warga</h6>
                </div>
                <div class="col-md-6 text-right">
                    <a href="{{ route('admin.warga.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Warga
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Form Pencarian -->
            <form action="{{ route('admin.warga.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari berdasarkan nama, NIK, atau alamat..." 
                           name="search" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>RT/RW</th>
                            <th>Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wargas as $warga)
                        <tr>
                            <td>
                                <span class="font-weight-bold text-primary">{{ $warga->nik }}</span>
                            </td>
                            <td>
                                <strong>{{ $warga->nama }}</strong>
                                <br>
                                <small class="text-muted">{{ Str::limit($warga->alamat, 50) }}</small>
                            </td>
                            <td>
                                <span class="badge badge-light">
                                    {{ $warga->tgl_lahir->format('d/m/Y') }}
                                </span>
                                <br>
                                <small class="text-muted">Usia: {{ $warga->tgl_lahir->age }} tahun</small>
                            </td>
                            <td>
                                @if($warga->jenis_kelamin == 'Laki-laki')
                                    <span class="badge badge-primary">
                                        <i class="fas fa-male"></i> Laki-laki
                                    </span>
                                @else
                                    <span class="badge badge-pink">
                                        <i class="fas fa-female"></i> Perempuan
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($warga->rt && $warga->rw)
                                    <span class="badge badge-info">RT {{ $warga->rt->nomor_rt }}</span>
                                    <span class="badge badge-secondary">RW {{ $warga->rw->nomor_rw }}</span>
                                @else
                                    <span class="badge badge-warning">Belum Ditentukan</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $isKetua = $warga->id == optional($warga->rw)->ketua_rw_warga_id || 
                                             $warga->id == optional($warga->rt)->ketua_rt_warga_id;
                                @endphp
                                @if($isKetua)
                                    <span class="badge badge-success">
                                        <i class="fas fa-star"></i> Ketua
                                    </span>
                                @else
                                    <span class="badge badge-light">Warga</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.warga.show', $warga->id) }}" 
                                       class="btn btn-info btn-sm" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.warga.edit', $warga->id) }}" 
                                       class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.warga.destroy', $warga->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('Apakah Anda yakin menghapus data ini?')"
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

            <!-- Pagination -->
            @if($wargas->hasPages())
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    Showing {{ $wargas->firstItem() }} to {{ $wargas->lastItem() }} of {{ $wargas->total() }} results
                </div>
                {{ $wargas->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection