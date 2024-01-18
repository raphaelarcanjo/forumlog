<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [ 'message', 'private', 'user_id' ];

    public function comments()
    {
        return $this->hasMany(BlogComment::class)->orderBy('id', 'desc');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
