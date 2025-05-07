<?php
class Qaa extends Controller
{
  private $session;

  public function __construct()
  {
    $this->session = Session::getInstance();
  }

  public function index()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $dataNew = [
        'category' => 'Khác',
        'question' => $_POST['question'] ?? '',
        'answer' => 'Chưa có câu trả lời',
        'name' => $_POST['name'] ?? '',
        'email' => $_POST['email'] ?? '',
        'phone' => $_POST['phone'] ?? '',
        'displayOrder' => 1
      ];
      $qaaModel = $this->model('Qaam');

      if ($qaaModel->createQaa($dataNew)) {
        header('Location: ' . URL::to('public/qaa/index'));
        exit();
      }
    }

    $userData = $this->session->get('user');
    if ($userData === false) {
      $userData = null;
    }

    $formalInfo = $this->model('FormalInfo');
    $formalInfoList = $formalInfo->getAllFormalInfo();

    if ($userData && $userData['role'] === 'admin') {
      header('Location: ' . URL::to('public/admin/index'));
      exit();
    }

    $qaaModel = $this->model('Qaam');
    $faqGrouped = $qaaModel->getFaqsGroupedByCategory();

    $data = [
      'user' => $userData,
      'formalInfo' => $formalInfoList,
      'faqs' => $faqGrouped
    ];

    $this->view('introduce/qaa', $data);
  }
}
?>