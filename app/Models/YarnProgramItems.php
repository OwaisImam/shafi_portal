<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YarnProgramItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'yarn_program_id',
        'order_id',
        'count_id',
        'fiber_id',
        'percentage',
        'kgs',
        'bags',
        'required_kgs'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function count()
    {
        return $this->belongsTo(Count::class);
    }

    public function fiber()
    {
        return $this->belongsTo(Fiber::class);
    }

}