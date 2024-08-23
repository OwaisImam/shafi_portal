<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnittingProgramItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'knitting_program_id',
        'body_fabric',
        'body_fabric_dozen',
        'fabric_detail_kgs',
        'order_qty'
    ];
}
