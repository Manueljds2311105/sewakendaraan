<?php
class HomeController extends Controller {
    
    public function index() {
        // Redirect ke login jika belum login
        if(!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
        } else {
            $this->redirect('dashboard');
        }
    }
}
?>