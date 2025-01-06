<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Electorate extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'electorates';

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
    protected $fillable = ['name_electorate', 'province_id', 'district_id'];

    
}
