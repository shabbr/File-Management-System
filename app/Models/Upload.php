<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Folder;
class Upload extends Model
{
    protected $fillable = [
        'original_name',
        'stored_name',
        'mime_type',
        'size',
        'path',
        'folder_path',
    ];

      public function folder()
      {
          return $this->belongsTo(Folder::class,'folder_id');
      }

      public function scopeSearch($query, $searchTerm)
      {
          return $query->where('original_name', 'like', '%' . $searchTerm . '%')
                       ->orWhere('stored_name', 'like', '%' . $searchTerm . '%')
                       ->orWhere('path', 'like', '%' . $searchTerm . '%')
                       ->orWhereHas('folder', function ($query) use ($searchTerm) {
                        $query->where('name', 'like', '%' . $searchTerm . '%')
                              ->orWhere('full_path', 'like', '%' . $searchTerm . '%');
                    });
      }

}
