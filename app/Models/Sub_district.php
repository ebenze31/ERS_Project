<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sub_district extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sub_districts';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name_sub_districts', 'province_id', 'district_id', 'electorate_id'];

    
}
