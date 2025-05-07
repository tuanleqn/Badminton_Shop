<?php
class News_site extends Controller
{
    private $session;
    private $siteModel;

    public function __construct()
    {
        $this->session = Session::getInstance();
        $this->siteModel = $this->model('SiteModel');
    }

    public function tintuc()
    {
        // Get user info from session if logged in
        $userData = $this->session->get('user');
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
            'formalInfo' => $formalInfoList,
            'siteModel' => $this->siteModel
        ];

        $this->view('news_site/tintuc', $data);
    }

    public function chitiettin()
    {
        // Get user info from session if logged in
        $userData = $this->session->get('user');
        if ($userData === false) {
            $userData = null;
        }
        
        // Load formal info for the header
        $formalInfo = $this->model('FormalInfo');
        $formalInfoList = $formalInfo->getAllFormalInfo();

        $data = [
            'user' => $userData,
            'formalInfo' => $formalInfoList,
            'siteModel' => $this->siteModel
        ];

        $this->view('news_site/chitiettin', $data);
    }
    public function process_comment()
    {
        $this->view('news_site/process_comment');
    }
    
    public function process_reply()
    {
        $this->view('news_site/process_reply');
    }
}
?>