<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\CarbonImmutable;

class Category extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];

    public function expenses()
    {
        return $this->hasMany('App\Models\Expense');
    }
}
