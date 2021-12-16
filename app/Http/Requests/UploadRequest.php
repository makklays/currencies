<?php
/**
 * Date: 15.12.2021
 * Author: Alexander Kuziv
 * Email: alexander@makklays.com.ua
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'file_courses' => 'required|file|max:20000|mimetypes:text/plain', // 20 Mb
        ];
    }
}
