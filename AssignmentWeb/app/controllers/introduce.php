<?php
class Introduce extends Controller
{
  private $session;

  public function __construct()
  {
    $this->session = Session::getInstance();
  }

  public function index()
  {
    $userData = $this->session->get('user');
    if ($userData === false) {
      $userData = null;
    }

    $formalInfo = $this->model('FormalInfo');
    $formalInfoList = $formalInfo->getAllFormalInfo();

    $introduceModel = $this->model('IntroduceIntro');
    $introduceContent = $introduceModel->getValuesBySection('Giới thiệu');
    $visionContent = $introduceModel->getValuesBySection('Tầm nhìn');
    $missionContent = $introduceModel->getValuesBySection('Sứ mệnh');
    $coreValuesContent = $introduceModel->getValuesBySection('Giá trị cốt lõi');
    $businessPhilosophyContent = $introduceModel->getValuesBySection('Triết lý kinh doanh');
    $qualityPolicyContent = $introduceModel->getValuesBySection('Chính sách chất lượng');
    $sloganContent = $introduceModel->getValuesBySection('Khẩu hiệu');
    $suggestedContent = $introduceModel->getValuesBySection('CÓ THỂ BẠN SẼ THÍCH');
    $newsCategories = $introduceModel->getValuesBySection('DANH MỤC TIN TỨC');
    $productCategories = $introduceModel->getValuesBySection('DANH MỤC SẢN PHẨM');
    $branches = $introduceModel->getBranchWithUserPhone();

    if ($userData && $userData['role'] === 'admin') {
      header('Location: ' . URL::to('public/admin/index'));
      exit();
    }

    $data = [
      'user' => $userData,
      'formalInfo' => $formalInfoList,
      'introduceContent' => $introduceContent,
      'suggestedContent' => $suggestedContent,
      'newsCategories' => $newsCategories,
      'productCategories' => $productCategories,
      'branches' => $branches,
      'visionContent' => $visionContent,
      'missionContent' => $missionContent,
      'coreValuesContent' => $coreValuesContent,
      'businessPhilosophyContent' => $businessPhilosophyContent,
      'qualityPolicyContent' => $qualityPolicyContent,
      'sloganContent' => $sloganContent,
    ];

    $this->view('introduce/introduce', $data);
  }
}
?>