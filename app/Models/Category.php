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
        $rangeEnd = $endDate->endOfMonth();
        $rangeStart = $endDate->subMonths(2)->startOfMonth();

        $sumOfExpenses = $this->expenses()
            ->whereBetween('date', [$rangeStart, $rangeEnd])
            ->sum('amount');

        return floor($sumOfExpenses / 3);
    }
}
