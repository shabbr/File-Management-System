<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $fillable = ['name', 'path'];
    public function uploads()
    {
        return $this->hasMany(Upload::class,'folder_id');
    }
}
