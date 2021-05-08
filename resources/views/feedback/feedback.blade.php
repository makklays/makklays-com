@extends('layouts.main10')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('/', app()->getLocale()) }}" class="a-green"><i class="fa fa-home" aria-hidden="true"></i></a></li>
            <li class="breadcrumb-item" aria-current="page">{{ trans('site.Feedback') }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12">
            <br/><h1 class="text-center text-design2">{{ trans('site.Feedback') }}</h1> <br/>
        </div>
        <div class="col-md-12">

            @include('partials.flash')

            <form action="{{ route('feedback_post', app()->getLocale()) }}" method="post" >

                {{ csrf_field() }}

                <div class="form-group">
                    <input name="name" type="text" value="{{ old('name') }}" class="form-control" placeholder="{{ trans('site.Name') }}" />

                    <?php if ($errors->has('name')): ?>
                    <div class="text-left invalid-price_min" role="alert" style="font-size:12px; color:#88251d;"><?=$errors->first('name')?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group" >
                    <input name="email" type="email" value="{{ old('email') }}" class="form-control" placeholder="{{ trans('site.Email') }}" />

                    <?php if ($errors->has('email')): ?>
                    <div class="text-left invalid-price_min" role="alert" style="font-size:12px; color:#88251d;"><?=$errors->first('email')?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <textarea name="message" rows="10" class="form-control" placeholder="{{ trans('site.your_message') }}">{{ old('message') }}</textarea>

                    <?php if ($errors->has('message')): ?>
                    <div class="text-left invalid-price_min" role="alert" style="font-size:12px; color:#88251d;"><?=$errors->first('message')?></div>
                    <?php endif; ?>
                </div>

                <input id="id-submit-feedback" type="submit" class="btn btn-secondary text-center btn-lg" value="{{ trans('site.Sent') }}" />
            </form>
        </div>
    </div>

@endsection
