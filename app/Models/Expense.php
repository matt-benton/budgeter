<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'amount',
        'name',
        'category_id',
        'date',
    ];

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = $value * 100;
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
