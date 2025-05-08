<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../helper/session.php';

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
    public function checkLogin() {
        header('Content-Type: application/json');
        if ($this->session->get('login')) {
            echo json_encode(['loggedIn' => true]);
        } else {
            echo json_encode(['loggedIn' => false]);
        }
        exit();
    }

    public function checkUser() {
        header('Content-Type: application/json');
        $user = $this->session->get('user');
        if ($user) {
            $email = $user['email'];
            $phone = $user['phone'];
            error_log("Checking user: Email = $email, Phone = $phone");
            $exists = $this->userAuth->checkUserExists($email, $phone);
            echo json_encode(['exists' => $exists]);
        } else {
            error_log("No user found in session.");
            echo json_encode(['exists' => false]);
        }
        exit();
    }
    public function logout() {
        $this->session->destroy();
        header("Location: /Shop-badminton/AssignmentWeb/public/home/index");
        exit();
    }

    
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $auth = new Auth();
    if ($action === 'checkUser') {
        $auth->checkUser();
    } else {
        echo json_encode(['error' => 'Invalid action']);
    }
    exit();
}

if (isset($_SERVER['REQUEST_URI'])) {
    $auth = new Auth();
    if (strpos($_SERVER['REQUEST_URI'], '/auth/register') !== false) {
        $auth->register();
        exit();
    } elseif (strpos($_SERVER['REQUEST_URI'], '/auth/login') !== false) {
        $auth->login();
        exit();
    }
}

http_response_code(404);
echo "Page not found.";