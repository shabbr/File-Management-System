<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Upload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class FileUploadController extends Controller
{
    public function showForm()
    {
        $paths=Folder::all();
        return view('upload',compact('paths'));
    }

    public function uploadFiles(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file|mimes:jpg,jpeg,png,gif,txt,pdf,doc,docx,xls,xlsx,mp3,mp4,avi|max:10240',
            'folder_id' =>'required'
        ]);
        $uploadedFiles = $request->file('files');

        foreach ($uploadedFiles as $file) {
            $originalName = $file->getClientOriginalName();
            $storedName = $this->generateUniqueFileName($originalName);
            $path = $file->storeAs('uploads', $storedName);
            $fileUpload=new Upload();
            $fileUpload->original_name=$originalName;
            $fileUpload->stored_name=$storedName;
            $fileUpload->mime_type=$file->getMimeType();
            $fileUpload->size=$file->getSize();
            $fileUpload->path=$path;
            $fileUpload->folder_id=$request->folder_id;
            $fileUpload->user_id=Auth::user()->id;
            $fileUpload->save();
        }
        Cache::flush(); 
        session()->flash('success', 'File uploaded successfully!');
        return redirect()->route('folders.form');
    }

    private function generateUniqueFileName($filename)
    {
        $pathInfo = pathinfo($filename);
        $baseName = $pathInfo['filename'];
        $extension = $pathInfo['extension'];
        $counter = 1;
        while (Storage::exists('uploads/' . $filename)) {
            $filename = $baseName . "($counter)." . $extension;
            $counter++;
        }
        return $filename;
    }

    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:1|max:255',
        ]);
        $searchTerm = $request->input('query');
        $cacheKey = "uploads_search_{$searchTerm}";
        $uploads = Cache::remember($cacheKey, 3600, function () use ($searchTerm) {
            return Upload::search($searchTerm)->paginate(20);
        });
        return view('uploads.search', compact('uploads', 'searchTerm'));
    }
}
