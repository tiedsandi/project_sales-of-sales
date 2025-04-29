<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Role::get();
        return view('admin.role.index', compact('datas'));
    }

    public function create()
    {
        return view('admin.role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation  = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }

        Role::create([
            'name' => $request->name,
        ]);

        Alert::success('Success', 'Role created successfully');

        return redirect()->route('role.index');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::find($id);
        if (!$role) {
            Alert::error('Error', 'Role not found');
            return redirect()->route('role.index');
        }

        return view('admin.role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::find($id);
        if (!$role) {
            Alert::error('Error', 'Role not found');
            return redirect()->route('role.index');
        }

        $validation  = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }

        $role->update([
            'name' => $request->name,
        ]);

        Alert::success('Success', 'Role updated successfully');
        return redirect()->route('role.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::find($id);
        if (!$role) {
            Alert::error('Error', 'Role not found');
            return redirect()->route('Role.index');
        }

        if ($role->id == 1 || $role->id == 2 || $role->id == 3) {
            Alert::error('Error', 'Role disable to delete');
            return redirect()->route('role.index');
        }


        User::where('role_id', $id)->delete();

        $role->delete();

        Alert::success('Success', 'Role deleted successfully');
        return redirect()->route('role.index');
    }
}
