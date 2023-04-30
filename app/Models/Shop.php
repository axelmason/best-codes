<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'alias', 'top', 'description', 'url', 'type_id'];

    public function codes()
    {
        return $this->hasMany(Code::class);
    }

    public function type()
    {
        return $this->belongsTo(ShopType::class);
    }

    public function related()
    {
        return $this->query()->where('id', '<>', $this->id)
            ->whereHas('type', function ($query) {
                $query->where('id', $this->type->id);
            })->get();
    }
}
