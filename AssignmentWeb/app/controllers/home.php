<?php
class Home extends Controller
{
    public function index()
    {
        $formalInfo = $this->model('FormalInfo');
        $formalInfoList = $formalInfo->getAllFormalInfo();
        if (!$formalInfoList) {
            echo $formalInfoList;
            return;
        }
        $this->view('home/index', ['formalInfo' => $formalInfoList]);
    }
    public function contract()
    {
        $formalInfo = $this->model('FormalInfo');
        $formalInfoList = $formalInfo->getAllFormalInfo();
        
        $this->view('home/contract', ['formalInfo' => $formalInfoList]);
    }
}
?>