<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Administrator']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $roles = Role::with('permissions')->get();
        $all_permissions = Permission::all();


        /*----------  Checks if request is AJAX  ----------*/
        

        if (request()->ajax()) {

            /*----------  Make DataTable  ----------*/
            
            return DataTables::of($roles)
            ->addColumn('permissions', function ($role) {
                $role_permissions = '';

                foreach ($role->permissions as $key => $permission) {
                    $role_permissions .= $permission->name . ',';
                }

                $role_permissions = rtrim($role_permissions, ',');

                return $role_permissions;
            })
            ->addColumn('action', function ($role) {
                return '<div class="editDeleteWrapp" data-id="' . $role->id . '">
                            <a class="edit btn btn-xs btn-warning btn-sm" href="#" data-toggle="modal" data-target="#editRoleModal">
                                <i class="fas fa-edit"></i>
                                Edit
                            </a>
                            <a class="delete btn btn-xs btn-danger btn-sm" href="#" data-toggle="modal" data-target="#removeRoleModal">
                                <i class="fas fa-trash-alt"></i>
                                Delete
                            </a>
                        </div>';
            })
            ->editColumn('id', 'ID: {{$id}}')
            ->make();
        }

        return view('admin.roles')->with('all_permissions', $all_permissions);
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

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name|string|max:255',
        ]);

        if ($validator->fails()) {

            if (request()->ajax()) {
                return response()->json(['errors'=>$validator->getMessageBag()->toArray()]);
            }
        }

        $input = $request->except(['permissions']);

        $role = Role::create($input);

        $role->syncPermissions($request->permissions);


        if (request()->ajax()) {
            return response()->json(['success'=>'New role has been added.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        
        $params = $request->all();
        $id = $request['id'];
        $role = Role::findOrFail($id);//Get role with the given id
        
        //Validate name and permission fields
        $validator = Validator::make($params, [
            'name'=>'required|max:255|unique:roles,name,'.$id,
            // 'permissions' =>'required',
        ]);


        if ($validator->fails()) {

            if (request()->ajax()) {
                return response()->json(['errors'=>$validator->getMessageBag()->toArray()]);
            }
        }

        $input = $request->except(['permissions']);
        $role->fill($input)->save();

        $role->permissions()->sync($request->permissions);

        if (request()->ajax()) {
            return response()->json(['success'=>'Role updated successfully.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::destroy($id);
        
        return response()->json(['success'=>'Role deleted successfully.']);
    }

    /**
     *
     * Give permission to role
     *
     */
    public function givePermissionsToRole(Request $request) {
        // $role->syncPermissions($permissions);
    }
    
}
