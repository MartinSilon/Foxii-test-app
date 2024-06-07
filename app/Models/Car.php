<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use HasFactory, SoftDeletes;

    public function parts()
    {
        return $this->hasMany(Part::class);
    }

    protected $fillable = [
        'id',
        'name',
        'registration_number',
        'is_registered',
        'updated_at',
    ];
    protected $table = 'cars';
}
