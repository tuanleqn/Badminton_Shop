<?php
class Admin extends Controller {
    public function __construct() {
        Session::init();
        // Check if user is logged in and is an admin
        $userData = Session::get('user');
        if (!$userData || $userData['role'] !== 'admin') {
            header('Location: ' . URL::to('public/auth/login'));
            exit();
        }
    }

    public function index() {
        Session::checkSession();
        $userData = Session::get('user');
        $user = $this->model('User');
        $customer = $user->getAllCustomer();
        $response = $this->model('Response');
        $responseData = $response->getNumberOfNewest(2);
        $data = [
            'user' => $userData,
            'customer' => $customer,
            'response' => $responseData
        ];
        
        $this->view('admin/index', $data);
    }
    
    public function formValidation() {
        $formalInfo = $this->model('FormalInfo');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [];
            $currentInfo = $formalInfo->getAllFormalInfo();
            
            // Build data array from POST data
            foreach ($currentInfo as $info) {
                $fieldName = str_replace(' ', '_', strtolower($info['name'])) . '-column';
                if (isset($_POST[$fieldName])) {
                    $data[] = [
                        'name' => $info['name'],
                        'description' => $_POST[$fieldName]
                    ];
                }
            }
            
            if ($formalInfo->modifyFormalInfo($data)) {
                Session::set('message', 'Information updated successfully');
            } else {
                Session::set('error', 'Failed to update information');
            }
            
            header('Location: ' . URL::to('public/admin/formValidation'));
            exit();
        }
        
        // Get current formal info for displaying in the form
        $formalInfoList = $formalInfo->getAllFormalInfo();
        $this->view('admin/form-validation-parsley', ['formalInfo' => $formalInfoList]);
    }
    public function profile() {
        Session::checkSession();
        $userData = Session::get('user');
        $user = $this->model('User');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate required fields
            $requiredFields = ['name', 'email', 'phone', 'address'];
            $errors = [];
            
            foreach ($requiredFields as $field) {
                if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
                    $errors[] = ucfirst($field) . ' is required';
                }
            }
            
            // Validate email format
            if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Invalid email format';
            }
            
            if (empty($errors)) {
                $updateData = [
                    'name' => trim($_POST['name']),
                    'email' => trim($_POST['email']),
                    'phone' => trim($_POST['phone']),
                    'address' => trim($_POST['address'])
                ];
                
                if ($user->updateUser($userData['id'], $updateData)) {
                    // Update session data only after successful database update
                    $userData = array_merge($userData, $updateData);
                    Session::set('user', $userData);
                    Session::set('message', 'Profile updated successfully');
                    header('Location: ' . URL::to('public/admin/profile'));
                    exit();
                } else {
                    Session::set('error', 'Failed to update profile');
                }
            } else {
                Session::set('error', implode(', ', $errors));
            }
        }
        
        $this->view("admin/account-profile", ['user' => $userData]);
    }
    public function response() {
        $response = $this->model('Response');
        $responseData = $response->getAllResponses();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
            $status = isset($_POST['status']) ? $_POST['status'] : '';
    
            if (!$id || !$status) {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Invalid input']);
                exit();
            }
    
            // Update the status
            $responseModel = $this->model('Response');
            $success = $responseModel->updateStatus($id, $status);
    
            // Send response
            header('Content-Type: application/json');
            if ($success) {
                echo json_encode(['success' => true]);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Failed to update status']);
            }
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            header('Content-Type: application/json');
            // Read raw input for DELETE requests
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);
            
            if (!isset($data['id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Response ID is required']);
                exit();
            }

            try {
                $deleted = $response->deleteResponse($data['id']);
                if ($deleted) {
                    echo json_encode(['success' => true]);
                } else {
                    http_response_code(500);
                    echo json_encode(['success' => false, 'message' => 'Failed to delete response']);
                }
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'An error occurred']);
            }
            exit();
        }

        // Load the view with the response data
        $this->view('admin/view-response', ['responses' => $responseData]);
    }
}
