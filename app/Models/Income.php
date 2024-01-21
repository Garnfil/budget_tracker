<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Income extends Model
{
    use HasFactory;
    protected $table = "incomes";
    protected $fillable = [
        "budget_id",
        "title",
        "description",
        "income_category_id",
        "amount",
        "transaction_datetime"
    ];

    public function budget() : BelongsTo {
        return $this->belongsTo(Budget::class, 'budget_id');
    }

    public function income_category() : BelongsTo {
        return $this->belongsTo(IncomeCategory::class, 'income_category_id');
    }
}
