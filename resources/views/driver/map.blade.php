@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-6">

    <!-- HEADER -->
    <div class="mb-4">
        <h1 class="text-2xl font-bold text-gray-800">
            📍 Realtime Lokasi Ambulans
        </h1>
        <p class="text-sm text-gray-500">
            Posisi ambulance diperbarui secara realtime melalui browser driver
        </p>
    </div>

    <!-- MAP -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div id="map" class="w-full h-[500px]"></div>
    </div>

</div>

<!-- LEAFLET MAP -->
<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
/>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // Default map (Jakarta sebagai fallback)
    const map = L.map('map').setView([-6.200000, 106.816666], 13);

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
        maxZoom: 19,
        attribution: isDarkMode() ? attributions.dark : attributions.light
    }).addTo(map);

    new MutationObserver(() => {
        const dark = isDarkMode();
        const nextUrl = dark ? tileUrls.dark : tileUrls.light;
        if (tileLayer._url !== nextUrl) {
            map.removeLayer(tileLayer);
            tileLayer = L.tileLayer(nextUrl, {
                maxZoom: 19,
                attribution: dark ? attributions.dark : attributions.light
            }).addTo(map);
        }
    }).observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });

    // Marker ambulance
    let ambulanceMarker = null;

    function updateAmbulancePosition(lat, lng) {
        if (!ambulanceMarker) {
            ambulanceMarker = L.marker([lat, lng]).addTo(map);
        } else {
            ambulanceMarker.setLatLng([lat, lng]);
        }
        map.setView([lat, lng], 15);
    }

    // Ambil lokasi dari browser driver
    if ("geolocation" in navigator) {
        navigator.geolocation.watchPosition(
            function(position) {
                updateAmbulancePosition(
                    position.coords.latitude,
                    position.coords.longitude
                );
            },
            function(error) {
                console.error("GPS Error:", error.message);
            },
            {
                enableHighAccuracy: true,
                maximumAge: 5000,
                timeout: 10000
            }
        );
    } else {
        alert("Browser tidak mendukung GPS");
    }
</script>
@endsection

