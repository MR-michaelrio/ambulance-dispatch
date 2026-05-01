<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Real-Time - GMCI Ambulance</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' };
        try {
            if (localStorage.getItem('darkMode') === 'true') {
                document.documentElement.classList.add('dark');
            }
        } catch (e) {}
    </script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
        }
        html { color-scheme: light; }
        html.dark { color-scheme: dark; }
        #map {
            height: 100%;
        }
        /* Mobile height adjustments */
        .data-table {
            max-height: 40vh;
            overflow-y: auto;
        }
        @media (min-width: 1024px) {
            .data-table {
                max-height: calc(50vh - 80px);
            }
        }
        .data-table::-webkit-scrollbar {
            width: 6px;
        }
        .data-table::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        html.dark .data-table::-webkit-scrollbar-thumb {
            background: #475569;
        }

        /* Leaflet popup theming */
        html:not(.dark) .leaflet-control,
        html:not(.dark) .leaflet-popup-content,
        html:not(.dark) .leaflet-popup-content-wrapper,
        html:not(.dark) .leaflet-popup-tip {
            background: rgba(255,255,255,0.95) !important;
            color: #111827 !important;
        }
        html.dark .leaflet-control,
        html.dark .leaflet-popup-content,
        html.dark .leaflet-popup-content-wrapper,
        html.dark .leaflet-popup-tip {
            background: rgba(15,23,42,0.92) !important;
            color: #f8fafc !important;
        }
        html.dark .leaflet-popup-content a,
        html.dark .leaflet-control a {
            color: #f8fafc !important;
        }

        /* Zoom control buttons (+/-) */
        html.dark .leaflet-bar a,
        html.dark .leaflet-bar a:hover {
            background-color: #1f2937 !important;
            color: #f8fafc !important;
            border-bottom-color: #374151 !important;
        }
        html.dark .leaflet-bar a:hover {
            background-color: #374151 !important;
        }
        html.dark .leaflet-bar a.leaflet-disabled {
            background-color: #111827 !important;
            color: #6b7280 !important;
        }

        body, .data-table, [class*="bg-"], [class*="border-"], [class*="text-"] {
            transition: background-color 0.25s ease, border-color 0.25s ease, color 0.25s ease;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 flex flex-col h-screen overflow-hidden">

<!-- Header -->
<div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700 px-4 py-3 flex items-center justify-between gap-4 flex-shrink-0">
    <div class="flex items-center gap-3">
        <a href="/portal" class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-800 dark:hover:text-emerald-300 font-bold flex items-center gap-1">
            <span class="text-lg">←</span> <span class="hidden sm:inline">Portal</span>
        </a>
        <div class="h-6 w-px bg-gray-300 dark:bg-gray-600"></div>
        <h1 class="text-lg font-extrabold text-gray-800 dark:text-gray-100 truncate">🗺️ Monitoring</h1>
    </div>
    <div class="flex items-center gap-3">
        <div class="flex items-center gap-3 bg-slate-50 dark:bg-gray-700 px-3 py-1.5 rounded-full border border-slate-200 dark:border-gray-600">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse shadow-[0_0_8px_rgba(34,197,94,0.6)]"></div>
                <span class="text-[10px] font-black text-gray-700 dark:text-gray-200 uppercase tracking-tighter">Live</span>
            </div>
            <div class="w-px h-3 bg-gray-300 dark:bg-gray-600"></div>
            <span class="text-xs font-bold text-gray-600 dark:text-gray-300">
                <span id="countdown" class="font-mono font-black text-emerald-600 dark:text-emerald-400">10</span>s
            </span>
        </div>
        <button
            id="dark-mode-toggle"
            type="button"
            class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 transition-all duration-300 transform hover:scale-110"
            title="Toggle Dark Mode">
            <span id="dark-mode-icon" class="block text-xl">🌙</span>
            <span id="light-mode-icon" class="hidden text-xl">☀️</span>
        </button>
    </div>
</div>

<!-- Main Content -->
<div class="flex flex-col lg:flex-row flex-1 overflow-hidden">
    
    <!-- Map Section (Top on mobile, 60% on desktop) -->
    <div class="h-[40vh] lg:h-full lg:w-3/5 relative border-b border-gray-200 dark:border-gray-700 lg:border-b-0">
        <div id="map"></div>
    </div>

    <!-- Data Section (Bottom on mobile, 40% on desktop) -->
    <div class="flex-1 lg:w-2/5 bg-white dark:bg-gray-800 lg:border-l border-gray-200 dark:border-gray-700 flex flex-col overflow-y-auto lg:overflow-hidden">

        <!-- Active Dispatches -->
        <div class="flex-1 flex flex-col min-h-[300px] lg:min-h-0 border-b border-gray-200 dark:border-gray-700">
            <div class="bg-blue-50 dark:bg-gray-700 px-4 py-3 border-b border-gray-200 dark:border-gray-600 flex justify-between items-center sticky top-0 z-10">
                <h2 class="font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    🚨 Dispatch Aktif
                </h2>
                <span id="dispatch-count" class="text-xs font-black bg-blue-600 text-white px-2 py-0.5 rounded-full shadow-sm">0</span>
            </div>
            <div class="data-table p-4 flex-1">
                <div id="dispatches-list" class="space-y-3">
                    <p class="text-gray-400 dark:text-gray-500 text-sm text-center py-8">Memuat data...</p>
                </div>
            </div>
        </div>

        <!-- Patient Requests -->
        <div class="flex-1 flex flex-col min-h-[300px] lg:min-h-0">
            <div class="bg-green-50 dark:bg-gray-700 px-4 py-3 border-b border-gray-200 dark:border-gray-600 flex justify-between items-center sticky top-0 z-10">
                <h2 class="font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    📋 Permintaan Pasien
                </h2>
                <span id="request-count" class="text-xs font-black bg-green-600 text-white px-2 py-0.5 rounded-full shadow-sm">0</span>
            </div>
            <div class="data-table p-4 flex-1">
                <div id="requests-list" class="space-y-3">
                    <p class="text-gray-400 dark:text-gray-500 text-sm text-center py-8">Memuat data...</p>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
// Initialize map
const map = L.map('map').setView([-6.200000, 106.816666], 11);

const thunderforestKey = '<?php echo e(env('THUNDERFOREST_API_KEY', '')); ?>'.trim();

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
    attribution: isDarkMode() ? attributions.dark : attributions.light
}).addTo(map);

