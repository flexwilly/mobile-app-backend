<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['order_by','event_id','order_number','quantity','unit_price','cost','status'];


    public function events(){
        $this->belongsTo(Event::class);
    }
}
