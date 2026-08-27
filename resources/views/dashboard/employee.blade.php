@extends('layouts.app')

@push('styles')
<!-- Leaflet CSS para Mapas Interactivos -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
<style>
    #map {
        border-radius: 0.75rem;
        z-index: 10;
    }
</style>
@endpush

@section('content')
<!-- Fila de Tarjetas KPI -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
    <div class="glass-card-eco rounded-2xl p-5 relative overflow-hidden">
        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Servicios Pendientes</span>
        <h3 class="text-3xl font-extrabold font-mono text-slate-900 mt-2">3</h3>
        <p class="text-xs text-amber-600 font-medium mt-1">Requieren atención prioritaria</p>
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-amber-500"></div>
    </div>
    <div class="glass-card-eco rounded-2xl p-5 relative overflow-hidden">
        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Servicios Realizados</span>
        <h3 class="text-3xl font-extrabold font-mono text-slate-900 mt-2">27</h3>
        <p class="text-xs text-eco-600 font-medium mt-1">Completados este mes</p>
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-eco-500"></div>
    </div>
    <div class="glass-card-eco rounded-2xl p-5 relative overflow-hidden">
        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Nivel de Satisfacción</span>
        <h3 class="text-3xl font-extrabold font-mono text-slate-900 mt-2">94%</h3>
        <p class="text-xs text-eco-600 font-medium mt-1">Calificación excelente</p>
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-eco-500"></div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
    <!-- Tabla de Servicios Asignados -->
    <div class="glass-card-eco rounded-2xl border border-slate-200 overflow-hidden shadow-sm flex flex-col h-full">
        <div class="p-5 border-b border-slate-200 flex justify-between items-center bg-white/40">
            <div>
                <h3 class="text-base font-bold text-slate-900">Servicios Asignados</h3>
                <p class="text-xs text-slate-500 font-medium">Gestión de atención técnica a usuarios</p>
            </div>
        </div>
        <div class="overflow-x-auto flex-1">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50/80 border-b border-slate-200 text-xs uppercase text-slate-500 font-bold">
                    <tr>
                        <th class="px-5 py-3">Usuario / Cliente</th>
                        <th class="px-5 py-3">Motivo de la Visita</th>
                        <th class="px-5 py-3">Prioridad</th>
                        <th class="px-5 py-3 text-right">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white/60">
                    <tr class="hover:bg-eco-50/50 transition-colors cursor-pointer" onclick="focusMap(20.3888, -99.9959, 'Mónica Olvera')">
                        <td class="px-5 py-4 font-bold text-slate-900">
                            Mónica Olvera<br>
                            <span class="text-[10px] font-normal text-slate-500"><i class="fa-solid fa-location-dot mr-1 text-rose-500"></i>San Juan del Río, Qro.</span>
                        </td>
                        <td class="px-5 py-4 text-xs font-medium">Revisión por consumo elevado</td>
                        <td class="px-5 py-4">
                            <span class="bg-rose-100 text-rose-700 border border-rose-200 px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wide shadow-sm">ALTA</span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <button onclick="event.stopPropagation(); showToast('Iniciando Atención', 'Abriendo formulario de reporte para Mónica Olvera.')" class="bg-eco-600 hover:bg-eco-700 text-white text-xs font-semibold px-4 py-2 rounded-xl transition-all shadow-md shadow-eco-600/20">
                                Atender
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-eco-50/50 transition-colors cursor-pointer" onclick="focusMap(20.5888, -100.3899, 'Roberto García')">
                        <td class="px-5 py-4 font-bold text-slate-900">
                            Roberto García<br>
                            <span class="text-[10px] font-normal text-slate-500"><i class="fa-solid fa-location-dot mr-1 text-rose-500"></i>Centro Histórico, Qro.</span>
                        </td>
                        <td class="px-5 py-4 text-xs font-medium">Instalación de sensor IoT</td>
                        <td class="px-5 py-4">
                            <span class="bg-cyan-100 text-cyan-700 border border-cyan-200 px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wide shadow-sm">MEDIA</span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <button onclick="event.stopPropagation(); showToast('Iniciando Atención', 'Abriendo formulario de reporte para Roberto García.')" class="bg-eco-600 hover:bg-eco-700 text-white text-xs font-semibold px-4 py-2 rounded-xl transition-all shadow-md shadow-eco-600/20">
                                Atender
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-eco-50/50 transition-colors cursor-pointer" onclick="focusMap(20.5702, -100.2443, 'Industrias Eco')">
                        <td class="px-5 py-4 font-bold text-slate-900">
                            Industrias Eco<br>
                            <span class="text-[10px] font-normal text-slate-500"><i class="fa-solid fa-location-dot mr-1 text-rose-500"></i>El Marqués, Qro.</span>
                        </td>
                        <td class="px-5 py-4 text-xs font-medium">Mantenimiento preventivo</td>
                        <td class="px-5 py-4">
                            <span class="bg-emerald-100 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wide shadow-sm">BAJA</span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <button onclick="event.stopPropagation(); showToast('Iniciando Atención', 'Abriendo formulario de reporte para Industrias Eco.')" class="bg-eco-600 hover:bg-eco-700 text-white text-xs font-semibold px-4 py-2 rounded-xl transition-all shadow-md shadow-eco-600/20">
                                Atender
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mapa Interactivo de Localización -->
    <div class="glass-card-eco rounded-2xl border border-slate-200 overflow-hidden shadow-sm flex flex-col h-full min-h-[400px]">
        <div class="p-5 border-b border-slate-200 bg-white/40 flex justify-between items-center">
            <div>
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-map-location-dot text-eco-600"></i>
                    Geolocalización de Servicios
                </h3>
                <p class="text-xs text-slate-500 font-medium">Haz clic en un servicio de la tabla para ubicarlo</p>
            </div>
            <button onclick="resetMap()" class="text-xs bg-slate-100 hover:bg-slate-200 text-slate-600 px-3 py-1.5 rounded-lg border border-slate-200 transition font-bold shadow-sm">
                Ver Todos
            </button>
        </div>
        <!-- Contenedor del Mapa -->
        <div class="flex-1 w-full bg-slate-100 relative">
            <div id="map" class="absolute inset-0"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Leaflet JS para Mapas Interactivos -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script>
    let map;
    let markers = [];

    // Coordenadas de los servicios
    const locations = [
        { lat: 20.3888, lng: -99.9959, title: "Mónica Olvera (San Juan del Río)", priority: "ALTA" },
        { lat: 20.5888, lng: -100.3899, title: "Roberto García (Centro Histórico)", priority: "MEDIA" },
        { lat: 20.5702, lng: -100.2443, title: "Industrias Eco (El Marqués)", priority: "BAJA" }
    ];

    document.addEventListener("DOMContentLoaded", () => {
        // Inicializar mapa centrado en Querétaro
        map = L.map('map').setView([20.588, -100.389], 10);

        // Añadir capa de OpenStreetMap (estilo estándar claro)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Icono personalizado para Leaflet
        const greenIcon = new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        // Crear marcadores
        locations.forEach(loc => {
            const marker = L.marker([loc.lat, loc.lng], { icon: greenIcon }).addTo(map)
                .bindPopup(`<strong>${loc.title}</strong><br>Prioridad: ${loc.priority}`);
            markers.push(marker);
        });

        // Ajustar zoom para que se vean todos los marcadores
        resetMap();
    });

    // Función para centrar el mapa en un cliente específico
    window.focusMap = function(lat, lng, name) {
        map.setView([lat, lng], 15, { animate: true, duration: 1 });
        // Encontrar el marcador y abrir su popup
        markers.forEach(m => {
            if (m.getLatLng().lat === lat && m.getLatLng().lng === lng) {
                m.openPopup();
            }
        });
        if(typeof showToast !== 'undefined') showToast('Ubicación localizada', `Mostrando en mapa: ${name}`);
    };

    // Función para restaurar la vista general
    window.resetMap = function() {
        const group = new L.featureGroup(markers);
        map.fitBounds(group.getBounds().pad(0.2));
        markers.forEach(m => m.closePopup());
    };
</script>
@endpush
