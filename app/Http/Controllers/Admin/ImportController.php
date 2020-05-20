<?php

namespace App\Http\Controllers\Admin;
  
use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Imports\PostsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
  
class ImportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:Administrator']);
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function index()
    {
       return view('admin.import');
    }
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function export() 
    {
        // return Excel::download(new UsersExport, 'users.xlsx');
    }
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function import(Request $request) 
    {
        $validator = Validator::make( $request->all(), [
            'file'=> ['required'], //a required, max 10000kb, doc or docx file 'max:10000'
        ]);

        if ($request->has('file')) {
            $validator->after(function ($validator) use ($request){
                if($this->checkExcelFile($request->file('file')->getClientOriginalExtension()) == false) {
                    //return validator with error by file input name
                    $validator->errors()->add('file', 'The file must be a file of type: csv, xlsx, xls');
                }
            });
        }

        if ($validator->fails()) {

            return back()->withErrors($validator);
        }
        // dd(request()->file('file'));
        Excel::import(new PostsImport,request()->file('file'));
           
        return back();
    }


    public function checkExcelFile($file_ext){
        $valid=array(
            'csv','xls','xlsx' // add your extensions here.
        );        
        return in_array($file_ext,$valid) ? true : false;
    }
}
