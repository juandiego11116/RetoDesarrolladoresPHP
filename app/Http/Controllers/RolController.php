<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show-role|create-role|edit-role|delete-role', ['only'=>['index']]);
        $this->middleware('permission:create-role', ['only'=>['create','store']]);
        $this->middleware('permission:edit-role', ['only'=>['edit','update']]);
        $this->middleware('permission:delete-role', ['only'=>['destroy']]);
    }

    public function index(Request $request):View
    {
        $text = trim($request->get('text'));
        $roles = DB::table('roles')
            ->select('id', 'name')
            ->where('name', 'LIKE', '%'.$text.'%')
            ->orderBy('name', 'asc')
            ->paginate(5);
        return view('roles.index', compact('roles', 'text'));
    }

    public function create(Request $request):View
    {
        $text = trim($request->get('text'));
        $permission = DB::table('permissions')
            ->select('id', 'name')
            ->where('name', 'LIKE', '%'.$text.'%')
            ->orderBy('name', 'asc')
            ->paginate();
        return view('roles.create', compact('permission', 'text'));
    }

    public function store(Request $request):RedirectResponse
    {
        $this->validate($request, ['name' => 'required', 'permission' => 'required']);
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index');
    }

    public function edit($id):View
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('roles.edit', compact('role', 'permission', 'rolePermissions'));
    }


    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, ['name' => 'required', 'permission' => 'required']);
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
        $role->syncPermissions($request->input('permission'));
        return redirect()->route('roles.index');
    }

    public function destroy($id):RedirectResponse
    {
        DB::table('roles')->where('id', $id)->delete();
        return redirect()->route('roles.index');
    }
    public function search(Request $request):View
    {
        $text = trim($request->get('text'));
        $roles = DB::table('roles')
            ->select('id', 'name')
            ->where('name', 'LIKE', '%'.$text.'%')
            ->orderBy('name', 'asc')
            ->paginate(5);
        return view('roles.index', compact('roles', 'text'));
    }
}
