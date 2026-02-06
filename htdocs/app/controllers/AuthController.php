<?php
class AuthController extends Controller {
    
    public function login() {
        // Jika sudah login, redirect ke dashboard
        if(isset($_SESSION['user_id'])) {
            $this->redirect('dashboard');
        }
        
        // Handle form submission
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            
            // Validation
            if(empty($username) || empty($password)) {
                $this->setFlash('danger', 'Username dan password harus diisi!');
                $this->redirect('auth/login');
            }
            
            // Check credentials
            $userModel = $this->model('User');
            $user = $userModel->login($username, $password);
            
            if($user) {
                // Set session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                $_SESSION['role'] = $user['role'];
                
                $this->setFlash('success', 'Selamat datang, ' . $user['nama_lengkap'] . '!');
                $this->redirect('dashboard');
            } else {
                $this->setFlash('danger', 'Username atau password salah!');
                $this->redirect('auth/login');
            }
        }
        
        // Show login page
        $this->view('auth/login');
    }
    
    public function logout() {
        session_destroy();
        $this->redirect('auth/login');
    }
}
?>