<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()?->can('admin.update') ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $permissionId = $this->route('permission');

        return [
            'name' => ['required', 'string', 'regex:/^[a-z_]+\.[a-z_]+$/', Rule::unique('permissions', 'name')->ignore($permissionId)],
            'module' => ['required', 'in:service,service_message,renewal_plan,reports,admin'],
            'action' => ['required', 'in:view,create,update,delete'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['exists:roles,id'],
        ];
    }
}

