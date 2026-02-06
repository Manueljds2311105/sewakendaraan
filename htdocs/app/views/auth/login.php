<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <h2><i class="fas fa-car"></i> Rental Kendaraan</h2>
                <p>Sistem Manajemen Sewa Kendaraan</p>
            </div>
            
            <div class="login-body">
                <?php
                $flash = $this->getFlash();
                if($flash):
                ?>
                <div class="alert alert-<?= $flash['type'] ?>">
                    <i class="fas fa-<?= $flash['type'] == 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
                    <?= $flash['message'] ?>
                </div>
                <?php endif; ?>
                
                <form action="<?= BASE_URL ?>auth/login" method="POST">
                    <div class="form-group">
                        <label for="username" class="form-label">
                            <i class="fas fa-user"></i> Username
                        </label>
                        <input type="text" 
                               id="username" 
                               name="username" 
                               class="form-control" 
                               placeholder="Masukkan username" 
                               required 
                               autofocus>
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock"></i> Password
                        </label>
                        <div style="position: relative;">
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   class="form-control" 
                                   placeholder="Masukkan password" 
                                   style="padding-right: 45px;"
                                   required>
                            <button type="button" 
                                    id="togglePassword" 
                                    style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #6b7280; font-size: 18px; padding: 5px 10px;"
                                    onclick="togglePasswordVisibility()">
                                <i class="fas fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </form>
                
                <div style="margin-top: 25px; text-align: center; padding-top: 20px; border-top: 1px solid #e5e7eb;">
                    <div style="font-size: 12px; color: #9ca3af;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }
    </script>
</body>
</html>