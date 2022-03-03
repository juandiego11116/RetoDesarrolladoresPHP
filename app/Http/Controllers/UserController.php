<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\View\View;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use  Illuminate\Support\Arr;

class UserController extends Controller
{
    use WithPagination;
    public function __construct()
    {
        $this->middleware('permission:show-user|create-user|edit-user|delete-user', ['only'=>['index']]);
        $this->middleware('permission:create-user', ['only'=>['create','store']]);
        $this->middleware('permission:edit-user', ['only'=>['edit','update']]);
        $this->middleware('permission:delete-user', ['only'=>['destroy']]);
    }

    public function search(Request $request):View
    {
        $users = User::where('name', 'like', '%'. $request->text . '%')->take(10)->get();
        return view('users.index', compact('users'));
    }
    public function index(Request $request):View
    {
        $text = trim($request->get('text'));
        $users = DB::table('users')
                    ->select('id', 'name', 'last_name', 'email')
                    ->where('name', 'LIKE', '%'.$text.'%')
                    ->orWhere('last_name', 'LIKE', '%'.$text.'%')
                    ->orWhere('email', 'LIKE', '%'.$text.'%')
                    ->orderBy('name', 'asc')
                    ->paginate(5);
        return view('users.index', compact('users', 'text'));
    }

    public function create():View
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request):RedirectResponse
    {
        //cambiar  a form request
        $this->validate($request, [
            'name' => 'required',
            'last_name' => 'required',
            'document_type' => 'required',
            'document' => 'required',
            'country' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        return redirect()->route('users.index');
    }

    public function edit($id):View
    {
        $user =  User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(Request $request, $id):RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'last_name' => 'required',
            'document_type' => 'required',
            'document' => 'required',
            'country' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));
        return redirect()->route('users.index');
    }

    public function destroy($id):RedirectResponse
    {
        User::find($id)->delete();
        return redirect()->route('users.index');
    }
    public function getUsers(Request $request):JsonResponse
    {
        $filter = $request->search;

        $users = Libro::where('name', $filter)->get();

        return response()->json($users, 200);
    }
}