new MutationObserver(() => {
    const dark = isDarkMode();
    const nextUrl = dark ? tileUrls.dark : tileUrls.light;
    if (tileLayer._url !== nextUrl) {
        map.removeLayer(tileLayer);
        tileLayer = L.tileLayer(nextUrl, {
            attribution: dark ? attributions.dark : attributions.light
        }).addTo(map);
    }
}).observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });

let markers = {};

// Status badges
const statusBadges = {
    'assigned': '<span class="text-xs bg-yellow-100 dark:bg-yellow-900/40 text-yellow-800 dark:text-yellow-200 px-2 py-1 rounded">Ditugaskan</span>',
    'enroute_pickup': '<span class="text-xs bg-blue-100 dark:bg-blue-900/40 text-blue-800 dark:text-blue-200 px-2 py-1 rounded">Menuju Lokasi</span>',
    'on_scene': '<span class="text-xs bg-purple-100 dark:bg-purple-900/40 text-purple-800 dark:text-purple-200 px-2 py-1 rounded">Di Lokasi</span>',
    'enroute_destination': '<span class="text-xs bg-orange-100 dark:bg-orange-900/40 text-orange-800 dark:text-orange-200 px-2 py-1 rounded">Menuju Tujuan</span>',
    'arrived_destination': '<span class="text-xs bg-emerald-100 dark:bg-emerald-900/40 text-emerald-800 dark:text-emerald-200 px-2 py-1 rounded">Sampai Tujuan</span>',
    'completed': '<span class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">Selesai</span>',
    'pending': '<span class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">Pending</span>',
    'dispatched': '<span class="text-xs bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-200 px-2 py-1 rounded">Dispatched</span>',
};

function updateData() {
    fetch('/monitoring/data')
        .then(response => response.json())
        .then(data => {
            updateMap(data.ambulances);
            updateDispatches(data.dispatches);
            updateRequests(data.requests);
        })
        .catch(error => console.error('Error:', error));
}

