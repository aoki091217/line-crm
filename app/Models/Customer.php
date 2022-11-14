<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'line_id',
        'nickname',
        'gender',
        'age',
        'type',
        'is_followed',
        'is_confirm_send',
        'add_user',
        'mod_user'
    ];
}
