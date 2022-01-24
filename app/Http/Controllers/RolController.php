<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $text = trim($request->get('text'));
        $roles = DB::table('roles')
            ->select('id', 'name')
            ->where('name', 'LIKE', '%'.$text.'%')
            ->orderBy('name', 'asc')
            ->paginate(5);
        return view('roles.index', compact('roles', 'text'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $text = trim($request->get('text'));
        $permission = DB::table('permissions')
            ->select('id', 'name')
            ->where('name', 'LIKE', '%'.$text.'%')
            ->orderBy('name', 'asc')
            ->paginate();
        return view('roles.create', compact('permission', 'text'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required', 'permission' => 'required']);
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('roles.edit', compact('role', 'permission', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, ['name' => 'required', 'permission' => 'required']);
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
        $role->syncPermissions($request->input('permission'));
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('roles')->where('id', $id)->delete();
        return redirect()->route('roles.index');
    }
    public function search(Request $request)
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
