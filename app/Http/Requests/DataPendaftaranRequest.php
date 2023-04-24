<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataPendaftaranRequest extends FormRequest
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
            'id_data_user' => 'required|integer',
            'id_data_kegiatan' => 'required|integer',
            'provinsi' => 'required|string|max:255',
            'kabupaten_kota' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
        ];
    }
}