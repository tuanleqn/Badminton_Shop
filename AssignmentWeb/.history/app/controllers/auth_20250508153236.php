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
                $this->session->setFlash('error', "Invalid email or password");
                header('Location: ' . URL::to('public/auth/login'));
                exit();
            }
        }
        $this->view("auth/login");
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
                $this->session->setFlash('message', "Registration successful. Please login.");
                header("Location: login");
                exit();
            } else {
                $this->session->setFlash('error', $result['error']);
                header('Location: ' . URL::to('public/auth/register'));
                exit();
            }
        }
        $this->view("auth/register");
    }

    public function logout() {
        $this->session->destroy();
        header("Location: /Shop-badminton/AssignmentWeb/public/home/index");
        exit();
    }

    public function changePasswordAction() {
        if (!$this->session->get('user')) {
            header('Location: ' . URL::to('public/auth/login'));
            exit;
        }
        $this->view('auth/change_password');
    }

    public function updatePasswordAction() {
        if (!$this->session->get('user')) {
            header('Location: ' . URL::to('public/auth/login'));
            exit;
        }

        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
            $this->session->setFlash('error', 'Vui lòng điền đầy đủ thông tin');
            header('Location: ' . URL::to('public/auth/changePasswordAction'));
            exit;
        }

        if ($new_password !== $confirm_password) {
            $this->session->setFlash('error', 'Mật khẩu mới không khớp');
            header('Location: ' . URL::to('public/auth/changePasswordAction'));
            exit;
        }

        $user = $this->session->get('user');
        $userModel = new UserAuth();

        if (!$userModel->verifyPassword($user['email'], $current_password)) {
            $this->session->setFlash('error', 'Mật khẩu hiện tại không đúng');
            header('Location: ' . URL::to('public/auth/changePasswordAction'));
            exit;
        }

        if ($userModel->updatePassword($user['email'], $new_password)) {
            $this->session->setFlash('success', 'Đổi mật khẩu thành công');
            header('Location: ' . URL::to('public/auth/changePasswordAction'));
        } else {
            $this->session->setFlash('error', 'Có lỗi xảy ra, vui lòng thử lại sau');
            header('Location: ' . URL::to('public/auth/changePasswordAction'));
        }
        exit;
    }
    public function checkUser() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
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
    }
    public function handleRequest() {
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
    }
}

