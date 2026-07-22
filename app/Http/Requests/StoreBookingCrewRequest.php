<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookingCrewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // sesuai pilihan dari modal
            'layanan' => ['required', Rule::in(['photographer', 'videographer', 'drone'])],
            'paket'   => ['required', 'string', 'max:100'],

            // input user
            'nama'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'hp'    => ['required', 'string', 'max:25', 'regex:/^(08|\+62)[0-9]+$/'],
            'lokasi' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
            'catatan' => ['nullable', 'string'],
            'portofolio_id' => ['nullable', 'integer'],
            'dp_booking_tanggal' => ['required', 'integer'],
            'bukti_pembayaran_dp' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'layanan.required' => 'Layanan wajib dipilih.',
            'layanan.in' => 'Layanan tidak valid.',
            'paket.required' => 'Paket wajib dipilih.',
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'hp.required' => 'No HP wajib diisi.',
            'hp.regex' => 'Nomor HP harus diawali dengan 08 atau +62 dan hanya boleh berisi angka.',
            'lokasi.required' => 'Lokasi wajib diisi.',
            'tanggal.required' => 'Tanggal booking wajib dipilih.',
            'dp_booking_tanggal.required' => 'DP Booking Tanggal wajib dihitung.',
            'bukti_pembayaran_dp.required' => 'Bukti pembayaran DP wajib diunggah.',
            'bukti_pembayaran_dp.image' => 'Bukti pembayaran harus berupa gambar.',
            'bukti_pembayaran_dp.mimes' => 'Format gambar harus jpeg, png, jpg, gif, svg, atau webp.',
            'bukti_pembayaran_dp.max' => 'Ukuran gambar bukti pembayaran maksimal 10MB.',
        ];
    }
}
