<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300 uppercase text-[10px] font-black tracking-widest border-b border-gray-100 dark:border-gray-700">
                <tr>
                    <th class="px-6 py-4 text-left">Pasien</th>
                    <th class="px-6 py-4 text-left">Ambulans / Driver</th>
                    <th class="px-6 py-4 text-left">Waktu</th>
                    <th class="px-6 py-4 text-left">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                @forelse($dispatches as $d)
                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 dark:text-gray-100">{{ $d->patient_name }}</div>
                        <div class="text-[10px] @if($d->patient_condition === 'emergency') text-red-600 dark:text-red-300 @else text-gray-500 dark:text-gray-400 @endif font-bold uppercase tracking-tighter">
                            {{ $d->patient_condition }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2 mb-0.5">
                            <span class="text-xs font-bold text-gray-800 dark:text-gray-100">{{ $d->ambulance?->plate_number ?? '-' }}</span>
                        </div>
                        <div class="text-[10px] text-gray-500 dark:text-gray-400 italic">{{ $d->driver?->name ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-xs text-gray-700 dark:text-gray-200 font-medium">{{ $d->created_at->format('H:i') }}</div>
                        <div class="text-[10px] text-gray-400 dark:text-gray-400">{{ $d->created_at->format('d M Y') }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider
                            @if($d->status === 'completed') bg-emerald-50 dark:bg-emerald-900 text-emerald-700 dark:text-emerald-200
                            @elseif($d->status === 'assigned') bg-blue-50 dark:bg-blue-900 text-blue-700 dark:text-blue-200
                            @else bg-amber-50 dark:bg-amber-900 text-amber-700 dark:text-amber-200 @endif">
                            {{ str_replace('_', ' ', $d->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-gray-400 italic text-sm">
                        Tidak ada data dispatch untuk periode ini
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
