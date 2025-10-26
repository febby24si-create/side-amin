<!-- resources/views/warga/edit.blade.php -->
@extends('layouts.admin')

@section('title', 'Edit Warga')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-edit"></i> Edit Data Warga
    </h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.warga.update', $warga->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nik">NIK <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nik') is-invalid @enderror" 
                                   id="nik" name="nik" value="{{ old('nik', $warga->nik) }}" required
                                   maxlength="16" pattern="[0-9]{16}" title="NIK harus 16 digit angka">
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                   id="nama" name="nama" value="{{ old('nama', $warga->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tgl_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tgl_lahir') is-invalid @enderror" 
                                   id="tgl_lahir" name="tgl_lahir" 
                                   value="{{ old('tgl_lahir', $warga->tgl_lahir->format('Y-m-d')) }}" required>
                            @error('tgl_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select class="form-control @error('jenis_kelamin') is-invalid @enderror" 
                                    id="jenis_kelamin" name="jenis_kelamin" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" 
                                    {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>
                                <option value="Perempuan"
                                    {{ old('jenis_kelamin', $warga->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan
                                </option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat Lengkap <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('alamat') is-invalid @enderror" 
                              id="alamat" name="alamat" rows="3" required>{{ old('alamat', $warga->alamat) }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="rw_id">RW</label>
                            <select class="form-control @error('rw_id') is-invalid @enderror" 
                                    id="rw_id" name="rw_id">
                                <option value="">Pilih RW</option>
                                @foreach($rws as $rw)
                                    <option value="{{ $rw->id }}" 
                                        {{ old('rw_id', $warga->rw_id) == $rw->id ? 'selected' : '' }}>
                                        RW {{ $rw->nomor_rw }}
                                    </option>
                                @endforeach
                            </select>
                            @error('rw_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="rt_id">RT</label>
                            <select class="form-control @error('rt_id') is-invalid @enderror" 
                                    id="rt_id" name="rt_id">
                                <option value="">Pilih RT</option>
                                @foreach($rts as $rt)
                                    <option value="{{ $rt->id }}"
                                        {{ old('rt_id', $warga->rt_id) == $rt->id ? 'selected' : '' }}>
                                        RT {{ $rt->nomor_rt }} (RW {{ $rt->rw->nomor_rw }})
                                    </option>
                                @endforeach
                            </select>
                            @error('rt_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Info Data Saat Ini -->
                <div class="alert alert-info mt-4">
                    <h6><i class="fas fa-info-circle"></i> Informasi Data Saat Ini</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <small><strong>NIK:</strong> {{ $warga->nik }}</small><br>
                            <small><strong>Nama:</strong> {{ $warga->nama }}</small>
                        </div>
                        <div class="col-md-6">
                            <small><strong>Dibuat:</strong> {{ $warga->created_at->format('d/m/Y H:i') }}</small><br>
                            <small><strong>Diupdate:</strong> {{ $warga->updated_at->format('d/m/Y H:i') }}</small>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.warga.show', $warga->id) }}" class="btn btn-info">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                    <a href="{{ route('admin.warga.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Format NIK input
document.getElementById('nik').addEventListener('input', function(e) {
    this.value = this.value.replace(/\D/g, '').substring(0, 16);
});

// Date validation - prevent future dates
document.getElementById('tgl_lahir').max = new Date().toISOString().split('T')[0];
</script>

<style>
.form-group.required label:after {
    content: " *";
    color: red;
}
</style>
@endsection