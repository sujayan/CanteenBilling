<?php

namespace App\Http\Requests;

use App\Models\Employee;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
           
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees,email,' . $this->employee->id . ',_id',
            'employee_company_id' => 'required|string|max:255|unique:employees,employee_company_id,' . $this->employee->id . ',_id',
            'number' => 'required|string|min:10|max:10|unique:employees,number,' .$this->employee->id . ',_id',
        
        ];
    }
}
