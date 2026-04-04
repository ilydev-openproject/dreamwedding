<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'slug',
        'template_id',
        'access_token',
        'content',
    ];

    protected $casts = [
        'content' => 'array',
    ];
    public function rsvps()
    {
        return $this->hasMany(Rsvp::class);
    }
}
