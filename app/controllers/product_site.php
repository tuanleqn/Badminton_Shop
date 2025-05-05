<?php

class ProductSite extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');
        $this->load->model('site_model');
    }

    public function index()
    {
        $data['products'] = $this->product_model->get_all_products();
        $data['sites'] = $this->site_model->get_all_sites();
        $this->load->view('product_site/index', $data);
    }
}