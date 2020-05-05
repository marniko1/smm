<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class PermissionsController extends Controller
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
        /*----------  Checks if request is AJAX  ----------*/
        
        if (request()->ajax()) {

            $permissions = Permission::all();

            return DataTables::of($permissions)
            ->addColumn('action', function ($permission) {
                return '<div class="editDeleteWrapp" data-id="' . $permission->id . '">
                            <a class="edit btn btn-xs btn-warning btn-sm" href="#" data-toggle="modal" data-target="#editPermissionModal">
                                <i class="fas fa-edit"></i>
                                Edit
                            </a>
                            <a class="delete btn btn-xs btn-danger btn-sm" href="#" data-toggle="modal" data-target="#removePermissionModal">
                                <i class="fas fa-trash-alt"></i>
                                Delete
                            </a>
                        </div>';
            })
            ->editColumn('id', 'ID: {{$id}}')
            ->make();
        }

        return view('admin.permissions');
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
        $params = $request->all();
        $validator = Validator::make($params, [
            'name' => 'required|unique:permissions,name|string|max:255',
        ]);

        if ($validator->fails()) {

            if (request()->ajax()) {
                return response()->json(['errors'=>$validator->getMessageBag()->toArray()]);
            }
        }

        $permission = Permission::create($params);

        if (request()->ajax()) {
            return response()->json(['success'=>'New permission has been added.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        // return response()->json($request->all());
        $params = $request->all();
        $id = $request['id'];
        $permission = Permission::findOrFail($id);//Get role with the given id
    //Validate name and permission fields
        $validator = Validator::make($params, [
            'name'=>'required|max:255|unique:permissions,name,'.$id,
            // 'permissions' =>'required',
        ]);


        if ($validator->fails()) {

            if (request()->ajax()) {
                return response()->json(['errors'=>$validator->getMessageBag()->toArray()]);
            }
        }


        $input = $params;
        // $input = $request->except(['permissions']);
        $permission->fill($input)->save();
        // if($request->permissions <> ''){
        //     $permission->permissions()->sync($request->permissions);
        // }
        // return redirect()->route('roles.index')->with('success','Roles updated successfully');
        if (request()->ajax()) {
            return response()->json(['success'=>'Permission updated successfully.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Permission::destroy($id);
        
        return response()->json(['success'=>'Permission deleted successfully.']);
    }
}
