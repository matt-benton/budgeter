<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    public $timestamps = false;

    public function budgetCategoryAmounts()
    {
        return $this->hasMany(BudgetCategoryAmount::class);
    }
}
