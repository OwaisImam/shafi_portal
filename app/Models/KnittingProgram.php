<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnittingProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'order_id',
        'description',
        'fabric_content',
        'article_id',
        'required_finished_gsm',
        'required_finished_width',
        'required_finished_quality',
        'shade_matching_light',
    ];

    public function items() {
        return $this->hasMany(KnittingProgramItem::class);
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function job() {
        return $this->belongsTo(Job::class);
    }

}
