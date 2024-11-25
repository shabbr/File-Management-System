<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Folder;
use App\Models\Upload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Validator;

class FolderController extends Controller
{
    public function folderForm(){
        $paths=Folder::select('full_path')->get();
        return view("folders.folder-form",compact("paths"));
    }
    public function storeFolder(Request $request, $parentId = null)
    {
            $existingFolder = Folder::where('path', $request->path)
            ->where('name', $request->name)
            ->first();

        if ($existingFolder) {
            return response()->json(['alreadyExists' => 'Folder name already exists'], 200);
        }
      $fullPath=$request->path .'/'.$request->name;
        $folder = new Folder();
        $folder->name= $request->name;
        $folder->path= $request->path;
        $folder->full_path= $fullPath;
        $folder->user_id= Auth::user()->id;
        $folder->save();
        Cache::flush();
        session()->flash('success', 'Folder created Successfully!');
        return redirect()->back();
    }


    public function showFolders($parentId=null)
    {
        $folders = Folder::where('path','root')->get();
        return response()->json([
            'folders' => $folders,
        ]);
    }



    public function show($path,$name)
    {
        $full_path =$path.'/'.$name;
        $paths=Folder::where('path',$full_path)->with('uploads')->get();
        $folder_id=Folder::select('id')->where('full_path',$full_path)->first()->id;
        $uploads=Upload::where('folder_id',$folder_id)->get();
        return view("folders.folder-data",compact(["paths","uploads"]));
        }

    public function showData(Request $request){
            $full_path =$request->path.'/'.$request->name;
            $paths=Folder::where('path',$full_path)->with('uploads')->get();
            $folder_id=Folder::select('id')->where('full_path',$full_path)->first()->id;
            $uploads=Upload::where('folder_id',$folder_id)->get();
            return view("folders.folder-data",compact(["paths","uploads"]));
}
public function move($id){
     $file=Upload::select(['id','stored_name','folder_id'])->with('folder')->find($id);
     $folders=Folder::get();
    return view("move",compact(["file","folders"]));
}


public function moveFile(Request $request){
     $file=Upload::find($request->file);
     $file->folder_id=$request->folder2;
     $file->save();
     Cache::flush();
     session()->flash('success', 'File moved successfully!');
     return redirect()->route('folders.form');
}
}

