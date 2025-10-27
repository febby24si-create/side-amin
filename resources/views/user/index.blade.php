@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-users-cog"></i> Manajemen User
    </h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar User Sistem</h6>
                </div>
                <div class="col-md-6 text-right">
                    <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah User
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Form Pencarian -->
            <form action="{{ route('user.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Cari berdasarkan username atau nama lengkap..."
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
                            <th>Username</th>
                            <th>Nama Lengkap</th>
                            <th>Role</th>
                            <th>Tanggal Dibuat</th>
                            <th>Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <strong>{{ $user->username }}</strong>
                            </td>
                            <td>{{ $user->nama_lengkap }}</td>
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
                            <td>
                                <span class="badge badge-light">
                                    {{ $user->created_at->format('d/m/Y') }}
                                </span>
                            </td>
                            <td>
                                @if($user->id === auth()->id())
                                    <span class="badge badge-primary">
                                        <i class="fas fa-user"></i> Anda
                                    </span>
                                @else
                                    <span class="badge badge-secondary">Aktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.user.show', $user->id) }}"
                                       class="btn btn-info btn-sm" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.user.edit', $user->id) }}"
                                       class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.user.destroy', $user->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Apakah Anda yakin menghapus user ini?')"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @else
                                    <button class="btn btn-danger btn-sm" disabled title="Tidak dapat menghapus akun sendiri">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    Menampilkan {{ $users->firstItem() }} sampai {{ $users->lastItem() }} dari {{ $users->total() }} user
                </div>
                {{ $users->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
