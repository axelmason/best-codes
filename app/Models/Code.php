<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'description',
        'views_count',
        'usages_count',
        'moderate_status',
        'moderate_message',
        'moderator_id',
        'user_id',
        'shop_id',
        'type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
