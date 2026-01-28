<?php
class Controller {
    
    public function view($view, $data = []) {
        extract($data);
        require_once 'app/views/' . $view . '.php';
    }
    
    public function model($model) {
        require_once 'app/models/' . $model . '.php';
        return new $model();
    }
    
    public function redirect($url) {
        header('Location: ' . BASE_URL . $url);
        exit;
    }
    
    public function checkAuth() {
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
        }
    }
    
    public function checkAdmin() {
        $this->checkAuth();
        if($_SESSION['role'] != 'admin') {
            $_SESSION['error'] = 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini.';
            $this->redirect('dashboard');
        }
    }
    
    public function setFlash($type, $message) {
        $_SESSION['flash_type'] = $type;
        $_SESSION['flash_message'] = $message;
    }
    
    public function getFlash() {
        if(isset($_SESSION['flash_message'])) {
            $flash = [
                'type' => $_SESSION['flash_type'],
                'message' => $_SESSION['flash_message']
            ];
            unset($_SESSION['flash_type']);
            unset($_SESSION['flash_message']);
            return $flash;
        }
        return null;
    }
}
?>