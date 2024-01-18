<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExpenseCategory extends Model
{
    use HasFactory;
    protected $table = "expense_categories";

    protected $fillable = [
        "budget_id",
        "name",
        "budgeted_amount",
        "note",
    ];
    public function budget() : BelongsTo {
        return $this->belongsTo(Budget::class, 'budget_id');
    }
}
