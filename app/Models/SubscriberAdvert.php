<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriberAdvert extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscriber_id',
        'advert_id'
    ];
}
