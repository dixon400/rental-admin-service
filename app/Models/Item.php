<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'item_type_id'
    ];

    public function itemtype(){
        return $this->belongsTo(ItemType::class);
    }

    public function rentals(){
        return $this->hasMany(Rentals::class);
    }

}
