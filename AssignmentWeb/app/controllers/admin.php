<?php
class Admin extends Controller
{
    private $session;

    public function __construct()
    {
        $this->session = Session::getInstance();
        // Check if user is logged in and is an admin
        $userData = $this->session->get('user');
        if (!$userData || $userData['role'] !== 'admin') {
            header('Location: ' . URL::to('public/auth/login'));
            exit();
        }
    }

    public function index()
    {
        $this->session->checkSession();
        $userData = $this->session->get('user');
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

    public function formValidation()
    {
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
                $this->session->set('message', 'Information updated successfully');
            } else {
                $this->session->set('error', 'Failed to update information');
            }

            header('Location: ' . URL::to('public/admin/formValidation'));
            exit();
        }

        // Get current formal info for displaying in the form
        $formalInfoList = $formalInfo->getAllFormalInfo();
        $this->view('admin/form-validation-parsley', ['formalInfo' => $formalInfoList]);
    }

    public function profile()
    {
        $this->session->checkSession();
        $userData = $this->session->get('user');
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
                    $this->session->set('user', $userData);
                    $this->session->set('message', 'Profile updated successfully');
                    header('Location: ' . URL::to('public/admin/profile'));
                    exit();
                } else {
                    $this->session->set('error', 'Failed to update profile');
                }
            } else {
                $this->session->set('error', implode(', ', $errors));
            }
        }

        $this->view("admin/account-profile", ['user' => $userData]);
    }

    public function response($id = null)
    {
        $response = $this->model('Response');

        // Handle GET request for specific response
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && $id !== null) {
            $responseData = $response->getResponseById($id);
            header('Content-Type: application/json');
            if ($responseData) {
                echo json_encode(['success' => true, 'response' => $responseData]);
            } else {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Response not found']);
            }
            exit();
        }

        // Handle POST request for status update
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get JSON data
            $jsonData = json_decode(file_get_contents('php://input'), true);
            $id = isset($jsonData['id']) ? (int) $jsonData['id'] : 0;
            $status = isset($jsonData['status']) ? $jsonData['status'] : '';

            if (!$id || !$status) {
                header('Content-Type: application/json');
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Invalid input']);
                exit();
            }

            // Update the status
            $success = $response->updateStatus($id, $status);

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

        // Default: show all responses
        $responseData = $response->getAllResponses();
        $this->view('admin/view-response', ['responses' => $responseData]);
    }

    public function sendMail()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Content-Type: application/json');
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            exit();
        }

        // Get JSON data
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['to']) || !isset($data['subject']) || !isset($data['message'])) {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Missing required fields']);
            exit();
        }

        $to = $data['to'];
        $subject = $data['subject'];
        $message = $data['message'];

        // Headers
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $headers .= 'From: ' . $this->session->get('user')['email'] . "\r\n";

        $mailSent = mail($to, $subject, $message, $headers);

        header('Content-Type: application/json');
        if ($mailSent) {
            // Update response status if mail sent successfully
            if (isset($data['responseId'])) {
                $response = $this->model('Response');
                $response->updateStatus($data['responseId'], 'responsed');
            }
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to send email']);
        }
        exit();
    }

    public function viewBranch()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            // Prevent any output before our JSON response
            ob_clean();
            header('Content-Type: application/json');

            try {
                // Get DELETE data
                $input = file_get_contents('php://input');
                if ($input === false) {
                    throw new Exception('Failed to read request data');
                }

                $data = json_decode($input, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new Exception('Invalid JSON input: ' . json_last_error_msg());
                }

                $branchId = isset($data['id']) ? (int) $data['id'] : 0;
                if (!$branchId) {
                    throw new Exception('Invalid branch ID');
                }

                $getBranch = $this->model('Branch');
                if ($getBranch->deleteBranch($branchId)) {
                    echo json_encode(['success' => true]);
                }
            } catch (Exception $e) {
                error_log('Error deleting branch: ' . $e->getMessage());
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Error deleting branch: ' . $e->getMessage()
                ]);
            }
            exit();
        }

        // Handle GET request
        $getBranch = $this->model('Branch');
        $branchData = $getBranch->getAllBranches();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action']) && $_POST['action'] === 'add') {
                $branchName = $_POST['branchName'];
                $branchAddress = $_POST['branchAddress'];

                if ($getBranch->addBranch($branchName, $branchAddress)) {
                    $this->session->set('message', 'Branch added successfully');
                } else {
                    $this->session->set('error', 'Failed to add branch');
                }
                header('Location: ' . URL::to('public/admin/viewBranch'));
                exit;
            }

            $branchName = $_POST['branchName'];
            $branchAddress = $_POST['branchAddress'];
            $branchId = $_POST['branchid'];

            if ($getBranch->updateBranch($branchId, $branchName, $branchAddress)) {
                $this->session->set('message', 'Branch updated successfully');
            } else {
                $this->session->set('error', 'Failed to update branch');
            }
            header('Location: ' . URL::to('public/admin/viewBranch'));
            exit();
        }

        $this->view('admin/view-branch', ['branches' => $branchData]);
    }

    public function productlist()
    {
        $this->view('admin/product/list');
    }
    public function productadd()
    {
        $this->view('admin/product/add');
    }
    public function productedit()
    {
        $this->view('admin/product/edit');
    }
    public function productdelete()
    {
        $this->view('admin/product/delete');
    }
    public function reviews()
    {
        $this->view('admin/product/manage_reviews');
    }

    public function introduce()
    {
        $introduceModel = $this->model('IntroduceIntro');

        // Xử lý DELETE request (AJAX)
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            ob_clean();
            header('Content-Type: application/json');
            try {
                $input = file_get_contents('php://input');
                if ($input === false) {
                    throw new Exception('Failed to read request data');
                }
                $data = json_decode($input, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new Exception('Invalid JSON input: ' . json_last_error_msg());
                }
                $id = isset($data['id']) ? (int) $data['id'] : 0;
                if (!$id) {
                    throw new Exception('Invalid introduce ID');
                }
                if ($introduceModel->deleteIntroduce($id)) {
                    echo json_encode(['success' => true]);
                } else {
                    throw new Exception('Delete operation failed');
                }
            } catch (Exception $e) {
                error_log('Error deleting introduce: ' . $e->getMessage());
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Error deleting introduce: ' . $e->getMessage()
                ]);
            }
            exit();
        }

        // Xử lý POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Nếu là thêm mới
            if (isset($_POST['action']) && $_POST['action'] === 'add') {
                $section = trim($_POST['section']);
                $content = trim($_POST['content']);
                $note = trim($_POST['note']);

                $data = ['section' => $section, 'content' => $content, 'note' => $note];
                if ($introduceModel->createIntroduce($data)) {
                    $this->session->set('message', 'Introduce added successfully');
                } else {
                    $this->session->set('error', 'Failed to add introduce');
                }
                header('Location: ' . URL::to('public/admin/introduce'));
                exit();
            }

            // Nếu là cập nhật
            $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
            $section = trim($_POST['section']);
            $content = trim($_POST['content']);
            $note = trim($_POST['note']);

            if ($id > 0) {
                $data = ['section' => $section, 'content' => $content, 'note' => $note];
                if ($introduceModel->updateIntroduce($id, $data)) {
                    $this->session->set('message', 'Introduce updated successfully');
                } else {
                    $this->session->set('error', 'Failed to update introduce');
                }
            } else {
                $this->session->set('error', 'Invalid introduce ID for update');
            }
            header('Location: ' . URL::to('public/admin/introduce'));
            exit();
        }

        // Default: GET request, hiển thị danh sách
        $allIntroduce = $introduceModel->getAllValues();
        $this->view('admin/introduce', [
            'introduces' => $allIntroduce
        ]);
    }

    public function qaa()
    {
        $qaaModel = $this->model('Qaam');

        // Xử lý DELETE AJAX
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            ob_clean();
            header('Content-Type: application/json');
            try {
                $input = file_get_contents('php://input');
                $data = json_decode($input, true);
                $id = isset($data['id']) ? (int) $data['id'] : 0;
                if (!$id)
                    throw new Exception('Invalid Q&A ID');
                if ($qaaModel->deleteQaa($id)) {
                    echo json_encode(['success' => true]);
                } else {
                    throw new Exception('Delete operation failed');
                }
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
            exit();
        }

        // Xử lý POST (add/update)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
            $data = [
                'category' => trim($_POST['category']),
                'question' => trim($_POST['question']),
                'answer' => trim($_POST['answer']),
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'displayOrder' => isset($_POST['displayOrder']) ? (int) $_POST['displayOrder'] : 1
            ];

            if (isset($_POST['action']) && $_POST['action'] === 'add') {
                if ($qaaModel->createQaa($data)) {
                    $this->session->set('message', 'Q&A added successfully');
                } else {
                    $this->session->set('error', 'Failed to add Q&A');
                }
            } else {
                if ($id && $qaaModel->updateQaa($id, $data)) {
                    $this->session->set('message', 'Q&A updated successfully');
                } else {
                    $this->session->set('error', 'Failed to update Q&A');
                }
            }

            header('Location: ' . URL::to('public/admin/qaa'));
            exit();
        }

        // GET: hiển thị danh sách Q&A
        $allQaa = $qaaModel->getAllQaa();
        $this->view('admin/qaa', ['qaas' => $allQaa]);
    }
}
