@extends('layouts.app')

@section('title', 'Peta Realtime | GMCI Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 mb-6 gap-4 transition-colors">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">🗺️ Peta Ambulans (Realtime)</h1>
            <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">Gunakan unit panel di kiri untuk fokus ke lokasi</p>
        </div>
        
        <div class="flex items-center gap-3 bg-slate-50 dark:bg-gray-700 px-3 py-1.5 rounded-full border border-slate-200 dark:border-gray-600 w-full sm:w-auto justify-center transition-colors">
            <div class="flex items-center gap-2">
                <div class="w-2.5 h-2.5 bg-green-500 rounded-full animate-pulse shadow-[0_0_8px_rgba(34,197,94,0.6)]"></div>
                <span class="text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Live</span>
            </div>
            <div class="w-px h-4 bg-gray-300 dark:bg-gray-600"></div>
            <span class="text-sm font-medium text-gray-600 dark:text-gray-300">
                Refresh: <span id="refresh-timer" class="font-mono font-bold text-emerald-600 dark:text-emerald-400">10</span>s
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Sidebar: Driver List -->
        <div class="lg:col-span-1 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col h-[300px] sm:h-[400px] lg:h-[600px] transition-colors">
            <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                <h2 class="font-bold text-gray-700 dark:text-gray-200 flex items-center gap-2">
                    🚑 Unit Aktif (<span id="active-count">0</span>)
                </h2>
            </div>
            <div id="ambulance-list" class="flex-1 overflow-y-auto p-2 space-y-2">
                <div class="p-8 text-center text-gray-400 dark:text-gray-500">
                    <p class="text-sm">Memuat data unit...</p>
                </div>
            </div>
        </div>

        <!-- Map -->
        <div class="lg:col-span-3">
            <div id="map" class="h-[400px] sm:h-[500px] lg:h-[600px] rounded-xl shadow border border-gray-100 dark:border-gray-700 overflow-hidden transition-colors"></div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
const map = L.map('map').setView([-6.200000, 106.816666], 11);

const thunderforestKey = '{{ env('THUNDERFOREST_API_KEY', '') }}'.trim();

const tileUrls = {
    dark: thunderforestKey
        ? `https://{s}.tile.thunderforest.com/transport-dark/{z}/{x}/{y}.png?apikey=${thunderforestKey}`
        : 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png',
    light: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'
};

const attributions = {
    dark: thunderforestKey ? '© Thunderforest, © OpenStreetMap' : '© CartoDB, © OpenStreetMap',
    light: '© OpenStreetMap contributors'
};

const isDarkMode = () => document.documentElement.classList.contains('dark');

let tileLayer = L.tileLayer(isDarkMode() ? tileUrls.dark : tileUrls.light, {
    attribution: isDarkMode() ? attributions.dark : attributions.light,
    maxZoom: 19
}).addTo(map);

new MutationObserver(() => {
    const dark = isDarkMode();
    const nextUrl = dark ? tileUrls.dark : tileUrls.light;
    if (tileLayer._url !== nextUrl) {
        map.removeLayer(tileLayer);
        tileLayer = L.tileLayer(nextUrl, {
            attribution: dark ? attributions.dark : attributions.light,
            maxZoom: 19
        }).addTo(map);
    }
}).observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });

let markers = {};

function focusAmbulance(id) {
    const marker = markers[id];
    if (marker) {
        map.flyTo(marker.getLatLng(), 15, {
            duration: 1.5
        });
        marker.openPopup();
    }
}

