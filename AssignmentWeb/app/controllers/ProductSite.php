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
        $userData = Session::getInstance()->get('user');
        if ($userData === false) {
            $userData = null;
        }

        // Get all products for pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 12; // Products per page
        $offset = ($page - 1) * $limit;
        
        $products = $this->site_model->getAllProducts($limit, $offset);
        $totalProducts = $this->site_model->getTotalProducts();
        $totalPages = ceil($totalProducts / $limit);
        
        // Get brands and sizes for filtering
        $brands = $this->site_model->getAllBrands();
        $sizes = $this->site_model->getAllSizes();

        $data = [
            'user' => $userData,
            'products' => $products,
            'brands' => $brands,
            'sizes' => $sizes,
            'page' => $page,
            'totalPages' => $totalPages,
            'siteModel' => $this->site_model
        ];
        
        $this->view('product_site/index', $data);
    }
    public function productdetail()
    {
        $this->view('product_site/product_detail');
    }
    public function productcart()
    {
        $this->view('product_site/product_cart');
    }
    public function ordermanagement()
    {
        $this->view('product_site/order_management');
    }
}