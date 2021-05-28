<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="utf-8" lang="{{ app()->getLocale() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Makklays | Test results</title>

    <meta name="description" content="Makklays Test Cat Dog" />
    <meta name="keywords" content="Makklays Test Cat Dog" />
    <link rel="canonical" href="{{ url()->current() }}" />
    <meta name="author" content="Makklays" />

    <meta property="og:title" content="Cats ??? or ??? Dogs" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="https://makklays.com" />
    <meta property="og:image" content="https://makklays.com/favicon.png" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="/logo50.png" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" media="all" href="<?=config('app.url')?>/css/bootstrap4/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?=config('app.url')?>/css/main.css?<?=time()?>" />
</head>
<body>

    <div class="row" style="margin-left: 0; margin-right:0;">
        <div class="col-md-12 text-center">

            <div class="text-center" style="margin:20px; ">
                <a href="{{ route('/', app()->getLocale()) }}" >
                    <img src="<?=config('app.url')?>/logo50.png" style="width: 78px;" alt="Logo" title="Makklays" />
                </a>
            </div>

            <div style="width:700px; margin-left:auto; margin-right:auto;">

                <div><b class="grey">{{ trans('site.dogs_or_cats') }}</b></div>

                <div style="border-bottom:1px solid lightgrey; padding:30px 0 10px 0;">
                    <h2>{{ trans('site.results_of_site') }}:</h2>
                </div>

                <?php if (isset($count_choices) && !empty($count_choices)): ?>
                    <?php foreach($count_choices as $choice): ?>
                        <div style="width:700px; margin:10px 0;">
                            <?php $la = 'site.'.$choice->choice ?>
                            <div><?=trans($la)?> (<?=$choice->count?> - <?=$choice->percent?> %)</div>
                            <div style="border: 5px solid grey; width:<?=$choice->percent*3?>px;"></div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <div style="border-top:1px solid lightgrey; padding-top:10px; margin-top:20px;">
                    <!--
                    <a href="/"><< Cancel</a>
                    -->
                </div>

                <div style="margin: 20px 0 0 0;"><h2>{{ trans('site.result_your_choice') }}:</h2></div>

                <?php if(isset($choice_cat_dog) && $choice_cat_dog == 'dog'): ?>
                    <div style="margin: 0 0 20px 0;">
                        <img src="/img/dog.jpg" title="Makklays | image dogs" class="ch-block-img" alt="cats" />
                    </div>
                    <div class="text-justify" style="background-color: #ededed; padding:10px 20px;">
                        <p>{{ trans('site.dog_text1') }}</p>
                        <p>{{ trans('site.dog_text2') }}</p>
                        <p>{{ trans('site.dog_text3') }}</p>
                        <p>{{ trans('site.last_text4') }}</p>
                    </div>
                <?php elseif (isset($choice_cat_dog) && $choice_cat_dog == 'cat'): ?>
                    <div style="margin: 0 0 20px 0;">
                        <img src="/img/cat.png" title="Makklays | image cats" class="ch-block-img" alt="cats" />
                    </div>
                    <div class="text-justify" style="background-color: #ededed; padding:10px 20px;">
                        <p>{{ trans('site.cat_text1') }}</p>
                        <p>{{ trans('site.cat_text2') }}</p>
                        <p>{{ trans('site.cat_text3') }}</p>
                        <p>{{ trans('site.last_text4') }}</p>
                    </div>
                <?php endif; ?>

                <br/><br/>

                <div><h2>{{ trans('site.Facts') }}:</h2></div>

                <div class="text-justify">{{ trans('site.fact_text1') }}<br/><br/></div>
                <div class="text-justify">{{ trans('site.fact_text2') }}</div>
                <div class="text-center" style="margin: 20px 0;">
                    {{ trans('site.dog') }} - 67%<br/>
                    {{ trans('site.cat') }} - 33%
                </div>
                <div class="text-justify">{{ trans('site.fact_text3') }}</div>
            </div>

            <div style="margin: 40px 0 10px 0;">
                <a class="green" href="{{ route('cat-o-dog-result', 'ua') }}">UA</a> |
                <a class="green" href="{{ route('cat-o-dog-result', 'es') }}">ES</a> |
                <a class="green" href="{{ route('cat-o-dog-result', 'en') }}">EN</a> |
                <a class="green" href="{{ route('cat-o-dog-result', 'ru') }}">RU</a> |
                <a class="green" href="{{ route('cat-o-dog-result', 'ch') }}">CH</a>
            </div>

            {{ trans('site.have_questions') }} <a href="{{ route('mysite_contacts', app()->getLocale()) }}">{{ trans('site.feedback') }}</a> <br/>
            &copy; makklays.com, 2019-<?=date('Y')?>

        </div>
    </div>

</body>
</html>
