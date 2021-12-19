<?php

namespace App\Http\Controllers;

use F9Web\ApiResponseHelpers;

class ApiController extends Controller
{
    use ApiResponseHelpers;

    public function errorMessage()
    {
        return 'Terjadi kesalahan, cobalah beberapa saat lagi atau hubungi administrator.';
    }
}
