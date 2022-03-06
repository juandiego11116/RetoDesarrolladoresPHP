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

    public function search(Request $request): View
    {
        $users = User::where('name', 'like', '%'. $request->text . '%')->take(10)->get();
        return view('users.index', compact('users'));
    }
    public function index(Request $request): View
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

    public function create(): View
    {
        $documentTypes =DB::table('document_types')
            ->select('id', 'name')
            ->get();

        $countries = DB::table('countries')
            ->select('id', 'name')
            ->get();

        $roles = Role::pluck('name', 'name')->all();
        return view('users.create', compact('roles', 'countries', 'documentTypes'));
    }

    public function store(Request $request): RedirectResponse
    {
        //cambiar  a form request
        $this->validate($request, [
            'name' => 'required',
            'last_name' => 'required',
            'id_document_type' => 'required',
            'document' => 'required',
            'id_country' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $documentTypes = DB::table('document_types')
            ->select('id')
            ->where('name', '=', $request->id_document_type)
            ->get();

        $countries = DB::table('countries')
            ->select('id')
            ->where('name', '=', $request->id_country)
            ->get();

        $user = new User();
        $user->name = $request->input('name');
        $user->last_name = $request->input('last_name');
        $user->id_document_type = $documentTypes[0]->id;
        $user->document = $request->input('document');
        $user->id_country = $countries[0]->id;
        $user->address = $request->input('address');
        $user->phone_number = $request->input('phone_number');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();
        $user->assignRole($request->input('roles'));


        return redirect()->route('users.index');
    }

    public function edit($id): View
    {
        $user =  User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        $documentTypes =DB::table('document_types')
            ->select('id', 'name')
            ->get();

        $countries = DB::table('countries')
            ->select('id', 'name')
            ->get();
        return view('users.edit', compact('user', 'roles', 'userRole', 'countries', 'documentTypes'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'last_name' => 'required',
            'id_document_type' => 'required',
            'document' => 'required',
            'id_country' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
        $documentTypes = DB::table('document_types')
            ->select('id')
            ->where('name', '=', $request->id_document_type)
            ->get();

        $countries = DB::table('countries')
            ->select('id')
            ->where('name', '=', $request->id_country)
            ->get();

        $input = $request->all();
        if (!empty($request->password)) {
            $request->password = Hash::make($request->password);
        } else {
            $request = Arr::except($input, array('password'));
        }

        $request['id_document_type'] = $documentTypes[0]->id;
        $request['id_country'] = $countries[0]->id;

        $user = User::find($id);
        $user->update($request);

        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request['roles']);

        return redirect()->route('users.index');
    }

    public function destroy($id): RedirectResponse
    {
        User::find($id)->delete();
        return redirect()->route('users.index');
    }
    public function getUsers(Request $request): JsonResponse
    {
        $filter = $request->search;

        $users = Libro::where('name', $filter)->get();

        return response()->json($users, 200);
    }
}
