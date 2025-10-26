<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registrasi - SIPEDES</title>
    
    <!-- Bootstrap Core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- SB Admin 2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.4/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-6 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">
                                    <i class="fas fa-home text-primary"></i> SIPEDES
                                </h1>
                                <p class="text-muted mb-4">Buat Akun Baru - Sistem Informasi Pemerintahan Desa</p>
                            </div>
                            
                            @include('partials.alert')

                            <form class="user" method="POST" action="{{ route('register') }}">
                                @csrf
                                
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}"
                                        placeholder="Nama Lengkap" required autofocus>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}"
                                        placeholder="Alamat Email" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror"
                                            name="password" placeholder="Password" required>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user"
                                            name="password_confirmation" placeholder="Ulangi Password" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Role</label>
                                    <div class="row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="role" id="roleAdmin" value="admin" {{ old('role') == 'admin' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="roleAdmin">
                                                    <i class="fas fa-crown text-success"></i> Administrator
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="role" id="roleOperator" value="operator" {{ old('role') == 'operator' ? 'checked' : '' }} checked>
                                                <label class="form-check-label" for="roleOperator">
                                                    <i class="fas fa-user text-info"></i> Operator
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @error('role')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <strong>Administrator:</strong> Akses penuh sistem<br>
                                        <strong>Operator:</strong> Akses input data terbatas
                                    </small>
                                </div>

                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    <i class="fas fa-user-plus"></i> Daftar Akun
                                </button>
                            </form>
                            
                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt"></i> Sudah punya akun? Login!
                                </a>
                            </div>

                            <div class="text-center mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle"></i> 
                                    Pastikan data yang dimasukkan valid. Email akan digunakan untuk login.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.4/js/sb-admin-2.min.js"></script>

    <script>
    // Password strength indicator
    document.querySelector('input[name="password"]').addEventListener('input', function(e) {
        const password = e.target.value;
        const strengthBadge = document.getElementById('password-strength');
        
        if (!strengthBadge) {
            const badge = document.createElement('small');
            badge.id = 'password-strength';
            badge.className = 'form-text';
            e.target.parentNode.appendChild(badge);
        }
        
        const strength = checkPasswordStrength(password);
        const badge = document.getElementById('password-strength');
        
        if (password.length === 0) {
            badge.style.display = 'none';
            return;
        }
        
        badge.style.display = 'block';
        badge.innerHTML = `Kekuatan password: <span class="badge badge-${strength.color}">${strength.text}</span>`;
    });

    function checkPasswordStrength(password) {
        let strength = 0;
        
        if (password.length >= 6) strength++;
        if (password.match(/[a-z]+/)) strength++;
        if (password.match(/[A-Z]+/)) strength++;
        if (password.match(/[0-9]+/)) strength++;
        if (password.match(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/)) strength++;
        
        if (strength <= 2) return { text: 'Lemah', color: 'danger' };
        if (strength <= 4) return { text: 'Sedang', color: 'warning' };
        return { text: 'Kuat', color: 'success' };
    }

    // Confirm password match
    document.querySelector('input[name="password_confirmation"]').addEventListener('input', function(e) {
        const password = document.querySelector('input[name="password"]').value;
        const confirmPassword = e.target.value;
        
        if (confirmPassword.length > 0 && password !== confirmPassword) {
            e.target.classList.add('is-invalid');
        } else {
            e.target.classList.remove('is-invalid');
        }
    });
    </script>
</body>
</html>