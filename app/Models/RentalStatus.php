<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalStatus extends Model{
    use HasFactory;
    protected $table = 'rental_statuses';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name'
    ];

    public function rentals(){
        return $this->hasMany(Rentals::class);
    }

    

}