function updateMap(ambulances) {
    // Remove old markers
    Object.keys(markers).forEach(id => {
        if (!ambulances.find(a => a.id == id)) {
            map.removeLayer(markers[id]);
            delete markers[id];
        }
    });

    // Update/create markers
    ambulances.forEach(ambulance => {
        const popupContent = `
            <div class="p-2">
                <h3 class="font-bold text-lg">🚑 ${ambulance.plate_number}</h3>
                <p class="text-sm text-gray-600">${ambulance.code || '-'} - ${ambulance.type || '-'}</p>
                <p class="text-sm mt-1"><strong>Status:</strong> ${ambulance.status}</p>
                ${ambulance.dispatch ? `
                    <hr class="my-2">
                    <p class="text-sm"><strong>Pasien:</strong> ${ambulance.dispatch.patient_name}</p>
                    <p class="text-sm">${statusBadges[ambulance.dispatch.status] || ambulance.dispatch.status}</p>
                ` : '<p class="text-sm text-gray-500 mt-2">Tidak ada dispatch aktif</p>'}
                ${ambulance.last_update ? `<p class="text-xs text-gray-400 mt-2">${ambulance.last_update}</p>` : ''}
            </div>
        `;

        if (markers[ambulance.id]) {
            markers[ambulance.id].setLatLng([ambulance.latitude, ambulance.longitude]);
            markers[ambulance.id].setPopupContent(popupContent);
        } else {
            markers[ambulance.id] = L.marker([ambulance.latitude, ambulance.longitude])
                .addTo(map)
                .bindPopup(popupContent);
        }
    });
}

function updateDispatches(dispatches) {
    const container = document.getElementById('dispatches-list');
    document.getElementById('dispatch-count').textContent = dispatches.length;

    if (dispatches.length === 0) {
        container.innerHTML = '<p class="text-gray-400 dark:text-gray-500 text-sm text-center py-8">Tidak ada dispatch aktif</p>';
        return;
    }

    container.innerHTML = dispatches.map(d => `
        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
            <div class="flex justify-between items-start mb-2">
                <div class="font-semibold text-gray-800 dark:text-gray-100">${d.patient_name}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">${d.created_at}</div>
            </div>
            <div class="text-sm text-gray-600 dark:text-gray-300 mb-2">
                🚑 ${d.ambulance}
            </div>
            <div class="flex justify-between items-center">
                ${statusBadges[d.status] || d.status}
                ${d.patient_condition ? `<span class="text-xs text-red-600 dark:text-red-400 font-semibold">${d.patient_condition}</span>` : ''}
            </div>
        </div>
    `).join('');
}

function updateRequests(requests) {
    const container = document.getElementById('requests-list');
    document.getElementById('request-count').textContent = requests.length;

    if (requests.length === 0) {
        container.innerHTML = '<p class="text-gray-400 dark:text-gray-500 text-sm text-center py-8">Tidak ada permintaan</p>';
        return;
    }

    container.innerHTML = requests.map(r => `
        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
            <div class="flex justify-between items-start mb-2">
                <div class="font-semibold text-gray-800 dark:text-gray-100">${r.patient_name}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">${r.request_date}</div>
            </div>
            <div class="text-sm text-gray-600 dark:text-gray-300 mb-2">
                ${r.service_type === 'ambulance' ? '🚑 Ambulance' : '⚰️ Jenazah'}
                ${r.patient_condition ? ` - ${r.patient_condition}` : ''}
            </div>
            <div>
                ${statusBadges[r.status] || r.status}
            </div>
        </div>
    `).join('');
}

// Initial load
updateData();

// Auto-refresh countdown
let countdown = 10;
setInterval(() => {
    countdown--;
    document.getElementById('countdown').textContent = countdown;

    if (countdown === 0) {
        updateData();
        countdown = 10;
    }
}, 1000);

// Dark mode toggle
function setDarkMode(isDark) {
    document.documentElement.classList.toggle('dark', isDark);
    const darkIcon = document.getElementById('dark-mode-icon');
    const lightIcon = document.getElementById('light-mode-icon');
    if (darkIcon && lightIcon) {
        darkIcon.classList.toggle('hidden', isDark);
        lightIcon.classList.toggle('hidden', !isDark);
    }
}

(function initToggle() {
    let isDark = false;
    try { isDark = localStorage.getItem('darkMode') === 'true'; } catch (e) {}
    setDarkMode(isDark);

    const toggle = document.getElementById('dark-mode-toggle');
    if (toggle) {
        toggle.addEventListener('click', () => {
            const next = !document.documentElement.classList.contains('dark');
            setDarkMode(next);
            try { localStorage.setItem('darkMode', next); } catch (e) {}
        });
    }
})();
</script>

</body>
</html>
<?php /**PATH /Applications/Dev/ambulance-dispatch/resources/views/monitoring/index.blade.php ENDPATH**/ ?>