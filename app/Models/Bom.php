<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bom extends Model
{
    protected $table = 'mst_bom';

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

    public function bomDetails()
    {
        return $this->hasMany('App\Models\BomDetail');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function work()
    {
        return $this->belongsTo('App\Models\Work');
    }

    public function RabDetails()
    {
        return $this->hasMany('App\Models\RabDetail');
    }
}
