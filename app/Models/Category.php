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

    public function getThreeMonthAvg(CarbonImmutable $endDate)
    {
        $startDate = $endDate->subMonths(3);

        $sumOfExpenses = $this->expenses()
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('amount');

        return floor($sumOfExpenses / 3);
    }
}
