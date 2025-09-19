<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class userRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $form = $this->input('form_type');
        switch ($form) {
            case "course":
                return [
                    'title' => 'required|string|max:150',
                    'category' => 'required|string|max:50',
                    'description' => 'nullable|string|max:255',
                    'modules' => 'required|array|min:1',
                    'module.*.title' => 'required|string|max:50',
                    'module.*.description' => 'required|string',
                    'module.*.contents' => 'nullable|array',
                    'module.*.contents.*.title' => 'nullable|string|',
                    'module.*.contents.*.type' =>'nullable|string|in:text,image,video,link',
                    'module.*contents.*.body' =>'nullable|string',
                ];
                break;

            default:
                return [];
        }
    }
}
