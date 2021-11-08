<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetCategoryAmount extends Model
{
    public $timestamps = false;

    protected $fillable = ['budget_id', 'category_id', 'amount'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = $value * 100;
    }
}
