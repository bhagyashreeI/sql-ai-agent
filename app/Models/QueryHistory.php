<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QueryHistory extends Model
{
    protected $fillable = [
        'input_text',
        'sql_output',
        'builder_output',
        'eloquent_output'
    ];
}
