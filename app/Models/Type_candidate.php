<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type_candidate extends Model
{

    protected $table = 'type_candidates';


    protected $primaryKey = 'id';

    protected $fillable = ['name','province'];


}
