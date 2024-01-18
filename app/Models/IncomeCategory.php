<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IncomeCategory extends Model
{
    use HasFactory;
    protected $table = "income_categories";
    protected $fillable = [
        "budget_id",
        "name",
        "goal_amount",
        "note",
    ];
    public function budget() : BelongsTo {
        return $this->belongsTo(Budget::class, 'budget_id');
    }
}
