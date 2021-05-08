@extends('layouts.main10')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('/', app()->getLocale()) }}" class="a-green"><i class="fa fa-home" aria-hidden="true"></i></a></li>
            <li class="breadcrumb-item"><a href="{{ route('articles', app()->getLocale()) }}" class="a-green">{{ trans('site.Articles') }}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{ $article->title }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center text-design2">{{ $article->title }}</h1>
        </div>

        <div class="col-md-12 text-center">
            <br/>
            <?php if (isset($article->photo) && !empty($article->photo)): ?>
                <img src="<?=config('app.url')?>/articles/imgs/<?=$article->photo?>" alt="Makklays - {{ trans('site.Articles') }} image" title="<?=$article->title?>" class="img-fluid kromka" />
            <?php else: ?>
                <img src="<?=config('app.url')?>/img/empty_img2.png" alt="Makklays - {{ trans('site.Articles') }} image" title="<?=$article->title?>" class="img-fluid kromka" />
            <?php endif; ?>
            <br/><br/>
        </div>

        <div class="col-md-12 text-center" style="font-size:14px;">
            <div class="text-center" style="width:280px; margin: 0 auto;">

                <div style="float:left;">
                    <img src="<?=config('app.url')?>/img/eye.jpg" alt="eye" title="Makklays - {{ trans('site.views') }} image" style="width:18px;" /> {{ $article->views }}
                </div>

                <!-- Load Facebook SDK for JavaScript -->
                <div id="fb-root" style="float:left;"></div>
                <?php if (app()->getLocale() == 'ru'): ?>
                    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v7.0&appId=280039816428797&autoLogAppEvents=1" nonce="oUPQv7L9"></script>
                <?php elseif (app()->getLocale() == 'es'): ?>
                    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v7.0&appId=280039816428797&autoLogAppEvents=1" nonce="oUPQv7L9"></script>
                <?php else: ?>
                    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_EN/sdk.js#xfbml=1&version=v7.0&appId=280039816428797&autoLogAppEvents=1" nonce="oUPQv7L9"></script>
                <?php endif; ?>

                <!-- Your share like button code -->
                <div class="fb-like" style="margin-left:30px;" data-href="https://makklays.com<?=$_SERVER['REQUEST_URI']?>" data-width="" data-layout="button_count" data-action="like" data-size="small" data-share="true"></div>

            </div>
        </div>

        <div class="col-md-12" style="margin-top: 40px;">
            <p class="text-justify">
                <?=nl2br($article->full_text)?>
            </p>
        </div>
    </div>

@endsection
