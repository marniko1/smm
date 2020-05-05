<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:Administrator'])->except(['edit', 'update']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $all_roles = Role::all();
        /*----------  Checks if request is AJAX  ----------*/
        
        if (request()->ajax()) {

            return DataTables::of(User::with('roles')->get())
            ->addColumn('roles', function ($user) {
                $user_roles = '';

                foreach ($user->roles as $key => $role) {
                    $user_roles .= $role->name . ', ';
                }

                $user_roles = rtrim($user_roles, ', ');

                return $user_roles;
            })
            ->addColumn('action', function ($user) {
                return '<div class="editDeleteWrapp" data-id="' . $user->id . '">
                            <a class="edit btn btn-xs btn-warning btn-sm" href="#" data-toggle="modal" data-target="#editUserModal">
                                <i class="fas fa-edit"></i>
                                Edit
                            </a>
                            <a class="delete btn btn-xs btn-danger btn-sm" href="#" data-toggle="modal" data-target="#removeUserModal">
                                <i class="fas fa-trash-alt"></i>
                                Delete
                            </a>
                        </div>';
            })
            ->make();
        }

        return view('admin.users')->with('all_roles', $all_roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make( $request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => 'required|string|max:255|unique:users',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {

            if (request()->ajax()) {
                return response()->json(['errors'=>$validator->getMessageBag()->toArray()]);
            }
        }

        $user = User::create($request->only('name', 'username', 'email', 'password')); //Creating user

        $user->syncRoles($request->roles); //Assigning role to user


        if (request()->ajax()) {
            return response()->json(['success'=>'New user has been added.']);
        }
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
        // dd(Auth::id());
        $user = Auth::user();
        if ($user->id != $id && !$user->hasRole('Administrator')) {
            abort(403);
        }
        $user = User::find($id);
        $all_roles = Role::all();
        return view('admin.profile')->with(['user' => $user, 'all_roles' => $all_roles]);
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

        $user = Auth::user();
        if ($user->id != $id && !$user->hasRole('Administrator')) {
            abort(403);
        }

        $user = User::findOrFail($id);//Get user with the given id
        
        //Validate user new data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);


        if ($validator->fails()) {

            if (request()->ajax()) {
                return response()->json(['errors'=>$validator->getMessageBag()->toArray()]);
            }

            return redirect(url()->previous())
                        ->withErrors($validator)
                        ->withInput();
        }

        if (empty($request->password)) {
            
            $input = $request->only('name', 'username', 'email');
        } else {

            $input = $request->only('name', 'username', 'email', 'password');
        }

        $user->fill($input)->save();
        $user->roles()->sync($request->roles);
        
        if (request()->ajax()) {
            return response()->json(['success'=>'User updated successfully.']);
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        
        return response()->json(['success'=>'User deleted successfully.']);
    }
}
