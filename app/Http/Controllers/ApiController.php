<?php

namespace App\Http\Controllers;

use F9Web\ApiResponseHelpers;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    use ApiResponseHelpers;

    public function errorMessage()
    {
        return 'Terjadi kesalahan, cobalah beberapa saat lagi atau hubungi administrator.';
    }
}
