<?php

namespace App\Http\Controllers;

use App\Http\Requests\saveEmployeeRequest;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EmployeesController extends Controller
{
    public function __constructor()
    {
        // Only loggined
        if (!Auth::check()) return redirect('/');
    }

    //
    public function index()
    {
        $employees = Employee::query()
            ->orderBy('firstname')
            ->orderBy('lastname')
            ->paginate(10);

        if (isset($employees) && !empty($employees)) {
            foreach ($employees as $k => &$emp) {
                // add Name of company
                if (isset($emp->company_id) && !empty($emp->company_id)) {
                    $company = Company::query()->where(['id' => $emp->company_id])->first();
                    $emp->company = $company->name;
                } else {
                    $emp->company = '';
                }
            }
        }

        return view('adminka.employees.index', [
            'employees' => $employees,
        ]);
    }

    //
    public function add()
    {
        // list of companies
        $companies = Company::all();

        return view('adminka.employees.add', [
            'companies' => $companies
        ]);
    }

    //
    public function add_process(saveEmployeeRequest $request)
    {
        Employee::create([
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'post' => $request->post,
            'company_id' => $request->company_id,
            'phone' => !empty($request->phone) ? $request->phone : null,
            'email' => !empty($request->email) ? $request->email : null,
        ]);

        return redirect( route('employees', app()->getLocale() ))->with([
            'flash_message' => trans('site.Data_employee_was_add', ['firstname' => $request->firstname, 'lastname' => $request->lastname]),
            'flash_type' => 'success'
        ]);
    }

    //
    public function edit(Request $request, $lang, $id)
    {
        if (!isset($id) || !empty($id)) redirect( route('employees', app()->getLocale()) );

        // get companies
        $companies = Company::all();
        // get employee
        $employee = Employee::query()->where(['id' => $id])->first();

        return view('adminka.employees.edit', [
            'employee' => $employee,
            'companies' => $companies
        ]);
    }

    //
    public function edit_process(saveEmployeeRequest $request)
    {
        if (!isset($request->id) || empty($request->id)) redirect( route('employees', app()->getLocale()) );

        $employee = Employee::query()->where(['id' => $request->id])->first();
        $employee->lastname = $request->lastname;
        $employee->firstname = $request->firstname;
        $employee->post = $request->post;
        $employee->company_id = $request->company_id;
        $employee->phone = $request->phone;
        $employee->email = $request->email;
        $employee->save();

        return redirect( route('employees', [app()->getLocale(), 'id' => $request->id]) )->with([
            'flash_message' => trans('site.Data_employee_was_update', ['firstname' => $request->firstname, 'lastname' => $request->lastname]),
            'flash_type' => 'success'
        ]);
    }

    //
    public function delete($lang, $id)
    {
        if (!isset($id) || empty($id)) {
            return redirect( route('employees', app()->getLocale()) )->with([
                'flash_message' => 'Error! Don\'t have ID in url',
                'flash_type' => 'danger'
            ]);
        }

        // get employee
        //$employee = DB::selectOne('SELECT * FROM employees WHERE id = ?', [$id]);
        $employee = Employee::query()->where(['id' => $id])->firstOrFail();

        // delete employee
        if (isset($employee) && !empty($employee)) {
            // delete empoyee
            //DB::delete('DELETE FROM employees WHERE id = ?', [$id]);
            Employee::query()->where(['id' => $id])->delete();

            return redirect( route('employees', app()->getLocale()) )->with([
                'flash_message' => trans('site.Data_employee_was_delete', ['firstname' => $employee->firstname, 'lastname' => $employee->lastname]),
                'flash_type' => 'success'
            ]);

        } else {
            return redirect( route('employees', app()->getLocale()) )->with([
                'flash_message' => 'Error! Employee don\'t exists!',
                'flash_type' => 'danger'
            ]);
        }
    }

    //
    public function show(Request $request, $locale, $id)
    {
        $employee = Employee::query()->where(['id' => $id])->firstOrFail();

        return view('adminka.employees.show', [
            'employee' => $employee
        ]);
    }
}
