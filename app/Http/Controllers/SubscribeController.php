<?php

namespace App\Http\Controllers;

use App\Classes\ParseAdvert;
use App\Models\Advert;
use App\Models\Subscriber;
use App\Models\SubscriberAdvert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscribeController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'url' => 'required|string|url|max:2048',
        ]);

        if ($validator->fails()) {
            return $validator->messages();
        }

        $subscriber = Subscriber::firstOrCreate([
            'email' => $request->email
        ]);

        $advert = Advert::where([
            'url' => $request->url
        ])
            ->first();

        $parseAdvert = new ParseAdvert();

        if (!($advert instanceof Advert)) {
            $advert = $parseAdvert->parseUpdateAdvert($request->url);
        }

        SubscriberAdvert::firstOrCreate([
            'subscriber_id' => $subscriber->id,
            'advert_id' => $advert->id,
        ]);

        return json_encode(['success' => 1]);
    }
}
