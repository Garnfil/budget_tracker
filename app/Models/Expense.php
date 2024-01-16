<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $table = "expenses";
    protected $fillable = [
        "budget_id",
        "title",
        "description",
        "expense_category_id",
        "amount",
        "transaction_datetime"
    ];
}
