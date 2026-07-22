<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingDroneRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'hp' => ['required', 'string', 'max:25', 'regex:/^(08|\+62)[0-9]+$/'],
            'tanggal' => ['required', 'date'],
            'lokasi' => ['required', 'string'],
            'portofolio_id' => ['nullable', 'integer'],
            'catatan' => ['nullable', 'string'],
            'dp_booking_tanggal' => ['required', 'integer'],
            'bukti_pembayaran_dp' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:10240'],
            'tipe_jadwal' => ['required', 'string', 'in:harian,jam'],
            'tanggal_selesai_acara' => ['nullable', 'required_if:tipe_jadwal,harian', 'date', 'after:tanggal'],
            'estimasi_selesai_acara' => ['nullable', 'required_if:tipe_jadwal,harian', 'string', 'max:255'],
            'waktu_mulai_acara' => ['nullable', 'required_if:tipe_jadwal,jam', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
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
            'tanggal_selesai_acara.after' => 'Tanggal selesai acara harus melebihi tanggal acara/booking.',
        ];
    }
}
