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