<?php
class Qaa extends Controller
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

    $this->view('introduce/qaa', $data);
  }


}
?>