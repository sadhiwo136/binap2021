<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Documents;
use App\Post;
use Redirect,Response;
use Illuminate\Support\Facades\File;

class UploadController extends Controller
{
    public function upload()
    {
        $documents = Documents::all();
        return view('admin.upload')->with('documents', $documents);
        //return view('admin.upload');
    }

    public function proses_upload()
    {
        request()->validate([
            'fileku' => 'required|mimes:doc,pdf,docx,zip,txt,jpg,png,jpeg',
        ]);  

        $fileName = request()->fileku->getClientOriginalName();
        $ext = request()->fileku->getClientOriginalExtension();  

        request()->fileku->move(public_path('files'), $fileName);
        
        $docs = new Documents;
        $docs->file_name = $fileName;
        $docs->ext = $ext;
        $docs->save();

        return back()->with('success','You have successfully uploaded the file.');            
	}

    /*public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Documents::where($where)->first(); 
        return Response::json($post);
    }*/

    public function delete($id)
    {
        $docs = Documents::findOrFail($id);
        $fn =  Documents::where('id', $id)->value('file_name');
        $src = 'files';
        //File::delete($src.'/'.$fn);
        unlink($src.'/'.$fn);
        $docs->delete();

        return back()->with('success','You have successfully deleted the file.');
    }
}