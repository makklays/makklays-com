@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <h2>{{ trans('site.Employees') }} (<?=$employees->total()?>)</h2>
            </div>
            <div class="col-md-3">
                <div class="text-right">
                    <a href="{{ route('employee_add', app()->getLocale()) }}" class="btn btn-success" >{{ trans('site.Add_new_employee') }}</a>
                </div>
            </div>
            <div class="col-md-12">

                @include('partials.flash')

                <?php if (isset($employees) && !empty($employees) && $employees->total()>0 ): ?>
                    <table class="table table-striped">
                        <thead class="">
                            <tr>
                                <th>ID</th>
                                <th>{{ trans('site.Firstname') }}</th>
                                <th>{{ trans('site.Lastname') }}</th>
                                <th>{{ trans('site.Post') }}</th>
                                <th>{{ trans('site.Company') }}</th>
                                <th>{{ trans('site.Phone') }}</th>
                                <th>{{ trans('site.Email') }}</th>
                                <th colspan="3" class="text-center">{{ trans('site.Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($employees as $employee): ?>
                                <tr>
                                    <td><?=$employee->id?></td>
                                    <td><?=$employee->firstname?></td>
                                    <td><?=$employee->lastname?></td>
                                    <td><?=(!empty($employee->post) ? $employee->post : '-')?></td>
                                    <td><a href="{{ route('company_view', ['locale' => app()->getLocale(), 'id' => $employee->company_id]) }}" class="a-green"><?=$employee->company?></a></td>
                                    <td><?=(!empty($employee->phone) ? $employee->phone : '-')?></td>
                                    <td><?=(!empty($employee->email) ? '<a href="mailto:'.$employee->email.'" class="a-green">'.$employee->email.'</a>' : '-')?></td>
                                    <td class="text-center">
                                        <a href="{{ route('employee_show', ['locale' => app()->getLocale(), 'id' => $employee->id]) }}" class="a-green"><i class="fas fa-eye"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('employee_edit', ['locale' => app()->getLocale(), 'id' => $employee->id]) }}" class="a-green"><i class="fas fa-edit"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('employee_delete', ['locale' => app()->getLocale(), 'id' => $employee->id]) }}" class="a-green" onclick="return confirm('Delete this employee (ID={{ $employee->id }})?');" ><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <?php echo $employees->links('pagination::bootstrap-4'); ?>

                <?php else: ?>
                    <div style="margin-top:50px;">
                        <i>Not employees</i>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

@endsection
