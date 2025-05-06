<?php

class ProductSite extends Controller
{
    private $product_model;
    private $site_model;

    public function __construct()
    {
        $this->product_model = $this->model('SiteModel');
        $this->site_model = $this->model('SiteModel');
    }

    public function index()
    {
        // $data['products'] = $this->product_model->get_all_products();
        // $data['sites'] = $this->site_model->get_all_sites();
        $this->view('product_site/index');
    }
    public function productdetail()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
            $stars = isset($_POST['stars']) ? (int)$_POST['stars'] : 0;
            $title = isset($_POST['title']) ? trim($_POST['title']) : '';
            $details = isset($_POST['details']) ? trim($_POST['details']) : '';

            $productController = new ProductController();
            $message = $productController->submitReview($productId, $stars, $title, $details);

            echo $message;
        }
        $this->view('product_site/product_detail');
    }
}