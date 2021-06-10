@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6">

                <form action="{{ route('employee_edit_process', ['locale' => app()->getLocale(), 'id' => $employee->id]) }}" method="POST" enctype="multipart/form-data" >

                    <h2>{{ trans('site.Edit_employee') }}</h2>

                    {{ csrf_field() }}

                    <!--div class="form-group">
                        <label for="id-number" class="col-form-label">ID</label>
                        <input disabled="disabled" type="text" class="form-control" name="number" value="{{ $employee->id }}" />
                    </div-->

                    <div class="form-group">
                        <label for="id-firstname" class="col-form-label">{{ trans('site.Firstname') }}</label>
                        <input id="id-firstname" type="text" class="form-control" name="firstname" value="{{ $employee->firstname }}" />

                        <?php if ($errors->has('firstname')): ?>
                        <div style="font-size:12px; color:red;"><?=$errors->first('firstname')?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="id-lastname" class="col-form-label">{{ trans('site.Lastname') }}</label>
                        <input id="id-lastname" type="text" class="form-control" name="lastname" value="{{ $employee->lastname }}" />

                        <?php if ($errors->has('lastname')): ?>
                        <div style="font-size:12px; color:red;"><?=$errors->first('lastname')?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="id-post" class="col-form-label">{{ trans('site.Post') }}</label>
                        <input id="id-post" type="text" class="form-control" name="post" value="{{ $employee->post }}" />

                        <?php if ($errors->has('post')): ?>
                        <div style="font-size:12px; color:red;"><?=$errors->first('post')?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="id-company-id">{{ trans('site.Company') }}</label>
                        <select name="company_id" class="form-control" id="id-company-id">
                            <option>{{ trans('site.Choose_company') }}</option>
                            <?php foreach($companies as $company): ?>
                                <option value="<?=$company->id?>" {{ $employee->company_id == $company->id ? 'selected="selected"' : '' }}><?=$company->name?></option>
                            <?php endforeach; ?>
                        </select>

                        <?php if ($errors->has('company_id')): ?>
                        <div style="font-size:12px; color:red;"><?=$errors->first('company_id')?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="id-phone" class="col-form-label">{{ trans('site.Phone') }}</label>
                        <input id="id-phone" type="text" class="form-control" name="phone" value="{{ $employee->phone }}" />

                        <?php if ($errors->has('phone')): ?>
                        <div style="font-size:12px; color:red;"><?=$errors->first('phone')?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="id-email" class="col-form-label">{{ trans('site.Email') }}</label>
                        <input id="id-email" type="email" class="form-control" name="email" value="{{ $employee->email }}" />

                        <?php if ($errors->has('email')): ?>
                        <div style="font-size:12px; color:red;"><?=$errors->first('email')?></div>
                        <?php endif; ?>
                    </div>

                    <!--div class="form-group">
                        <label class="col-form-label">{{ trans('site.Created_at') }}</label>
                        <input disabled="disabled" type="text" class="form-control" value="{{ $employee->created_at }}" />
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">{{ trans('site.Updated_at') }}</label>
                        <input disabled="disabled" type="text" class="form-control" value="{{ $employee->updated_at }}" />
                    </div-->

                    <a href="{{ route('employees', app()->getLocale()) }}" class="btn btn-secondary" style="margin-right:20px;" >{{ trans('site.Cancel') }}</a>
                    <input type="submit" value="{{ trans('site.Save') }}" class="btn btn-success" />
                </form>

            </div>
        </div>
    </div>

@endsection
