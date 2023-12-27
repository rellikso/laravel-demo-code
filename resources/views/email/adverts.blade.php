<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Оголошення зі змінами цін, на які Ви підписані - {{env('APP_NAME')}}.</title>

    <!-- Styles -->
    <style>
        body {
            background-color: #ccc;
            font-family:-apple-system,BlinkMacSystemFont,Inter,Roboto,Helvetica Neue,Arial,Noto Sans,Liberation Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;
        }

        #content {
            border: solid 1px #bbb;
            background-color: #fff;
            display: block;
        }

        .advert {
            border: solid 1px #ddd;
            background-color: #eee;
            margin: 10px;
            width: 98.5%;
            display: inline-block;
        }

        .img {
            float: left;
            display: block;
        }

        .adcontent {
            float: left;
            display: block;
        }

        h2 {
            margin-top: 0;
        }

        @media screen and (min-width:1382px) {
            #content {
                margin: 10px;
                width: 98%;
            }

            .advert {
                margin: 10px;
                width: 47.5%;
                height: 410px;
            }

            .img {
                width: 20%;
                padding: 10px;
            }

            .img img {
                width: 100%
            }

            .adcontent {
                width: 75%;
                padding: 10px;
            }
        }

        @media screen and (max-width:1381px) {
            #content {
                margin: 10px;
                width: 98%;
            }

            .advert {
                margin: 10px;
                width: 48%;
                height: 500px;
            }

            .img {
                width: 20%;
                padding: 10px;
            }

            .img img {
                width: 100%
            }

            .adcontent {
                width: 73%;
                padding: 10px;
            }
        }

        @media screen and (max-width:1215px) {
            #content {
                margin: 10px;
                width: 98%;
            }

            .advert {
                margin: 10px;
                width: 48%;
                height: 520px;
            }

            .img {
                width: 20%;
                padding: 10px;
            }

            .img img {
                width: 100%
            }

            .adcontent {
                width: 72%;
                padding: 10px;
            }
        }

        @media screen and (max-width:1122px) {
            #content {
                margin: 10px;
                width: 98%;
            }

            .advert {
                margin: 10px;
                width: 47.5%;
                height: 520px;
            }

            .img {
                width: 20%;
                padding: 10px;
            }

            .img img {
                width: 100%
            }

            .adcontent {
                width: 72%;
                padding: 10px;
            }
        }

        @media screen and (max-width:1076px) {
            #content {
                margin: 10px;
                width: 98%;
            }

            .advert {
                margin: 10px;
                width: 97%;
                height: auto;
            }

            .img {
                width: 20%;
                padding: 10px;
            }

            .img img {
                width: 100%
            }

            .adcontent {
                width: 72%;
                padding: 10px;
            }
        }

        .old-price {
            text-decoration: line-through;
        }

        .new-price {
            font-weight: 700;
        }
    </style>
</head>
<body>
<div id="content">
    @foreach($data as $advert)
        <div class="advert">
            <div class="img">
                <a href="{{$advert->url}}" noindex nofollow target="_blank">
                    <img src="{{$advert->preview}}">
                </a>
            </div>
            <div class="adcontent">
                <div>
                    <h2>{{$advert->title}}</h2>
                    <p>{!! Str::limit($advert->description, 500) !!}</p>
                </div>
                <div>
                    <p>Стара ціна: <span class="old-price">{{$advert->previous_price}} {{$advert->currency_symbol}}</span></p>
                    <p>Нова ціна: <span class="new-price">{{$advert->price}} {{$advert->currency_symbol}}</span></p>
                </div>
                <div>
                    <a href="{{$advert->url}}" noindex nofollow target="_blank">Переглянути</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
</body>
</html>
