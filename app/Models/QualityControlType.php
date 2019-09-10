<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QualityControlType extends Model
{
    protected $table = 'mst_quality_control_type';

    public function qualityControlTasks()
    {
        return $this->hasMany('App\Models\qualityControlType');
    }
}