function updateAmbulances() {
    fetch('/admin/maps/ambulances')
        .then(response => response.json())
        .then(ambulances => {
            const listContainer = document.getElementById('ambulance-list');
            document.getElementById('active-count').textContent = ambulances.length;
            
            if (ambulances.length === 0) {
                listContainer.innerHTML = '<div class="p-8 text-center text-gray-400 dark:text-gray-500 text-sm">Tidak ada unit aktif</div>';
            } else {
                listContainer.innerHTML = '';
            }

            // Remove markers for ambulances that are no longer active
            Object.keys(markers).forEach(id => {
                if (!ambulances.find(a => a.id == id)) {
                    map.removeLayer(markers[id]);
                    delete markers[id];
                }
            });

            // Update or create markers
            ambulances.forEach(ambulance => {
                // Populate Sidebar List
                const listItem = document.createElement('div');
                listItem.className = 'p-3 rounded-lg border border-gray-100 dark:border-gray-700 hover:bg-slate-50 dark:hover:bg-gray-700 transition cursor-pointer group';
                listItem.onclick = () => focusAmbulance(ambulance.id);
                
                listItem.innerHTML = `
                    <div class="flex justify-between items-start mb-1">
                        <div class="flex flex-col">
                            <span class="font-bold text-gray-800 dark:text-gray-100">${ambulance.plate_number}</span>
                            ${ambulance.dispatch && ambulance.dispatch.is_paused ? 
                                '<span class="text-[9px] font-bold text-yellow-600 dark:text-yellow-400 animate-pulse">⏸️ SEDANG ISTIRAHAT</span>' : ''}
                        </div>
                        <span class="text-[10px] px-1.5 py-0.5 rounded font-bold uppercase ${ambulance.status === 'ready' ? 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200' : 'bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200'}">
                            ${ambulance.status}
                        </span>
                    </div>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400 mb-2">${ambulance.code} • ${ambulance.type}</p>
                    <button class="w-full py-1.5 bg-indigo-50 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-200 text-xs font-bold rounded hover:bg-indigo-600 dark:hover:bg-indigo-700 hover:text-white transition">
                        Fokus Lokasi
                    </button>
                `;
                listContainer.appendChild(listItem);

                const popupContent = `
                    <div class="p-2 min-w-[200px]">
                        <div class="flex justify-between items-start border-b pb-2 mb-2">
                             <div>
                                <h3 class="font-bold text-lg leading-tight">🚑 ${ambulance.plate_number}</h3>
                                <p class="text-[11px] text-gray-500">${ambulance.code} - ${ambulance.type}</p>
                             </div>
                             ${ambulance.dispatch && ambulance.dispatch.is_paused ? 
                                '<div class="bg-yellow-100 text-yellow-800 text-[10px] font-bold px-2 py-0.5 rounded border border-yellow-200 animate-pulse">PAUSED</div>' : ''}
                        </div>
                        
                        ${ambulance.dispatch ? `
                            <p class="text-sm"><strong>Pasien:</strong> ${ambulance.dispatch.patient_name}</p>
                            <p class="text-sm"><strong>Status:</strong> ${ambulance.dispatch.status.replace(/_/g, ' ')}</p>
                            <p class="text-sm line-clamp-2"><strong>Jemput:</strong> ${ambulance.dispatch.pickup_address}</p>
                            <p class="text-sm line-clamp-2"><strong>Tujuan:</strong> ${ambulance.dispatch.destination ?? '-'}</p>
                        ` : '<p class="text-sm text-gray-500 mt-2">Tidak ada dispatch aktif</p>'}
                        ${ambulance.last_update ? `<p class="text-[10px] text-gray-400 mt-2 border-t pt-1">Update: ${ambulance.last_update}</p>` : ''}
                    </div>
                `;

                if (markers[ambulance.id]) {
                    // Update existing marker
                    markers[ambulance.id].setLatLng([ambulance.latitude, ambulance.longitude]);
                    markers[ambulance.id].setPopupContent(popupContent);
                } else {
                    // Create new marker
                    markers[ambulance.id] = L.marker([ambulance.latitude, ambulance.longitude])
                        .addTo(map)
                        .bindPopup(popupContent);
                }
            });
        })
        .catch(error => console.error('Error fetching ambulances:', error));
}

// Initial load
updateAmbulances();

// Auto-refresh every 10 seconds
let countdown = 10;
setInterval(() => {
    countdown--;
    document.getElementById('refresh-timer').textContent = countdown;
    
    if (countdown === 0) {
        updateAmbulances();
        countdown = 10;
    }
}, 1000);
</script>
@endsection
