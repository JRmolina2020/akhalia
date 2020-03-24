<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Role;

class RoleController extends Controller
{
    public function index()
    {
        $role = Role::addselect(
            'id',
            'name'
        )->get();

        return response()->json($role);
    }
}