<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Political_party extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'political_parties';

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
    protected $fillable = ['name', 'logo', 'color'];

    
}
