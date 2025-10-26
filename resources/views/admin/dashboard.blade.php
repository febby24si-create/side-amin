@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard SIPEDES')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </h1>
        <div>
            <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Total Warga Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Warga</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalWarga }}</div>
                            <div class="mt-2">
                                <span class="badge badge-primary">
                                    <i class="fas fa-male"></i> Laki-laki: {{ App\Models\Warga::where('jenis_kelamin', 'Laki-laki')->count() }}
                                </span>
                                <span class="badge badge-pink mt-1">
                                    <i class="fas fa-female"></i> Perempuan: {{ App\Models\Warga::where('jenis_kelamin', 'Perempuan')->count() }}
                                </span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lembaga Desa Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Lembaga Desa</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalLembaga }}</div>
                            <div class="mt-2">
                                @php
                                    $totalAnggota = App\Models\AnggotaLembaga::count();
                                @endphp
                                <span class="badge badge-success">
                                    <i class="fas fa-users"></i> Total Anggota: {{ $totalAnggota }}
                                </span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-building fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RW Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                RW</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalRw }}</div>
                            <div class="mt-2">
                                <span class="badge badge-info">
                                    <i class="fas fa-map-marker-alt"></i> Wilayah Tercover
                                </span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-signs fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RT Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                RT</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalRt }}</div>
                            <div class="mt-2">
                                <span class="badge badge-warning">
                                    <i class="fas fa-home"></i> Unit Terkecil
                                </span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marker-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bolt"></i> Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('admin.warga.create') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-user-plus"></i> Tambah Warga
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('admin.lembaga.create') }}" class="btn btn-success btn-block">
                                <i class="fas fa-plus-circle"></i> Tambah Lembaga
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('admin.user.create') }}" class="btn btn-info btn-block">
                                <i class="fas fa-user-plus"></i> Tambah User
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="#" class="btn btn-danger btn-block" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle"></i> Sistem Status
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <span class="badge badge-success mr-2">Aktif</span>
                        <span class="badge badge-warning mr-2">Akan Berakhir</span>
                        <span class="badge badge-danger mr-2">Tidak Aktif</span>
                    </div>
                    <div class="mb-3">
                        <span class="badge badge-primary mr-2">Laki-laki</span>
                        <span class="badge badge-pink mr-2">Perempuan</span>
                        <span class="badge badge-secondary mr-2">Anggota</span>
                    </div>
                    <div>
                        <span class="badge badge-success mr-2">Ketua</span>
                        <span class="badge badge-info mr-2">Sekretaris</span>
                        <span class="badge badge-warning mr-2">Bendahara</span>
                    </div>
                    <hr>
                    <div class="text-center">
                        <p class="mb-1"><strong>Login sebagai:</strong></p>
                        <span class="badge badge-{{ Auth::user()->role == 'admin' ? 'success' : 'info' }}">
                            <i class="fas fa-user"></i> 
                            {{ Auth::user()->nama_lengkap }} ({{ Auth::user()->role }})
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Session Info -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user-clock"></i> Informasi Session
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ Auth::user()->nama_lengkap }}</div>
                            <small class="text-muted">Nama Pengguna</small>
                        </div>
                        <div class="col-md-4">
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ Auth::user()->username }}</div>
                            <small class="text-muted">Username</small>
                        </div>
                        <div class="col-md-4">
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <span class="badge badge-{{ Auth::user()->role == 'admin' ? 'success' : 'info' }}">
                                    {{ Auth::user()->role }}
                                </span>
                            </div>
                            <small class="text-muted">Role</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.badge-pink {
    background-color: #e83e8c;
    color: white;
}
.badge-light {
    background-color: #f8f9fa;
    color: #6c757d;
    border: 1px solid #dee2e6;
}
</style>
@endsection