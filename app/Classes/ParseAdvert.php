<?php

namespace App\Classes;

use App\Models\Advert;
use Illuminate\Support\Facades\Http;

class ParseAdvert
{
    public function parseUpdateAdvert($url) {
        $response = Http::post($url);

        if ($response->status() == 200) {
            preg_match('#(?<=window\.__PRERENDERED_STATE__=\s[\'"]).+(?=[\'"];\s*window\.__TAURUS__)#iu', $response->body(), $preHtml);
            $source = $preHtml[0];
            unset($preHtml);

            $source = stripslashes($source);
            $source = json_decode($source, true);
            $source = $source['ad']['ad'];

            $advert = Advert::where([
                'url' => $url
            ])
                ->first();

            if (!($advert instanceof Advert)) {
                $advert = new Advert();

                $advert->url = $source['url'];
                $advert->title = $source['title'];
                $advert->preview = isset($source['photos'], $source['photos'][0]) ? $source['photos'][0] : '';
                $advert->description = $source['description'];
                $advert->price = $source['price']['regularPrice']['value'];
                $advert->currency_code = $source['price']['regularPrice']['currencyCode'];
                $advert->currency_symbol = $source['price']['regularPrice']['currencySymbol'];
            } else {
                $advert->previous_price = $advert->price;
                $advert->price = $source['price']['regularPrice']['value'];
                $advert->currency_code = $source['price']['regularPrice']['currencyCode'];
                $advert->currency_symbol = $source['price']['regularPrice']['currencySymbol'];
            }

            $advert->save();

            return $advert;
        }
    }
}