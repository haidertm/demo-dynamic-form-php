<?php

namespace Haider\Demo\Api\Controllers;

class HomeController  extends Controller
{
    public function index()
    {
        // echo json_encode(["message" => "Hello From Home Page!"]);

        // Let's show the list for now
        $this->render('list-forms');
    }
}