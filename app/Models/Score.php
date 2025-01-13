<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'scores';

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
    protected $fillable = ['candidate_id', 'year_id', 'polling_unit_id', 'sub_district_id', 'electorate_id', 'district_id', 'province_id', 'score', 'round'];

    
}
