<tr class="hover:bg-slate-50/50 transition new-row-highlight" id="row-booking_crew-{{ $b->id }}">
  <td class="px-6 py-4">
    <div class="font-bold text-slate-900">{{ $b->nama }}</div>
    <div class="text-xs text-slate-500 mt-0.5">{{ $b->email }}</div>
  </td>
  <td class="px-6 py-4 text-slate-700 font-medium">
    {{ $b->hp }}
  </td>
  <td class="px-6 py-4 text-slate-700">
    <div class="font-bold text-slate-900 uppercase">{{ $b->layanan }}</div>
    <div class="text-xs text-blue-600 font-semibold mt-0.5 uppercase tracking-wide">Kode Paket: {{ $b->paket }}</div>
  </td>
  <td class="px-6 py-4 text-slate-700">
    <div class="font-semibold text-slate-900">{{ $b->tanggal ? \Carbon\Carbon::parse($b->tanggal)->format('d M Y') : '-' }}</div>
    @if($b->lokasi)
      <button type="button" onclick="showMapModal('{{ addslashes($b->lokasi) }}')" class="text-xs text-slate-500 hover:text-blue-600 hover:underline transition text-left block max-w-[200px] truncate mt-0.5" title="{{ $b->lokasi }}">
        <i class="fa fa-map-marker text-red-500 mr-0.5"></i> {{ $b->lokasi }}
      </button>
    @else
      <span class="text-xs text-slate-400 mt-0.5 block">-</span>
    @endif
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
  <td class="px-6 py-4 text-slate-500 text-xs">
    {{ $b->created_at->format('d M Y H:i') }}
  </td>
  <td class="px-6 py-4 text-right">
    <form action="{{ route('admin.booking-crews.destroy', $b) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data booking crews ini?');">
      @csrf
      @method('DELETE')
      <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 font-bold text-xs uppercase tracking-wide transition">
        Hapus
      </button>
    </form>
  </td>
</tr>
