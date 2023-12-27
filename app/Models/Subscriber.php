<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'email'
    ];

    /**
     * Gets all of the adverts for the subscriber.
     */
    public function adverts()
    {
        return $this->hasManyThrough(
            Advert::class,
            SubscriberAdvert::class,
            'subscriber_id',
            'id',
            'id',
            'advert_id'
        );
    }
}
