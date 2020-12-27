<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    const UPDATED_AT = null;
    const CREATED_AT = 'created_date';
    protected $table = 'comment';
    public $timestamps = [ "created_date" ];
}
