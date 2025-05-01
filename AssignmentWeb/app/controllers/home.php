<?php
class Home extends Controller
{
    public function __construct()
    {
        Session::init();
    }

    public function index()
    {
        // Get user info from session if logged in
        $userData = Session::get('user');
        if ($userData === false) {
            $userData = null;
        }
        
        // Load formal info for the header
        $formalInfo = $this->model('FormalInfo');
        $formalInfoList = $formalInfo->getAllFormalInfo();
        
        // If user is admin, redirect to admin panel using proper routing
        if ($userData && $userData['role'] === 'admin') {
            header('Location: ' . URL::to('public/admin/index'));
            exit();
        }

        $data = [
            'user' => $userData,
            'formalInfo' => $formalInfoList
        ];

        $this->view('home/index', $data);
    }

    public function contract()
    {
        $userData = Session::get('user');
        if ($userData === false) {
            $userData = null;
        }
        
        $formalInfo = $this->model('FormalInfo');
        $formalInfoList = $formalInfo->getAllFormalInfo();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $responseModel = $this->model('Response');
            
            $data = [
                'firstName' => $_POST['firstName'],
                'lastName' => $_POST['lastName'],
                'email' => $_POST['email'],
                'content' => $_POST['content']
            ];

            if ($responseModel->createResponse($data)) {
                // Return JSON success response
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Cảm ơn bạn đã gửi thông tin! Chúng tôi sẽ liên hệ với bạn sớm nhất có thể.']);
                exit();
            } else {
                // Return JSON error response
                header('Content-Type: application/json');
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra khi gửi thông tin. Vui lòng thử lại sau.']);
                exit();
            }
        }
        
        // For GET requests, render the view
        else {
            $data = [
                'user' => $userData,
                'formalInfo' => $formalInfoList
            ];
            
            $this->view('home/contract', $data);
        }
    }
}
?>