<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'line_token',
        'name',
        'sex',
        'generation',
        'reason',
        'customer_date',
        'is_followed',
        'is_confirm_send'
    ];
}
