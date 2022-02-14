<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $breadcrumbs = ['ホーム'];
        return view('user.index', ['breadcrumbs' => $breadcrumbs,]);
    }
}
