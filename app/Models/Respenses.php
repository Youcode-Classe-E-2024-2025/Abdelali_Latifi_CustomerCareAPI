<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respenses extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ticket_id',
        'message'
    ] ;

    public function ticket(){

        return $this->belongsTo(Tickets::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
