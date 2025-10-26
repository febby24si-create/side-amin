@extends('layouts.admin')

@section('title', 'Tambah User')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-user-plus"></i> Tambah User Baru
    </h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            @include('partials.alert')
            
            <form action="{{ route('admin.user.store') }}" method="POST">
                @csrf
                
                @include('partials.form', ['fields' => [
                    [
                        'name' => 'name',
                        'label' => 'Nama Lengkap',
                        'type' => 'text',
                        'placeholder' => 'Masukkan nama lengkap',
                        'required' => true
                    ],
                    [
                        'name' => 'email',
                        'label' => 'Email',
                        'type' => 'email',
                        'placeholder' => 'Masukkan alamat email',
                        'required' => true,
                        'help' => 'Email akan digunakan untuk login ke sistem'
                    ],
                    [
                        'name' => 'password',
                        'label' => 'Password',
                        'type' => 'password',
                        'placeholder' => 'Masukkan password',
                        'required' => true
                    ],
                    [
                        'name' => 'password_confirmation',
                        'label' => 'Konfirmasi Password',
                        'type' => 'password',
                        'placeholder' => 'Ulangi password',
                        'required' => true
                    ],
                    [
                        'name' => 'role',
                        'label' => 'Role',
                        'type' => 'select',
                        'options' => [
                            'admin' => 'Administrator',
                            'operator' => 'Operator'
                        ],
                        'required' => true,
                        'help' => '<strong>Administrator:</strong> Akses penuh ke semua fitur sistem<br><strong>Operator:</strong> Akses terbatas untuk input data'
                    ]
                ]])

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan User
                    </button>
                    <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection