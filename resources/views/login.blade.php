<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-green: #2ecc71;
            --dark-green: #27ae60;
            --light-bg: #f8f9fa;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--light-bg) 0%, #e8f5e9 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(46, 204, 113, 0.15);
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            border: none;
            transition: transform 0.3s ease;
        }
        
        .login-card:hover {
            transform: translateY(-5px);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-header h1 {
            color: var(--dark-green);
            font-weight: 600;
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }
        
        .login-header p {
            color: #6c757d;
            font-size: 0.95rem;
        }
        
        .form-label {
            font-weight: 500;
            color: #343a40;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background-color: #fafafa;
        }
        
        .form-control:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 4px rgba(46, 204, 113, 0.15);
            background-color: white;
        }
        
        .form-control::placeholder {
            color: #adb5bd;
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
            border: none;
            border-radius: 12px;
            padding: 0.85rem;
            font-weight: 500;
            font-size: 1rem;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(46, 204, 113, 0.4);
            background: linear-gradient(135deg, var(--dark-green), #219653);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .alert-danger {
            border-radius: 12px;
            border: none;
            background-color: #ffebee;
            color: #c62828;
            font-size: 0.9rem;
            padding: 0.75rem 1rem;
        }
        
        .alert-danger ul {
            margin: 0;
            padding-left: 1.2rem;
        }
        
        /* Decorative element */
        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-green), var(--dark-green));
            border-radius: 2px;
        }
        
        .login-card {
            position: relative;
        }
        
        /* Input icon styling (optional enhancement) */
        .input-group-custom {
            position: relative;
        }
        
        @media (max-width: 480px) {
            .login-card {
                padding: 2rem 1.5rem;
            }
            
            .login-header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <h1>Welcome</h1>
            <p>Silahkan login untuk melanjutkan</p>
        </div>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label for="nim_nuptk" class="form-label">NIM / NUPTK</label>
                <input type="text" 
                       id="nim_nuptk" 
                       value="{{ old('nim_nuptk') }}" 
                       name="nim_nuptk" 
                       class="form-control" 
                       placeholder="Masukkan NIM atau NUPTK Anda"
                       required>
            </div>
            
            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       class="form-control" 
                       placeholder="••••••••"
                       required>
            </div>
            
            <div class="mb-4">
                <button name="submit" type="submit" class="btn btn-login">
                    Login Sekarang
                </button>
            </div>
        </form>
        

        <div class="text-center mt-3">
            <small class="text-muted">
                Belum punya akun? <a href="{{ route('register') }}" style="color: var(--primary-green); text-decoration: none; font-weight: 500;">Daftar disini</a>
            </small>
        </div>
    </div>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>