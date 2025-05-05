<?php
class Auth extends Controller {
    private $userAuth;
    private $session;

    public function __construct() {
        $this->userAuth = $this->model("UserAuth");
        $this->session = Session::getInstance();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $user = $this->userAuth->login($email, $password);
            
            if ($user) {
                $this->session->set('login', true);
                $this->session->set('user', $user);
                
                if ($user['role'] === 'admin') {
                    header("Location: ../admin/index");
                } else {
                    header("Location: ../home/index");
                }
                exit();
            } else {
                $data['error'] = "Invalid email or password";
                $this->view("auth/login", $data);
            }
        } else {
            $this->view("auth/login");
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userData = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'phone' => $_POST['phone'],
                'address' => $_POST['address'],
                'sex' => $_POST['sex']
            ];
            
            $result = $this->userAuth->register($userData);
            
            if (isset($result['success'])) {
                header("Location: login");
                exit();
            } else {
                $data['error'] = $result['error'];
                $this->view("auth/register", $data);
            }
        } else {
            $this->view("auth/register");
        }
    }

    public function logout() {
        $this->session->destroy();
        header("Location: /Shop-badminton/AssignmentWeb/public/home/index");
        exit();
    }
}