<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeirarchyDescription extends Model
{
    use SoftDeletes;

    protected $fillable = [

        'heirarchy_id',
        'is_root',
        'parent_id'
        
    ];
}
