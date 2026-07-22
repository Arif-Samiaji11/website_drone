<tr class="hover:bg-slate-50/50 transition new-row-highlight" id="row-booking_drone-{{ $b->id }}">
  <td class="px-6 py-4">
    <div class="font-bold text-slate-900">{{ $b->nama }}</div>
    <div class="text-xs text-slate-500 mt-0.5">{{ $b->email }}</div>
  </td>
  <td class="px-6 py-4 text-slate-700 font-medium">
    {{ $b->hp }}
  </td>
  <td class="px-6 py-4 text-slate-700">
    <button type="button" onclick="showMapModal('{{ addslashes($b->lokasi) }}')" class="font-medium text-slate-800 hover:text-blue-600 hover:underline transition text-left block">
      <i class="fa fa-map-marker text-red-500 mr-0.5"></i> {{ $b->lokasi }}
    </button>
    <div class="text-xs text-slate-500 mt-0.5"><i class="fa fa-calendar mr-1"></i> {{ $b->tanggal }}</div>
  </td>
  <td class="px-6 py-4 text-slate-700">
    <div class="font-bold text-slate-900">{{ $b->dp_booking_tanggal ? 'Rp ' . number_format($b->dp_booking_tanggal, 0, ',', '.') : '-' }}</div>
    @if($b->bukti_pembayaran_dp)
      <button type="button" onclick="showImageModal('{{ asset('storage/' . $b->bukti_pembayaran_dp) }}')" class="text-xs text-emerald-600 hover:underline font-semibold mt-0.5 block border-0 bg-transparent p-0 cursor-pointer">
        <i class="fa fa-image mr-0.5"></i> Lihat Bukti
      </button>
    @else
      <span class="text-xs text-slate-400">Tidak ada bukti</span>
    @endif
  </td>
  <td class="px-6 py-4">
    @if($b->portofolio_id)
      <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-200">
        ID: {{ $b->portofolio_id }}
      </span>
    @else
      <span class="text-slate-400 text-xs">-</span>
    @endif
  </td>
  <td class="px-6 py-4 text-slate-500 max-w-xs truncate" title="{{ $b->catatan }}">
    {{ $b->catatan ?? '-' }}
  </td>
  <td class="px-6 py-4 text-slate-500 text-xs">
    {{ $b->created_at->format('d M Y H:i') }}
  </td>
  <td class="px-6 py-4 text-right">
    <form action="{{ route('admin.booking-drone.destroy', $b) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data booking ini?');">
      @csrf
      @method('DELETE')
      <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 font-bold text-xs uppercase tracking-wide transition">
        Hapus
      </button>
    </form>
  </td>
</tr>
