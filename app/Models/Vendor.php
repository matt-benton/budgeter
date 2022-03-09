<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];

    public function expenses()
    {
        return $this->hasMany('App\Models\Expense');
    }
}
