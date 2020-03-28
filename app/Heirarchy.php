<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Heirarchy extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'heirarchy_id',
        'title',
        'slug',
        'status'
    ];

    public function description()
    {
        return $this->hasOne(HeirarchyDescription::class, 'heirarchy_id', 'heirarchy_id');
    }

    /**
    *   @return Heirarchy returns parent of the given heirarchy model
    */
    public function myParent()
    {
        return Heirarchy::where('heirarchy_id', $this->description->parent_id)->first();
    }
}
