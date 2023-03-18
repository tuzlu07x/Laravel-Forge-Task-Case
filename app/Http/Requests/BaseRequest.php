<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    final public function rules()
    {
        $commonRules = $this->commonRules();
        if ($this->isMethod('PUT')) {
            $mergeRules = $this->updateRules();
        } else {
            $mergeRules = $this->storeRules();
        }
        return array_merge($commonRules, $mergeRules);
    }
}
