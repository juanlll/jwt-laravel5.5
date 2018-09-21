<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $table='records';
    protected $primaryKey='id';
    public $timestamps=true;
    protected $fillable=['temp','humidity','co2'];
    protected $guarded=[];
}
