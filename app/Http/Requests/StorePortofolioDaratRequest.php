<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePortofolioDaratRequest extends FormRequest
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

            // Cover thumbnail upload saja
            'cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120', // 5MB

            // Link YouTube (biar fleksibel, cukup string. Validasi bisa dibuat stricter kalau mau)
            'youtube_url' => 'nullable|string|max:255',
        ];
    }
}
