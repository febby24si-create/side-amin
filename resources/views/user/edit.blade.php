@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-edit"></i> Edit User
    </h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            @include('partials.alert')
            
            <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                @include('partials.form', ['fields' => [
                    [
                        'name' => 'name',
                        'label' => 'Nama Lengkap',
                        'type' => 'text',
                        'value' => $user->name,
                        'required' => true
                    ],
                    [
                        'name' => 'email',
                        'label' => 'Email',
                        'type' => 'email',
                        'value' => $user->email,
                        'required' => true
                    ],
                    [
                        'name' => 'password',
                        'label' => 'Password',
                        'type' => 'password',
                        'placeholder' => 'Kosongkan jika tidak ingin mengubah password',
                        'help' => 'Minimal 6 karakter'
                    ],
                    [
                        'name' => 'password_confirmation',
                        'label' => 'Konfirmasi Password',
                        'type' => 'password',
                        'placeholder' => 'Ulangi password'
                    ],
                    [
                        'name' => 'role',
                        'label' => 'Role',
                        'type' => 'select',
                        'value' => $user->role,
                        'options' => [
                            'admin' => 'Administrator',
                            'operator' => 'Operator'
                        ],
                        'required' => true
                    ]
                ]])

                <!-- Info Data Saat Ini -->
                <div class="alert alert-info mt-4">
                    <h6><i class="fas fa-info-circle"></i> Informasi Data Saat Ini</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <small><strong>Email:</strong> {{ $user->email }}</small><br>
                            <small><strong>Nama:</strong> {{ $user->name }}</small>
                        </div>
                        <div class="col-md-6">
                            <small><strong>Dibuat:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</small><br>
                            <small><strong>Diupdate:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}</small>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.user.show', $user->id) }}" class="btn btn-info">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                    <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

//