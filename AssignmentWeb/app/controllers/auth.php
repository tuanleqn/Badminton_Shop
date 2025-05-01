<?php
class Auth extends Controller {
    private $userAuth;

    public function __construct() {
        $this->userAuth = $this->model("UserAuth");
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $user = $this->userAuth->login($email, $password);
            
            if ($user) {
                Session::set('login', true);
                Session::set('user', $user);
                
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

    // public function index() {
    //     // Redirect to home if someone tries to access auth directly
    //     header("Location: ../home/index");
    //     exit();
    // }

    public function logout() {
        Session::destroy();
        header("Location: /Shop-badminton/AssignmentWeb/public/home/index");
        exit();
    }
}