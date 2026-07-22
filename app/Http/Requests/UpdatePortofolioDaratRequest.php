<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePortofolioDaratRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'nullable|string|max:255',
            'tanggal' => 'nullable|date',

            // Cover optional saat update (kalau tidak upload, cover lama tetap)
            'cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

            'youtube_url' => 'nullable|string|max:255',
        ];
    }
}
