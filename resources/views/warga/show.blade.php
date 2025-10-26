<!-- resources/views/warga/show.blade.php -->
@extends('layouts.admin')

@section('title', 'Detail Warga')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-user"></i> Detail Warga
    </h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Lengkap Warga</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">NIK</th>
                            <td>{{ $warga->nik }}</td>
                        </tr>
                        <tr>
                            <th>Nama Lengkap</th>
                            <td>{{ $warga->nama }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Lahir</th>
                            <td>{{ $warga->tgl_lahir->format('d/m/Y') }} ({{ $warga->tgl_lahir->age }} tahun)</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
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
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Alamat</th>
                            <td>{{ $warga->alamat }}</td>
                        </tr>
                        <tr>
                            <th>RT</th>
                            <td>
                                @if($warga->rt)
                                    <span class="badge badge-info">RT {{ $warga->rt->nomor_rt }}</span>
                                @else
                                    <span class="badge badge-warning">Belum Ditentukan</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>RW</th>
                            <td>
                                @if($warga->rw)
                                    <span class="badge badge-secondary">RW {{ $warga->rw->nomor_rw }}</span>
                                @else
                                    <span class="badge badge-warning">Belum Ditentukan</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
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
                        </tr>
                    </table>
                </div>
            </div>

            @if($warga->anggotaLembaga->count() > 0)
            <div class="row mt-4">
                <div class="col-12">
                    <h5 class="font-weight-bold">Keanggotaan Lembaga Desa</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Lembaga</th>
                                    <th>Jabatan</th>
                                    <th>Level</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($warga->anggotaLembaga as $anggota)
                                <tr>
                                    <td>{{ $anggota->lembaga->nama_lembaga }}</td>
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
            @endif

            <div class="row mt-4">
                <div class="col-12 text-right">
                    <a href="{{ route('admin.warga.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection