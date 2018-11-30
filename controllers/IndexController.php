<?php
namespace controllers;

class IndexController extends BaseController
{
    public function index()
    {
        view('index/index');
    }
    public function top()
    {
        view('index/top');
    }
    public function menu()
    {
        view('index/menu');
    }
    public function main()
    {
        view('index/main');

    }
}