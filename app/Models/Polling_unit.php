<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Polling_unit extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'polling_units';

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
    protected $fillable = ['name_polling_unit', 'province_id', 'district_id', 'electorate_id', 'sub_district_id', 'eligible_voters'];

    
}
