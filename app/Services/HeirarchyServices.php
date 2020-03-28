<?php

namespace App\Services;

use App\Heirarchy;

class HeirarchyServices
{
    /*
        root is counted as level 1 
    */
    static $level = 1;
    static $tree = array();

    public static function countLevel(Heirarchy $heirarchy)
    {
        //level count; root is level 0
        if(!$heirarchy->description->is_root){
            self::$level++;
            self::countLevel($heirarchy->myParent());
        }

        return self::$level;
    }

    public static function tree(Heirarchy $heirarchy)
    {
        self::$tree[]= $heirarchy;
        if(!$heirarchy->description->is_root){
            self::tree($heirarchy->myParent());
        }
        return self::$tree;
    }
}

