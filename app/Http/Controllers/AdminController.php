<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        return Inertia::render('Admins', [
            'admins' => Admin::all(),
        ]);
    }

    public function store(StoreAdminRequest $request)
    {
        $admin = $request->input('id') ? Admin::find($request->input('id')) : new Admin();
        $admin->name = $request->input('name');
        $admin->email = $request->input('email');
        if($request->input('password')) {
            $admin->password = bcrypt($request->input('password'));
        }
        $admin->save();

        return back();
    }

    public function destroy(Request $request)
    {
        $admin = Admin::find($request->input('id'));
        if ($admin) {
            $admin->delete();
        }

        return back();
    }
}
