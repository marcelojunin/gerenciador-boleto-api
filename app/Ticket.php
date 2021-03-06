<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = "user";
    protected $fillable = [
        'path',
        'user_id',
    ];
    public $timestamps = false;

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
