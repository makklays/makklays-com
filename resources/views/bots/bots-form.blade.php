@extends('layouts.main10')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('/', app()->getLocale()) }}" class="a-green"><i class="fa fa-home" aria-hidden="true"></i></a></li>
            <li class="breadcrumb-item" aria-current="page">{{ trans('bots.Send_to_tele') }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12">
            <br/><h1 class="text-center text-design2">{{ trans('bots.Send_to_tele') }}</h1> <br/>
        </div>
        <div class="col-md-12">

            <form action="{{ route('bots-post', app()->getLocale()) }}" method="post" >

                {{ csrf_field() }}

                <div class="form-group">
                    <textarea name="msg" rows="12" class="form-control">{{ old('msg') }}</textarea>

                    <?php if ($errors->has('msg')): ?>
                        <div class="text-left invalid-price_min" role="alert" style="font-size:12px; color:#88251d;"><?=$errors->first('msg')?></div>
                    <?php endif; ?>
                </div>

                <input id="id-submit-bots" type="submit" class="btn btn-secondary text-center btn-lg" value="{{ trans('site.Sent') }}" />

            </form>

        </div>
    </div>
@endsection
