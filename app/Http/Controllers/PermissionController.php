<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(Request $request): mixed
    {
        $permissions = Permission::paginate();
        return Inertia::render( 'Administrator/Permission/Index', ['permissions' => $permissions, 'i' => ($request->input('page', 1) - 1) * $permissions->perPage()]);
    }
}