<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataPenilaianRequest extends FormRequest
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
    public function rules()
    {
        return [
            'id_data_alternatif' => 'required',
            'id_data_kriteria' => 'required',
            'nilai' => 'required'
        ];
    }
}
