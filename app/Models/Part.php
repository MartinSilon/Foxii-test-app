<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory, SoftDeletes;

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    protected $fillable = [
        'id',
        'name',
        'serialNumber',
        'car_id',
        'updated_at',
    ];
    protected $table = 'parts';
}
