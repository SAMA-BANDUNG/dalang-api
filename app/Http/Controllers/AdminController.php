<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AdminService;

class AdminController extends Controller
{
    public function verif(AdminService $adminService, $id){
        $result = $adminService->verifVendor($id);

        return $result;
    }
}
