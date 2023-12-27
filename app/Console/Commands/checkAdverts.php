<?php

namespace App\Console\Commands;

use App\Classes\ParseAdvert;
use App\Models\Advert;
use App\Models\Subscriber;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class checkAdverts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:check_adverts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checking adverts prices';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $limit = 100;
        $start = 0;
        $datetime = new DateTime();
        $parseAdvert = new ParseAdvert();

        do {
            $adsToCheck = Advert::offset($start * $limit)
                ->limit($limit)
                ->get();

            foreach ($adsToCheck as $item) {
                $itemState = $parseAdvert->parseUpdateAdvert($item->url);
            }

            $start++;
        } while ($adsToCheck->isNotEmpty());

        $start = 0;

        do {
            $subscribersToCheck = Subscriber::offset($start * $limit)
                ->limit($limit)
                ->get();

            foreach ($subscribersToCheck as $item) {
                $adverts = $item
                    ->adverts()
                    ->where([
                        ['price', '!=', 'previous_price'],
                        ['adverts.updated_at', '>=', $datetime->format('Y-m-d H:i:s.v')],
                    ])
                    ->get();

                Mail::send('email.adverts', ['data' => $adverts], function($message) use ($item) {
                    $message->to($item->email);
                    $message->subject('Оголошення зі змінами цін, на які Ви підписані - ' . env('APP_NAME') . '.');
                });
            }

            $start++;
        } while ($adsToCheck->isNotEmpty());
    }
}
