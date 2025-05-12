<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DestroyPostRequest extends FormRequest
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
        return [
            'id' => [
                'required',
                Rule::exists(Post::class, 'id')->where(function ($query) {
                    $query->where('ip_address', $this->ip())
                        ->where('created_at', '>=', now()->subMinutes(5)); // Allows deletion only within 5 minutes of creation
                }),
            ]
        ];
    }
}
