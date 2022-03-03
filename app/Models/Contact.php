<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'email',
        'title',
        'body',
        'status'
    ];

    public function scopeSearch($query){
        if ($searchTitle = request()->searchTitle){
            $query = $query->where('title','like','%'.$searchTitle.'%');
        }
        return $query;
    }
}
