<!-- resources/views/lembaga/show.blade.php -->
@extends('layouts.admin')

@section('title', 'Detail Lembaga Desa')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-building"></i> Detail Lembaga Desa
    </h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Lengkap Lembaga Desa</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Nama Lembaga</th>
                            <td>{{ $lembaga->nama_lembaga }}</td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>{{ $lembaga->deskripsi }}</td>
                        </tr>
                        <tr>
                            <th>Kontak</th>
                            <td>{{ $lembaga->kontak ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Total Jabatan</th>
                            <td>
                                <span class="badge badge-primary">{{ $lembaga->jabatans_count }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Total Anggota</th>
                            <td>
                                <span class="badge badge-success">{{ $lembaga->anggotas_count }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge badge-success">Aktif</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <h5 class="font-weight-bold">Struktur Jabatan</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Jabatan</th>
                                    <th>Level</th>
                                    <th>Jumlah Anggota</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lembaga->jabatans as $jabatan)
                                <tr>
                                    <td>{{ $jabatan->nama_jabatan }}</td>
                                    <td>
                                        @switch($jabatan->level)
                                            @case('Ketua')
                                                <span class="badge badge-success">
                                                    <i class="fas fa-crown"></i> {{ $jabatan->level }}
                                                </span>
                                                @break
                                            @case('Sekretaris')
                                                <span class="badge badge-info">
                                                    <i class="fas fa-pen"></i> {{ $jabatan->level }}
                                                </span>
                                                @break
                                            @case('Bendahara')
                                                <span class="badge badge-warning">
                                                    <i class="fas fa-money-bill"></i> {{ $jabatan->level }}
                                                </span>
                                                @break
                                            @case('Anggota')
                                                <span class="badge badge-secondary">
                                                    <i class="fas fa-user"></i> {{ $jabatan->level }}
                                                </span>
                                                @break
                                            @default
                                                <span class="badge badge-dark">
                                                    <i class="fas fa-star"></i> {{ $jabatan->level }}
                                                </span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">
                                            {{ $jabatan->anggotas_count }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <h5 class="font-weight-bold">Daftar Anggota</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Anggota</th>
                                    <th>Jabatan</th>
                                    <th>Level</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lembaga->anggotas as $anggota)
                                <tr>
                                    <td>{{ $anggota->warga->nama }}</td>
                                    <td>{{ $anggota->jabatan->nama_jabatan }}</td>
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
                                    <td>{{ $anggota->tgl_mulai->format('d/m/Y') }}</td>
                                    <td>{{ $anggota->tgl_selesai ? $anggota->tgl_selesai->format('d/m/Y') : '-' }}</td>
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
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 text-right">
                    <a href="{{ route('admin.lembaga.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection