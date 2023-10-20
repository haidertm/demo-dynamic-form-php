<?php

namespace Haider\Demo\Api\Controllers;

class HomeController  extends Controller
{
    public function index()
    {
        // Let's show the list for now
        $this->render('list-forms');
    }
}