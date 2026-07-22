<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminSetting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function edit()
    {
        // Default Jakarta coordinates if no setting row exists
        $setting = AdminSetting::firstOrCreate(['id' => 1], [
            'no_rekening' => '[]',
            'latitude' => '-6.2088',
            'longitude' => '106.8456',
            'alamat_detail' => '-'
        ]);

        // Decode accounts array
        $accounts = json_decode($setting->no_rekening, true);
        if (!is_array($accounts)) {
            $accounts = [];
            if (!empty($setting->no_rekening) && $setting->no_rekening !== '-') {
                $accounts[] = [
                    'type' => 'bank',
                    'provider' => 'Lainnya',
                    'number' => $setting->no_rekening
                ];
            }
        }

        return view('admin.setting.edit', compact('setting', 'accounts'));
    }

    public function update(Request $request)
    {
        // Process dynamic list of payment accounts
        $types = $request->input('payment_type', []);
        $providers = $request->input('payment_provider', []);
        $numbers = $request->input('payment_number', []);

        $accounts = [];
        for ($i = 0; $i < count($types); $i++) {
            if (!empty($numbers[$i])) {
                $accounts[] = [
                    'type' => $types[$i],
                    'provider' => $providers[$i],
                    'number' => $numbers[$i]
                ];
            }
        }

        $no_rekening_json = json_encode($accounts);

        $request->validate([
            'latitude' => 'required|string|max:50',
            'longitude' => 'required|string|max:50',
            'alamat_detail' => 'nullable|string'
        ]);

        $setting = AdminSetting::firstOrCreate(['id' => 1]);
        $setting->update([
            'no_rekening' => $no_rekening_json,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'alamat_detail' => $request->alamat_detail,
        ]);

        return redirect()->route('admin.setting.edit')
            ->with('success', 'Pengaturan lokasi & Akun Rekening berhasil diperbarui.');
    }
}
