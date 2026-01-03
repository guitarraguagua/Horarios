<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class HomeCon extends Controller
{
    public function index()
    {
        return view('welcome_message');
    }
}