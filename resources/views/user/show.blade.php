<!-- resources/views/user/show.blade.php -->
@extends('layouts.admin')

@section('title', 'Detail User')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-user"></i> Detail User
    </h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Lengkap User</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Username</th>
                            <td>{{ $user->username }}</td>
                        </tr>
                        <tr>
                            <th>Nama Lengkap</th>
                            <td>{{ $user->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td>
                                @if($user->role == 'admin')
                                    <span class="badge badge-success">
                                        <i class="fas fa-crown"></i> Administrator
                                    </span>
                                @else
                                    <span class="badge badge-info">
                                        <i class="fas fa-user"></i> Operator
                                    </span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Status</th>
                            <td>
                                @if($user->id === auth()->id())
                                    <span class="badge badge-primary">
                                        <i class="fas fa-user"></i> Akun Anda
                                    </span>
                                @else
                                    <span class="badge badge-success">Aktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Dibuat</th>
                            <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Diupdate</th>
                            <td>{{ $user->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Informasi Keamanan:</strong> 
                        @if($user->id === auth()->id())
                            Ini adalah akun Anda sendiri. Pastikan untuk menjaga kerahasiaan password.
                        @else
                            Anda sedang melihat data user lain. Hati-hati dalam melakukan perubahan.
                        @endif
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 text-right">
                    <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit User
                    </a>
                    <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection