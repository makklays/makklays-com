@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <h2>{{ trans('site.Data_employee') }} / {{ $employee->firstname . ' ' . $employee->lastname }}</h2>
            </div>
            <div class="col-md-3">

                <div class="text-right">
                    <a href="{{ route('employee_add', app()->getLocale()) }}" class="btn btn-success" >{{ trans('site.Add_new_employee') }}</a>
                </div>
            </div>
            <div class="col-md-6">

                @include('partials.flash')

                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th scope="row">ID</th>
                            <td>{{ $employee->id }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ trans('site.Firstname') }}</th>
                            <td>{{ $employee->firstname }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ trans('site.Lastname') }}</th>
                            <td>{{ $employee->lastname }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ trans('site.Post') }}</th>
                            <td>{{ $employee->post }}</td>
                        </tr>
                        <tr>
                            <th scope="row">{{ trans('site.Company') }}</th>
                            <td>
                                <a href="{{ route('company_view', ['locale' => app()->getLocale(), 'id' => $employee->company_id]) }}" class="a-green"><?=$employee->company->name?></a>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">{{ trans('site.Phone') }}</th>
                            <td>
                                {{ $employee->phone }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">{{ trans('site.Email') }}</th>
                            <td><a href="mailto:{{ $employee->email }}" class="a-green">{{ $employee->email }}</a></td>
                        </tr>
                        <tr>
                            <th scope="row">Created at</th>
                            <td>{{ $employee->created_at }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Updated at</th>
                            <td>{{ $employee->updated_at }}</td>
                        </tr>
                    </tbody>
                </table>

                <a href="{{ route('employees', app()->getLocale()) }}" class="btn btn-secondary" style="margin-right:20px;" >{{ trans('site.Cancel') }}</a>

            </div>
        </div>
    </div>

@endsection
