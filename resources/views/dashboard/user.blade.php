@extends('layouts.app')

@push('styles')
<!-- FontAwesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<style>
    .pulse-glow {
      animation: pulseGlow 2s infinite;
    }
    @keyframes pulseGlow {
      0%, 100% { opacity: 1; transform: scale(1); }
      50% { opacity: 0.6; transform: scale(1.05); }
    }
    .card-hover {
      transition: all 0.25s ease-in-out;
    }
    .card-hover:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
    }
</style>
@endpush

@section('content')

<!-- Header de Control de Simulación -->
<div class="glass-card-eco border border-slate-200 rounded-2xl p-4 flex flex-wrap items-center justify-between gap-4 mb-6 shadow-sm">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-eco-600 text-white flex items-center justify-center shadow-md shadow-eco-500/20">
            <i class="fa-solid fa-house-chimney text-lg"></i>
        </div>
        <div>
            <h2 id="currentSectionTitle" class="text-lg font-bold text-slate-800">Panel General de Monitoreo</h2>
            <p class="text-xs text-slate-500">Medición no invasiva con ESP32 + SCT-013 100A / ACS712 + DHT11</p>
        </div>
    </div>

    <div class="flex items-center gap-2 sm:gap-3">
        <!-- Live Telemetry Simulator Control -->
        <div class="flex items-center bg-slate-50 p-1.5 rounded-xl border border-slate-200 text-xs shadow-inner">
            <button id="btnSimPause" onclick="toggleSimulation()" class="px-3 py-1.5 rounded-lg font-bold transition text-eco-700 bg-white shadow-sm flex items-center gap-1.5 border border-slate-200">
                <i id="simIcon" class="fa-solid fa-play text-[10px]"></i>
                <span id="simText">En Vivo (1s)</span>
            </button>
            <button onclick="triggerRandomSpike()" title="Simular pico de consumo en Nodo 1" class="px-3 py-1.5 text-slate-600 hover:text-amber-600 transition font-bold">
                <i class="fa-solid fa-bolt mr-1"></i> Pico
            </button>
        </div>
        <button onclick="exportToCSV()" class="hidden md:flex items-center gap-1.5 px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold shadow-sm transition">
            <i class="fa-solid fa-download"></i>
            <span>Exportar CSV</span>
        </button>
    </div>
</div>

<div class="flex flex-col lg:flex-row gap-6 relative items-start">
    
    <!-- SIDEBAR -->
    <aside class="w-full lg:w-64 shrink-0 bg-white border border-slate-200 rounded-2xl p-4 shadow-sm lg:sticky lg:top-24">
        
        <!-- Estado de Conexión IoT -->
        <div class="px-4 py-3 mb-4 rounded-xl bg-slate-50 border border-slate-200 shadow-inner">
            <div class="flex items-center justify-between text-xs mb-1">
                <span class="text-slate-600 flex items-center gap-1.5 font-bold">
                <span class="w-2 h-2 rounded-full bg-eco-500 pulse-glow"></span>
                Nodos ESP32
                </span>
                <span class="text-eco-700 font-black bg-eco-100 border border-eco-200 px-2 py-0.5 rounded text-[10px]">2 Conectados</span>
            </div>
            <div class="text-[11px] text-slate-500 flex items-center justify-between mt-2 font-medium">
                <span>SQL Cloud Sync:</span>
                <span class="text-slate-700 font-mono font-bold" id="lastSyncTime">00:00:00</span>
            </div>
        </div>

        <!-- Navegación -->
        <nav class="space-y-1.5">
            <button onclick="switchTab('dashboard')" id="nav-dashboard" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl font-bold text-sm transition bg-eco-50 text-eco-700 border border-eco-200">
                <i class="fa-solid fa-chart-line w-5 text-center"></i>
                <span>Panel de Control</span>
            </button>
            
            <button onclick="switchTab('telemetry')" id="nav-telemetry" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition text-slate-600 hover:bg-slate-50 border border-transparent">
                <i class="fa-solid fa-bolt-lightning w-5 text-center"></i>
                <span>Nodos & Sensores</span>
            </button>

            <button onclick="switchTab('anomalies')" id="nav-anomalies" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl font-semibold text-sm transition text-slate-600 hover:bg-slate-50 border border-transparent">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-triangle-exclamation w-5 text-center"></i>
                    <span>Anomalías</span>
                </div>
                <span id="anomalyBadge" class="bg-rose-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full shadow-sm">0</span>
            </button>

            <button onclick="switchTab('devices')" id="nav-devices" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition text-slate-600 hover:bg-slate-50 border border-transparent">
                <i class="fa-solid fa-power-off w-5 text-center"></i>
                <span>Dispositivos Smart</span>
            </button>

            <button onclick="switchTab('tariff')" id="nav-tariff" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition text-slate-600 hover:bg-slate-50 border border-transparent">
                <i class="fa-solid fa-receipt w-5 text-center"></i>
                <span>Costos & Tarifas</span>
            </button>

            <button onclick="switchTab('architecture')" id="nav-architecture" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition text-slate-600 hover:bg-slate-50 border border-transparent">
                <i class="fa-solid fa-diagram-project w-5 text-center"></i>
                <span>Arquitectura SMGE</span>
            </button>

            <button onclick="switchTab('reports')" id="nav-reports" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl font-semibold text-sm transition text-slate-600 hover:bg-slate-50 border border-transparent">
                <i class="fa-solid fa-file-shield w-5 text-center"></i>
                <span>Recomendaciones</span>
            </button>
        </nav>
    </aside>

    <!-- CONTENEDOR DE SECCIONES (TABS) -->
    <div class="flex-1 min-w-0">

        <!-- ================= SECCIÓN 1: DASHBOARD GENERAL ================= -->
        <section id="tab-dashboard" class="space-y-6">
            
            <!-- Banner de Bienvenida y Resumen Problemática INEGI -->
            <div class="bg-gradient-to-r from-eco-800 via-eco-700 to-teal-800 rounded-3xl p-6 sm:p-8 text-white shadow-lg relative overflow-hidden">
                <div class="absolute right-0 bottom-0 opacity-10 pointer-events-none transform translate-x-10 translate-y-10">
                    <i class="fa-solid fa-leaf text-9xl"></i>
                </div>
                <div class="relative z-10 max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-eco-500/30 text-eco-100 text-xs font-bold backdrop-blur-md mb-3 border border-eco-400/30">
                        <i class="fa-solid fa-circle-check text-eco-300"></i>
                        <span>Monitoreo Activo - Casa de Interés Social</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight">SMGE: Eficiencia Energética Inteligente</h1>
                    <p class="mt-2 text-eco-50 text-xs sm:text-sm font-medium leading-relaxed">
                        Según la <strong class="text-white">ENIGH 2022 del INEGI</strong>, el hogar promedio consume <strong>213 kWh</strong> por bimestre (~$507 MXN a $1.99/kWh). Tu sistema optimiza el consumo en tiempo real mediante algoritmos de detección temprana.
                    </p>
                    
                    <div class="mt-6 flex flex-wrap gap-4 pt-2">
                        <div class="bg-white/10 backdrop-blur rounded-2xl px-4 py-3 border border-white/20 shadow-sm">
                            <span class="text-[11px] text-eco-100 block font-bold uppercase tracking-wider">Consumo Acumulado Hoy</span>
                            <span class="text-2xl font-black text-white mt-1 block" id="dashTotalTodayKwh">4.82 kWh</span>
                        </div>
                        <div class="bg-white/10 backdrop-blur rounded-2xl px-4 py-3 border border-white/20 shadow-sm">
                            <span class="text-[11px] text-eco-100 block font-bold uppercase tracking-wider">Gasto Estimado Hoy</span>
                            <span class="text-2xl font-black text-teal-300 mt-1 block" id="dashTotalTodayCost">$9.59 MXN</span>
                        </div>
                        <div class="bg-white/10 backdrop-blur rounded-2xl px-4 py-3 border border-white/20 shadow-sm">
                            <span class="text-[11px] text-eco-100 block font-bold uppercase tracking-wider">Ahorro Proyectado</span>
                            <span class="text-2xl font-black text-emerald-300 mt-1 block" id="dashProjectedSavings">-18.4%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TARJETAS DE SENSORES EN TIEMPO REAL (KPIs) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                
                <!-- Potencia Total -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm card-hover">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Potencia Total (W)</span>
                        <div class="w-9 h-9 rounded-xl bg-amber-50 border border-amber-100 text-amber-500 flex items-center justify-center">
                            <i class="fa-solid fa-bolt"></i>
                        </div>
                    </div>
                    <div class="mt-3 flex items-baseline gap-2">
                        <span class="text-2xl sm:text-3xl font-black text-slate-800 font-mono" id="kpiPower">645</span>
                        <span class="text-xs font-bold text-slate-400">Watts</span>
                    </div>
                    <div class="mt-3 pt-3 border-t border-slate-100 text-[11px] flex items-center gap-1.5 text-eco-600 font-bold" id="kpiPowerStatus">
                        <i class="fa-solid fa-arrow-trend-down"></i>
                        <span>Operación nominal</span>
                    </div>
                </div>

                <!-- Voltaje de Red (RMS) -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm card-hover">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Voltaje de Red</span>
                        <div class="w-9 h-9 rounded-xl bg-blue-50 border border-blue-100 text-blue-500 flex items-center justify-center">
                            <i class="fa-solid fa-wave-square"></i>
                        </div>
                    </div>
                    <div class="mt-3 flex items-baseline gap-2">
                        <span class="text-2xl sm:text-3xl font-black text-slate-800 font-mono" id="kpiVoltage">121.4</span>
                        <span class="text-xs font-bold text-slate-400">VAC RMS</span>
                    </div>
                    <div class="mt-3 pt-3 border-t border-slate-100 text-[11px] flex items-center gap-1.5 text-slate-500 font-bold">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        <span>Rango estándar: 110V - 127V</span>
                    </div>
                </div>

                <!-- Corriente Total (SCT-013 + ACS712) -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm card-hover">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Corriente Total</span>
                        <div class="w-9 h-9 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-500 flex items-center justify-center">
                            <i class="fa-solid fa-gauge-high"></i>
                        </div>
                    </div>
                    <div class="mt-3 flex items-baseline gap-2">
                        <span class="text-2xl sm:text-3xl font-black text-slate-800 font-mono" id="kpiCurrent">5.31</span>
                        <span class="text-xs font-bold text-slate-400">Amperes (A)</span>
                    </div>
                    <div class="mt-3 pt-3 border-t border-slate-100 text-[11px] text-slate-500 font-bold flex justify-between">
                        <span>Nodo 1: <b id="kpiNode1Curr" class="text-slate-700">3.1 A</b></span>
                        <span>Nodo 2: <b id="kpiNode2Curr" class="text-slate-700">2.2 A</b></span>
                    </div>
                </div>

                <!-- Ambiente DHT11 (Temp & Humedad) -->
                <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm card-hover">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Ambiente DHT11</span>
                        <div class="w-9 h-9 rounded-xl bg-eco-50 border border-eco-100 text-eco-600 flex items-center justify-center">
                            <i class="fa-solid fa-temperature-half"></i>
                        </div>
                    </div>
                    <div class="mt-3 flex items-baseline justify-between">
                        <div>
                            <span class="text-2xl font-black text-slate-800 font-mono" id="kpiTemp">24.2</span>
                            <span class="text-xs font-bold text-slate-400">°C</span>
                        </div>
                        <div class="text-right">
                            <span class="text-2xl font-black text-slate-800 font-mono" id="kpiHumidity">56</span>
                            <span class="text-xs font-bold text-slate-400">% Hum</span>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-slate-100 text-[11px] font-bold text-slate-500 flex items-center gap-1.5">
                        <i class="fa-regular fa-sun text-amber-500"></i>
                        <span>Iluminación: <b id="kpiLux" class="text-slate-700">320 Lux</b></span>
                    </div>
                </div>

            </div>

            <!-- GRÁFICAS PRINCIPALES -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Gráfica de Potencia en Tiempo Real (2 columnas) -->
                <div class="lg:col-span-2 bg-white p-5 sm:p-6 rounded-3xl border border-slate-200 shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                        <div>
                            <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                                <i class="fa-solid fa-chart-area text-eco-600"></i>
                                Demanda de Potencia Eléctrica en Vivo
                            </h3>
                            <p class="text-xs text-slate-500 font-medium">Lecturas continuas emitidas por Nodos Sensores 1 y 2 vía WiFi</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 text-[11px] font-bold bg-eco-50 border border-eco-200 text-eco-700 px-2.5 py-1 rounded-lg">
                                <span class="w-2 h-2 rounded-full bg-eco-500 animate-pulse"></span>
                                Muestreo continuo
                            </span>
                        </div>
                    </div>
                    <div class="h-72 w-full relative">
                        <canvas id="livePowerChart"></canvas>
                    </div>
                </div>

                <!-- Gráfica de Distribución por Cargas / Dispositivos -->
                <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col justify-between">
                    <div>
                        <h3 class="font-bold text-slate-800 text-base flex items-center gap-2 mb-1">
                            <i class="fa-solid fa-chart-pie text-indigo-600"></i>
                            Consumo por Carga
                        </h3>
                        <p class="text-xs font-medium text-slate-500 mb-4">Desglose porcentual en la vivienda</p>
                        <div class="h-52 w-full relative flex items-center justify-center">
                            <canvas id="deviceShareChart"></canvas>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-100 grid grid-cols-2 gap-3 text-xs font-bold">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-eco-500"></span>
                            <span class="text-slate-600">Refrigerador</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-indigo-500"></span>
                            <span class="text-slate-600">Iluminación</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                            <span class="text-slate-600">Climatización</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                            <span class="text-slate-600">Standby</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- COMPARATIVA Y DETECCIÓN RÁPIDA -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Gráfica de Voltaje y Estabilidad de Red -->
                <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                                <i class="fa-solid fa-bolt text-blue-500"></i>
                                Estabilidad de Tensión (VAC)
                            </h3>
                            <p class="text-xs font-medium text-slate-500">Monitoreo de sobretensión y caídas de línea</p>
                        </div>
                        <span class="text-xs font-bold font-mono border border-blue-200 bg-blue-50 text-blue-700 px-2.5 py-1 rounded-lg">60 Hz AC</span>
                    </div>
                    <div class="h-60 w-full">
                        <canvas id="voltageStabilityChart"></canvas>
                    </div>
                </div>

                <!-- Gráfica de Temperatura y Humedad (DHT11) -->
                <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="font-bold text-slate-800 text-base flex items-center gap-2">
                                <i class="fa-solid fa-cloud-sun text-eco-500"></i>
                                Condiciones Ambientales
                            </h3>
                            <p class="text-xs font-medium text-slate-500">Impacto térmico en la demanda de refrigeración</p>
                        </div>
                        <span class="text-xs border border-eco-200 bg-eco-50 text-eco-700 px-2.5 py-1 rounded-lg font-bold">Interior Sala</span>
                    </div>
                    <div class="h-60 w-full">
                        <canvas id="dht11Chart"></canvas>
                    </div>
                </div>

            </div>

        </section>

        <!-- ================= SECCIÓN 2: NODOS Y SENSORES ================= -->
        <section id="tab-telemetry" class="hidden space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <div>
                    <h2 class="text-lg font-black text-slate-800">Módulos IoT y Sensores de Medición</h2>
                    <p class="text-xs font-medium text-slate-500">Arquitectura de hardware con microcontroladores ESP32 y sensórica modular no invasiva</p>
                </div>
                <!-- Simulador de Inyección de Falla -->
                <div class="flex items-center gap-3">
                    <button onclick="injectAnomaly('phantom')" class="px-4 py-2 bg-amber-50 hover:bg-amber-100 text-amber-800 text-xs font-bold rounded-xl border border-amber-200 transition flex items-center gap-2 shadow-sm">
                        <i class="fa-solid fa-ghost"></i>
                        <span>Inyectar Carga Vampiro</span>
                    </button>
                    <button onclick="injectAnomaly('surge')" class="px-4 py-2 bg-rose-50 hover:bg-rose-100 text-rose-800 text-xs font-bold rounded-xl border border-rose-200 transition flex items-center gap-2 shadow-sm">
                        <i class="fa-solid fa-bolt"></i>
                        <span>Simular Pico 145V</span>
                    </button>
                </div>
            </div>

            <!-- Fichas de los Nodos Sensores -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                
                <!-- Nodo 1 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm relative overflow-hidden">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-eco-600 text-white flex items-center justify-center font-black text-xl shadow-md shadow-eco-500/30">
                                N1
                            </div>
                            <div>
                                <h3 class="font-extrabold text-slate-800 text-base">Nodo Sensor 1 (ESP32)</h3>
                                <p class="text-[11px] font-bold text-slate-500 uppercase">Ubicación: Cocina & Sala Principal</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 text-[10px] font-bold px-3 py-1 bg-eco-100 border border-eco-200 text-eco-800 rounded-full">
                            <span class="w-2 h-2 rounded-full bg-eco-500 animate-pulse"></span> Conectado WiFi
                        </span>
                    </div>

                    <!-- Componentes físicos del nodo -->
                    <div class="mt-6 grid grid-cols-2 gap-3 text-xs">
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 shadow-inner">
                            <span class="text-slate-500 font-bold block text-[10px] uppercase">Sensor de Corriente</span>
                            <p class="font-bold text-slate-800 mt-1">SCT-013 (100A AC)</p>
                            <p class="text-eco-600 font-mono font-black mt-2 text-base" id="n1SCTValue">3.12 A</p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 shadow-inner">
                            <span class="text-slate-500 font-bold block text-[10px] uppercase">Sensor Hall Preciso</span>
                            <p class="font-bold text-slate-800 mt-1">ACS712 (30A)</p>
                            <p class="text-blue-600 font-mono font-black mt-2 text-base" id="n1ACSValue">378 W</p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 shadow-inner">
                            <span class="text-slate-500 font-bold block text-[10px] uppercase">Temp & Humedad</span>
                            <p class="font-bold text-slate-800 mt-1">DHT11 Digital</p>
                            <p class="text-indigo-600 font-mono font-black mt-2 text-base" id="n1DHTValue">24.1 °C | 55%</p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 shadow-inner">
                            <span class="text-slate-500 font-bold block text-[10px] uppercase">Alimentación</span>
                            <p class="font-bold text-slate-800 mt-1">Batería LiPo / 5V DC</p>
                            <p class="text-slate-600 font-mono font-black mt-2 text-base">98% (Óptimo)</p>
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between text-[11px] font-bold text-slate-500">
                        <span>MAC: <code class="text-slate-700 bg-slate-100 px-2 py-0.5 rounded border border-slate-200">24:6F:28:B1:A0:01</code></span>
                        <span>Tasa de Envío: <strong class="text-eco-600">Cada 1 seg</strong></span>
                    </div>
                </div>

                <!-- Nodo 2 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm relative overflow-hidden">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-600 text-white flex items-center justify-center font-black text-xl shadow-md shadow-indigo-500/30">
                                N2
                            </div>
                            <div>
                                <h3 class="font-extrabold text-slate-800 text-base">Nodo Sensor 2 (ESP32)</h3>
                                <p class="text-[11px] font-bold text-slate-500 uppercase">Ubicación: Recámaras & Clima</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 text-[10px] font-bold px-3 py-1 bg-eco-100 border border-eco-200 text-eco-800 rounded-full">
                            <span class="w-2 h-2 rounded-full bg-eco-500 animate-pulse"></span> Conectado WiFi
                        </span>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-3 text-xs">
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 shadow-inner">
                            <span class="text-slate-500 font-bold block text-[10px] uppercase">Sensor de Corriente</span>
                            <p class="font-bold text-slate-800 mt-1">SCT-013 (100A AC)</p>
                            <p class="text-eco-600 font-mono font-black mt-2 text-base" id="n2SCTValue">2.19 A</p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 shadow-inner">
                            <span class="text-slate-500 font-bold block text-[10px] uppercase">Sensor Hall Preciso</span>
                            <p class="font-bold text-slate-800 mt-1">ACS712 (30A)</p>
                            <p class="text-blue-600 font-mono font-black mt-2 text-base" id="n2ACSValue">267 W</p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 shadow-inner">
                            <span class="text-slate-500 font-bold block text-[10px] uppercase">Temp & Humedad</span>
                            <p class="font-bold text-slate-800 mt-1">DHT11 Digital</p>
                            <p class="text-indigo-600 font-mono font-black mt-2 text-base" id="n2DHTValue">25.0 °C | 58%</p>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 shadow-inner">
                            <span class="text-slate-500 font-bold block text-[10px] uppercase">Alimentación</span>
                            <p class="font-bold text-slate-800 mt-1">Batería LiPo / 5V DC</p>
                            <p class="text-slate-600 font-mono font-black mt-2 text-base">94% (Óptimo)</p>
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between text-[11px] font-bold text-slate-500">
                        <span>MAC: <code class="text-slate-700 bg-slate-100 px-2 py-0.5 rounded border border-slate-200">24:6F:28:B1:A0:02</code></span>
                        <span>Tasa de Envío: <strong class="text-eco-600">Cada 1 seg</strong></span>
                    </div>
                </div>

            </div>

            <!-- TABLA DE LECTURAS EN VIVO -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <div>
                        <h3 class="font-bold text-slate-800 text-base">Registro de Telemetría en Tiempo Real</h3>
                        <p class="text-xs font-medium text-slate-500">Datos recibidos por el servidor SQL en la nube</p>
                    </div>
                    <button onclick="clearTelemetryLog()" class="text-xs px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-slate-800 font-bold shadow-sm transition">
                        <i class="fa-solid fa-trash-can mr-1"></i> Limpiar
                    </button>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead class="bg-slate-100/80 text-slate-500 uppercase text-[10px] tracking-wider border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 font-black">Timestamp</th>
                                <th class="px-6 py-4 font-black">Nodo</th>
                                <th class="px-6 py-4 font-black">Voltaje (V)</th>
                                <th class="px-6 py-4 font-black">Corriente (A)</th>
                                <th class="px-6 py-4 font-black">Potencia (W)</th>
                                <th class="px-6 py-4 font-black">Temp (°C)</th>
                                <th class="px-6 py-4 font-black">Humedad (%)</th>
                                <th class="px-6 py-4 font-black">Estado</th>
                            </tr>
                        </thead>
                        <tbody id="telemetryTableBody" class="divide-y divide-slate-100 font-mono text-[11px] bg-white">
                            <!-- Inyectado dinámicamente -->
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- ================= SECCIÓN 3: DETECCIÓN DE ANOMALÍAS ================= -->
        <section id="tab-anomalies" class="hidden space-y-6">
            <div class="bg-gradient-to-r from-rose-900 via-rose-800 to-slate-900 rounded-3xl p-6 sm:p-8 text-white shadow-lg relative overflow-hidden">
                <div class="max-w-2xl relative z-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-rose-500/30 border border-rose-400/30 text-rose-100 text-xs font-bold mb-4 backdrop-blur-md">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>Módulo Inteligente de Protección</span>
                    </div>
                    <h2 class="text-2xl font-black">Detección de Anomalías & Consumo Vampiro</h2>
                    <p class="mt-3 text-rose-100 text-xs sm:text-sm leading-relaxed font-medium">
                        El sistema SMGE analiza las firmas de corriente en busca de fugas parásitas nocturnas, sobrecargas de circuito y variaciones de tensión perjudiciales para los electrodomésticos en casas de interés social.
                    </p>
                </div>
                <div class="absolute right-0 bottom-0 opacity-20 transform translate-x-10 translate-y-10">
                    <i class="fa-solid fa-triangle-exclamation text-9xl"></i>
                </div>
            </div>

            <!-- Panel de Configuración de Umbrales -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10 text-amber-500 text-4xl"><i class="fa-solid fa-ghost"></i></div>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Umbral Consumo Vampiro</span>
                    <div class="mt-3 flex items-center justify-between relative z-10">
                        <span class="text-2xl font-black text-slate-800 font-mono">50 W</span>
                        <span class="text-[10px] bg-amber-100 border border-amber-200 text-amber-800 px-2.5 py-1 rounded-md font-bold shadow-sm">En Standby</span>
                    </div>
                    <p class="text-[11px] text-slate-500 mt-3 font-medium relative z-10">Alerta automática si se detecta > 50W continuos durante horas nocturnas (01:00 - 05:00 hrs).</p>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10 text-rose-500 text-4xl"><i class="fa-solid fa-fire"></i></div>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Umbral Sobrecarga de Línea</span>
                    <div class="mt-3 flex items-center justify-between relative z-10">
                        <span class="text-2xl font-black text-slate-800 font-mono">15.0 A</span>
                        <span class="text-[10px] bg-rose-100 border border-rose-200 text-rose-800 px-2.5 py-1 rounded-md font-bold shadow-sm">Límite térmico</span>
                    </div>
                    <p class="text-[11px] text-slate-500 mt-3 font-medium relative z-10">Protege la instalación eléctrica evitando sobrecalentamiento en conductores de calibre 12/14 AWG.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10 text-blue-500 text-4xl"><i class="fa-solid fa-wave-square"></i></div>
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Tolerancia de Voltaje</span>
                    <div class="mt-3 flex items-center justify-between relative z-10">
                        <span class="text-2xl font-black text-slate-800 font-mono">±10% VAC</span>
                        <span class="text-[10px] bg-blue-100 border border-blue-200 text-blue-800 px-2.5 py-1 rounded-md font-bold shadow-sm">108V - 132V</span>
                    </div>
                    <p class="text-[11px] text-slate-500 mt-3 font-medium relative z-10">Previene daños en compresores de refrigeración y componentes electrónicos sensibles.</p>
                </div>
            </div>

            <!-- Historial de Alertas Generadas -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                    <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                        <i class="fa-solid fa-bell text-rose-500"></i>
                        Bitácora de Alertas del Sistema
                    </h3>
                    <button onclick="clearAlerts()" class="text-xs bg-white border border-rose-200 text-rose-600 px-4 py-2 rounded-xl hover:bg-rose-50 font-bold transition shadow-sm">
                        Marcar todas como resueltas
                    </button>
                </div>

                <div id="anomalyList" class="space-y-4">
                    <!-- Renderizado dinámico -->
                </div>
            </div>
        </section>

        <!-- ================= SECCIÓN 4: DISPOSITIVOS INTELIGENTES ================= -->
        <section id="tab-devices" class="hidden space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                <div>
                    <h2 class="text-xl font-black text-slate-800">Control de Dispositivos Inteligentes</h2>
                    <p class="text-xs font-medium text-slate-500 mt-1">Actuadores y relevadores conectados para gestión remota y apagado automático</p>
                </div>
                <button onclick="turnOffAllDevices()" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold shadow-md transition flex items-center gap-2">
                    <i class="fa-solid fa-power-off text-rose-400"></i>
                    <span>Apagar Cargas No Esenciales</span>
                </button>
            </div>

            <!-- Relevadores / Actuadores Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="smartDevicesGrid">
                <!-- Renderizado dinámicamente con JS -->
            </div>
        </section>

        <!-- ================= SECCIÓN 5: COSTOS Y TARIFAS (INEGI) ================= -->
        <section id="tab-tariff" class="hidden space-y-6">
            
            <!-- Encabezado Problemática Económica -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm relative overflow-hidden">
                <div class="absolute right-0 top-0 opacity-5 text-8xl text-eco-600 transform translate-x-4 -translate-y-4 pointer-events-none"><i class="fa-solid fa-money-bill-wave"></i></div>
                <div class="flex items-start justify-between flex-wrap gap-4 relative z-10">
                    <div class="max-w-2xl">
                        <span class="text-[10px] font-bold text-eco-600 uppercase tracking-wider bg-eco-50 px-2.5 py-1 rounded-md border border-eco-200">Contexto Socioeconómico (ENIGH 2022)</span>
                        <h2 class="text-2xl font-black text-slate-800 mt-3">Análisis Financiero y Tarifario CFE</h2>
                        <p class="text-xs sm:text-sm font-medium text-slate-600 mt-3 leading-relaxed">
                            En México, el costo promedio por kWh es de <strong>$1.99 MXN</strong>. El consumo promedio bimestral es de <strong>213 kWh ($507 MXN)</strong>. A continuación, se proyecta tu factura estimada con base en la telemetría actual.
                        </p>
                    </div>
                    <div class="flex items-center gap-3 bg-slate-50 p-3 rounded-xl border border-slate-200">
                        <label class="text-xs font-bold text-slate-600">Tarifa $/kWh:</label>
                        <input type="number" id="tariffRateInput" step="0.01" value="1.99" onchange="updateTariffCalculation()"
                            class="w-24 px-3 py-2 rounded-lg border border-slate-300 text-sm font-black text-slate-800 text-center focus:outline-none focus:border-eco-500 focus:ring-1 focus:ring-eco-500 transition" />
                    </div>
                </div>
            </div>

            <!-- Tarjetas de Proyección Financiera -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm card-hover">
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Consumo Proyectado Bimestre</span>
                    <div class="mt-3 flex items-baseline gap-2">
                        <span class="text-3xl font-black text-slate-800 font-mono" id="projectedBimonthKwh">174.2</span>
                        <span class="text-xs font-bold text-slate-400">kWh</span>
                    </div>
                    <div class="mt-3 pt-3 border-t border-slate-100 text-[11px] text-eco-600 font-bold flex items-center gap-1.5">
                        <i class="fa-solid fa-arrow-trend-down"></i>
                        <span>38.8 kWh por debajo del promedio INEGI</span>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm card-hover">
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Costo Estimado Próximo Recibo</span>
                    <div class="mt-3 flex items-baseline gap-2">
                        <span class="text-3xl font-black text-eco-600 font-mono" id="projectedBimonthCost">$346.65</span>
                        <span class="text-xs font-bold text-slate-400">MXN</span>
                    </div>
                    <div class="mt-3 pt-3 border-t border-slate-100 text-[11px] text-eco-700 font-bold flex items-center gap-1.5">
                        <i class="fa-solid fa-piggy-bank"></i>
                        <span>Ahorro de ~$160.35 MXN vs Promedio</span>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm card-hover">
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Límite Tarifa Doméstica Básica</span>
                    <div class="mt-3 flex items-baseline gap-2">
                        <span class="text-3xl font-black text-indigo-600 font-mono">250.0</span>
                        <span class="text-xs font-bold text-slate-400">kWh máx</span>
                    </div>
                    <div class="mt-3 pt-3 border-t border-slate-100 text-[11px] text-slate-500 font-medium">
                        <span>Riesgo de tarifa DAC: <b class="text-eco-600 font-bold">Muy Bajo (Seguro)</b></span>
                    </div>
                </div>

            </div>

            <!-- Barra de Progreso del Consumo Bimestral vs INEGI -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
                <h3 class="font-bold text-slate-800 text-base mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-chart-bar text-slate-400"></i>
                    Progreso Bimestral vs. Promedio INEGI (213 kWh)
                </h3>
                <div class="w-full bg-slate-100 h-5 rounded-full overflow-hidden relative shadow-inner">
                    <div id="kwhProgressBar" class="bg-eco-500 h-full rounded-full transition-all duration-500" style="width: 58%;"></div>
                    <!-- Marcador INEGI -->
                    <div class="absolute top-0 bottom-0 border-r-2 border-dashed border-rose-500" style="left: 85%;" title="Promedio INEGI: 213 kWh"></div>
                </div>
                <div class="flex justify-between items-center text-xs font-bold text-slate-500 mt-3">
                    <span>0 kWh</span>
                    <span class="text-eco-700 px-3 py-1 bg-eco-50 rounded-lg border border-eco-200" id="currKwhLabel">Consumo Actual: 124.5 kWh</span>
                    <span class="text-rose-600 px-3 py-1 bg-rose-50 rounded-lg border border-rose-200">Promedio Nacional: 213 kWh</span>
                    <span>300 kWh</span>
                </div>
            </div>

            <!-- Gráfica Histórica Mensual -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
                <h3 class="font-bold text-slate-800 text-lg mb-1">Comparativa de Consumo Mensual (kWh)</h3>
                <p class="text-xs font-medium text-slate-500 mb-6">Evolución del hogar con SMGE vs. línea base tradicional</p>
                <div class="h-72 w-full">
                    <canvas id="monthlyCostChart"></canvas>
                </div>
            </div>

        </section>

        <!-- ================= SECCIÓN 6: ARQUITECTURA DEL SISTEMA ================= -->
        <section id="tab-architecture" class="hidden space-y-6">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 opacity-5 text-9xl text-slate-900 transform translate-x-10 -translate-y-10 pointer-events-none"><i class="fa-solid fa-server"></i></div>
                <div class="max-w-3xl relative z-10">
                    <span class="text-[10px] font-bold text-eco-600 uppercase tracking-wider bg-eco-50 px-2.5 py-1 rounded-md border border-eco-200">Especificación Técnica del Proyecto</span>
                    <h2 class="text-2xl font-black text-slate-800 mt-3">Arquitectura Modular del SMGE</h2>
                    <p class="text-xs sm:text-sm font-medium text-slate-600 mt-3 leading-relaxed">
                        El sistema integra sensores de corriente no invasivos, transductores de efecto Hall y sensores termo-higrométricos conectados a microcontroladores ESP32 con enlace WiFi hacia una base de datos SQL en la nube y esta interfaz web interactiva.
                    </p>
                </div>

                <!-- DIAGRAMA VISUAL DE BLOQUES INTERACTIVO -->
                <div class="mt-10 grid grid-cols-1 lg:grid-cols-4 gap-5 relative z-10">
                    
                    <!-- Bloque 1: Sensores y Nodos -->
                    <div class="p-6 rounded-2xl bg-eco-50/50 border-2 border-eco-200 flex flex-col justify-between hover:bg-eco-50 transition card-hover">
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-eco-600 text-white flex items-center justify-center text-xl mb-4 shadow-md shadow-eco-500/20">
                                <i class="fa-solid fa-microchip"></i>
                            </div>
                            <h4 class="font-black text-slate-800 text-base">Capa 1: Sensórica IoT</h4>
                            <ul class="mt-4 space-y-2.5 text-xs font-medium text-slate-600">
                                <li class="flex items-start gap-2"><i class="fa-solid fa-check text-eco-600 mt-0.5"></i> ESP32 WiFi / BLE</li>
                                <li class="flex items-start gap-2"><i class="fa-solid fa-check text-eco-600 mt-0.5"></i> SCT-013 100A (No invasivo)</li>
                                <li class="flex items-start gap-2"><i class="fa-solid fa-check text-eco-600 mt-0.5"></i> ACS712 30A (Efecto Hall)</li>
                                <li class="flex items-start gap-2"><i class="fa-solid fa-check text-eco-600 mt-0.5"></i> DHT11 (Temp & Humedad)</li>
                                <li class="flex items-start gap-2"><i class="fa-solid fa-check text-eco-600 mt-0.5"></i> Respaldo Batería LiPo</li>
                            </ul>
                        </div>
                        <div class="mt-5 pt-3 border-t border-eco-200 text-[11px] text-eco-800 font-bold bg-white px-3 py-2 rounded-xl">
                            <i class="fa-solid fa-wifi mr-1"></i> Protocolo MQTT / HTTP
                        </div>
                    </div>

                    <!-- Bloque 2: Red y Conectividad -->
                    <div class="p-6 rounded-2xl bg-blue-50/50 border-2 border-blue-200 flex flex-col justify-between hover:bg-blue-50 transition card-hover">
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-xl mb-4 shadow-md shadow-blue-500/20">
                                <i class="fa-solid fa-network-wired"></i>
                            </div>
                            <h4 class="font-black text-slate-800 text-base">Capa 2: Gateway & Red</h4>
                            <ul class="mt-4 space-y-2.5 text-xs font-medium text-slate-600">
                                <li class="flex items-start gap-2"><i class="fa-solid fa-check text-blue-600 mt-0.5"></i> WiFi 802.11 b/g/n (2.4 GHz)</li>
                                <li class="flex items-start gap-2"><i class="fa-solid fa-check text-blue-600 mt-0.5"></i> Cifrado WPA2/WPA3</li>
                                <li class="flex items-start gap-2"><i class="fa-solid fa-check text-blue-600 mt-0.5"></i> Buffer local antidesconexión</li>
                                <li class="flex items-start gap-2"><i class="fa-solid fa-check text-blue-600 mt-0.5"></i> JSON Payload optimizado</li>
                            </ul>
                        </div>
                        <div class="mt-5 pt-3 border-t border-blue-200 text-[11px] text-blue-800 font-bold bg-white px-3 py-2 rounded-xl">
                            <i class="fa-solid fa-cloud-arrow-up mr-1"></i> Transmisión Segura
                        </div>
                    </div>

                    <!-- Bloque 3: Base de Datos SQL Cloud -->
                    <div class="p-6 rounded-2xl bg-indigo-50/50 border-2 border-indigo-200 flex flex-col justify-between hover:bg-indigo-50 transition card-hover">
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-indigo-600 text-white flex items-center justify-center text-xl mb-4 shadow-md shadow-indigo-500/20">
                                <i class="fa-solid fa-database"></i>
                            </div>
                            <h4 class="font-black text-slate-800 text-base">Capa 3: Cloud SQL</h4>
                            <ul class="mt-4 space-y-2.5 text-xs font-medium text-slate-600">
                                <li class="flex items-start gap-2"><i class="fa-solid fa-check text-indigo-600 mt-0.5"></i> Base de datos SQL Relacional</li>
                                <li class="flex items-start gap-2"><i class="fa-solid fa-check text-indigo-600 mt-0.5"></i> Series de tiempo (Timestamps)</li>
                                <li class="flex items-start gap-2"><i class="fa-solid fa-check text-indigo-600 mt-0.5"></i> Motor de Reglas de Anomalías</li>
                                <li class="flex items-start gap-2"><i class="fa-solid fa-check text-indigo-600 mt-0.5"></i> Agregación horaria/diaria</li>
                            </ul>
                        </div>
                        <div class="mt-5 pt-3 border-t border-indigo-200 text-[11px] text-indigo-800 font-bold bg-white px-3 py-2 rounded-xl">
                            <i class="fa-solid fa-server mr-1"></i> API RESTful & WebSockets
                        </div>
                    </div>

                    <!-- Bloque 4: Plataforma Web/Móvil -->
                    <div class="p-6 rounded-2xl bg-teal-50/50 border-2 border-teal-200 flex flex-col justify-between hover:bg-teal-50 transition card-hover">
                        <div>
                            <div class="w-12 h-12 rounded-2xl bg-teal-600 text-white flex items-center justify-center text-xl mb-4 shadow-md shadow-teal-500/20">
                                <i class="fa-solid fa-mobile-screen-button"></i>
                            </div>
                            <h4 class="font-black text-slate-800 text-base">Capa 4: Interfaz Usuario</h4>
                            <ul class="mt-4 space-y-2.5 text-xs font-medium text-slate-600">
                                <li class="flex items-start gap-2"><i class="fa-solid fa-check text-teal-600 mt-0.5"></i> Dashboard Multiplataforma</li>
                                <li class="flex items-start gap-2"><i class="fa-solid fa-check text-teal-600 mt-0.5"></i> Gráficas Dinámicas en Vivo</li>
                                <li class="flex items-start gap-2"><i class="fa-solid fa-check text-teal-600 mt-0.5"></i> Alertas Push & Sonoras</li>
                                <li class="flex items-start gap-2"><i class="fa-solid fa-check text-teal-600 mt-0.5"></i> Control Remoto de Cargas</li>
                            </ul>
                        </div>
                        <div class="mt-5 pt-3 border-t border-teal-200 text-[11px] text-teal-800 font-bold bg-white px-3 py-2 rounded-xl">
                            <i class="fa-solid fa-user-check mr-1"></i> Gestión Residencial
                        </div>
                    </div>

                </div>

                <!-- Validación de Hipótesis -->
                <div class="mt-10 p-6 sm:p-8 bg-slate-50 rounded-3xl border border-slate-200 shadow-inner">
                    <h4 class="font-black text-slate-800 text-base flex items-center gap-2">
                        <i class="fa-solid fa-lightbulb text-amber-500 text-xl"></i>
                        Validación de la Hipótesis de Investigación
                    </h4>
                    <p class="text-xs sm:text-sm text-slate-600 mt-3 leading-relaxed italic font-medium bg-white p-4 rounded-xl border border-slate-200">
                        "La implementación de un sistema de monitoreo energético inteligente basado en sensores IoT no invasivos y análisis en tiempo real reducirá significativamente el consumo eléctrico en casas de interés social mediante la identificación de patrones de uso ineficiente y la generación de alertas automatizadas..."
                    </p>
                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-5">
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm text-center">
                            <span class="text-slate-400 font-bold block text-[10px] tracking-wider mb-2">REDUCCIÓN DE CARGA VAMPIRO</span>
                            <span class="font-black text-eco-600 text-3xl font-mono">-15% a -22%</span>
                        </div>
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm text-center">
                            <span class="text-slate-400 font-bold block text-[10px] tracking-wider mb-2">RETORNO DE INVERSIÓN (ROI)</span>
                            <span class="font-black text-indigo-600 text-3xl font-mono">4.2 Meses</span>
                        </div>
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm text-center">
                            <span class="text-slate-400 font-bold block text-[10px] tracking-wider mb-2">TIEMPO DE DETECCIÓN DE FALLA</span>
                            <span class="font-black text-rose-600 text-3xl font-mono">< 3 Seg</span>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- ================= SECCIÓN 7: RECOMENDACIONES DE AHORRO ================= -->
        <section id="tab-reports" class="hidden space-y-6">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm">
                <h2 class="text-2xl font-black text-slate-800">Recomendaciones Automatizadas de Eficiencia</h2>
                <p class="text-xs font-medium text-slate-500 mb-8 mt-1">Consejos basados en el comportamiento real de tus sensores IoT</p>

                <div class="space-y-5">
                    
                    <!-- Tip 1: Refrigeración -->
                    <div class="p-6 rounded-2xl bg-white border border-slate-200 flex flex-col sm:flex-row items-start gap-5 shadow-sm card-hover">
                        <div class="w-14 h-14 rounded-2xl bg-eco-100 text-eco-600 border border-eco-200 flex items-center justify-center shrink-0 text-2xl">
                            <i class="fa-solid fa-snowflake"></i>
                        </div>
                        <div class="flex-1 w-full">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-2">
                                <h4 class="font-black text-slate-800 text-base">Optimización del Refrigerador en Cocina</h4>
                                <span class="text-[11px] font-bold bg-eco-100 border border-eco-200 text-eco-800 px-3 py-1 rounded-lg self-start">Ahorro: ~$45 MXN/mes</span>
                            </div>
                            <p class="text-xs font-medium text-slate-600 leading-relaxed">
                                El sensor DHT11 registra 25°C en la cocina. Separar el refrigerador 10 cm del muro y verificar el empaque magnético reducirá el ciclo de trabajo del compresor en un 18%.
                            </p>
                        </div>
                    </div>

                    <!-- Tip 2: Carga Fantasma -->
                    <div class="p-6 rounded-2xl bg-white border border-slate-200 flex flex-col sm:flex-row items-start gap-5 shadow-sm card-hover">
                        <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-500 border border-amber-200 flex items-center justify-center shrink-0 text-2xl">
                            <i class="fa-solid fa-tv"></i>
                        </div>
                        <div class="flex-1 w-full">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-2">
                                <h4 class="font-black text-slate-800 text-base">Centro de Entretenimiento en Modo Standby</h4>
                                <span class="text-[11px] font-bold bg-amber-100 border border-amber-200 text-amber-800 px-3 py-1 rounded-lg self-start">Ahorro: ~$32 MXN/mes</span>
                            </div>
                            <p class="text-xs font-medium text-slate-600 leading-relaxed">
                                Se detectaron 48W continuos durante la madrugada en el Nodo 1. Activa la programación automática del relevador inteligente a la medianoche para desconectar la pantalla y consolas.
                            </p>
                        </div>
                    </div>

                    <!-- Tip 3: Iluminación -->
                    <div class="p-6 rounded-2xl bg-white border border-slate-200 flex flex-col sm:flex-row items-start gap-5 shadow-sm card-hover">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-500 border border-blue-200 flex items-center justify-center shrink-0 text-2xl">
                            <i class="fa-solid fa-lightbulb"></i>
                        </div>
                        <div class="flex-1 w-full">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-2">
                                <h4 class="font-black text-slate-800 text-base">Aprovechamiento de Luz Solar</h4>
                                <span class="text-[11px] font-bold bg-blue-100 border border-blue-200 text-blue-800 px-3 py-1 rounded-lg self-start">Ahorro: ~$20 MXN/mes</span>
                            </div>
                            <p class="text-xs font-medium text-slate-600 leading-relaxed">
                                El nivel de iluminación natural supera los 400 Lux entre 10:00 y 16:00 hrs. El sistema sugiere mantener apagadas las luminarias LED de la estancia durante este horario.
                            </p>
                        </div>
                    </div>

                </div>

                <!-- Botón de Simulación de Meta de Ahorro -->
                <div class="mt-8 pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <span class="text-xs font-bold text-slate-500 text-center sm:text-left">¿Deseas aplicar todas las recomendaciones sugeridas?</span>
                    <button onclick="applyAllRecommendations()" class="w-full sm:w-auto px-6 py-3 bg-eco-600 hover:bg-eco-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-eco-600/30 transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-wand-magic-sparkles"></i>
                        <span>Aplicar Modo Eco Óptimo</span>
                    </button>
                </div>
            </div>
        </section>

    </div>
</div>

@endsection

@push('scripts')
<!-- Canvas Confetti -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<script>
    /* ================= ESTADO GLOBAL DEL SISTEMA ================= */
    const state = {
        isSimulating: true,
        simInterval: null,
        tickCount: 0,
        
        // Factores tarifarios (INEGI ENIGH 2022)
        tariffKwhRate: 1.99,
        inegiHouseholdAvgKwh: 213,
        inegiHouseholdAvgCost: 507,
        
        // Lecturas actuales
        currentTelemetry: {
            voltage: 121.5,
            node1Current: 3.10,
            node2Current: 2.21,
            node1Power: 376,
            node2Power: 268,
            totalPower: 644,
            temp: 24.2,
            humidity: 56,
            lux: 320,
            todayKwh: 4.82,
            timestamp: new Date()
        },

        // Histórico para gráficas (últimos 15 puntos)
        history: {
            labels: [],
            totalPower: [],
            node1Power: [],
            node2Power: [],
            voltage: [],
            temp: [],
            humidity: []
        },

        // Lista de anomalías
        anomalies: [
            {
                id: 1,
                type: 'warning',
                title: 'Carga Parásita Detectada',
                msg: 'Consumo continuo de 58W detectado en el Nodo 1 durante horas de bajo uso.',
                time: '03:15 AM',
                status: 'Activa'
            },
            {
                id: 2,
                type: 'info',
                title: 'Ciclo de Refrigeración Completado',
                msg: 'Compresor en estado normal de reposo. Pico de arranque de 4.8A absorbido.',
                time: '06:42 AM',
                status: 'Resuelta'
            }
        ],

        // Dispositivos inteligentes domóticos
        devices: [
            { id: 1, name: 'Refrigerador Inverter', room: 'Cocina (Nodo 1)', powerW: 180, state: true, icon: 'fa-snowflake', essential: true },
            { id: 2, name: 'Luminarias LED Sala', room: 'Sala (Nodo 1)', powerW: 45, state: true, icon: 'fa-lightbulb', essential: false },
            { id: 3, name: 'Pantalla Smart TV & Audio', room: 'Sala (Nodo 1)', powerW: 110, state: true, icon: 'fa-tv', essential: false },
            { id: 4, name: 'Minisplit Recámara', room: 'Recámara (Nodo 2)', powerW: 650, state: false, icon: 'fa-wind', essential: false },
            { id: 5, name: 'Lavadora Automática', room: 'Patio (Nodo 2)', powerW: 350, state: false, icon: 'fa-soap', essential: false },
            { id: 6, name: 'Router WiFi & Gateway IoT', room: 'General (Nodo 1)', powerW: 18, state: true, icon: 'fa-wifi', essential: true }
        ]
    };

    /* ================= INSTANCIAS DE CHART.JS ================= */
    let livePowerChart = null;
    let deviceShareChart = null;
    let voltageStabilityChart = null;
    let dht11Chart = null;
    let monthlyCostChart = null;

    /* ================= INICIALIZACIÓN AL CARGAR LA PÁGINA ================= */
    window.addEventListener('DOMContentLoaded', () => {
        // Asumiendo que Chart.js se carga vía app.blade.php o ya está globalmente
        Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
        Chart.defaults.color = '#64748b';
        Chart.defaults.scale.grid.color = 'rgba(0, 0, 0, 0.05)';

        initHistoryBuffer();
        initCharts();
        renderSmartDevices();
        renderAnomalyList();
        updateDashboardUI();
        startSimulator();
    });

    /* ================= NAVEGACIÓN ENTRE SECCIONES ================= */
    window.switchTab = function(tabId) {
        const sections = ['dashboard', 'telemetry', 'anomalies', 'devices', 'tariff', 'architecture', 'reports'];
        
        sections.forEach(id => {
            const sec = document.getElementById(`tab-${id}`);
            const nav = document.getElementById(`nav-${id}`);
            if (sec && nav) {
                if (id === tabId) {
                    sec.classList.remove('hidden');
                    nav.classList.add('bg-eco-50', 'text-eco-700', 'border-eco-200');
                    nav.classList.remove('text-slate-600', 'border-transparent', 'hover:bg-slate-50');
                } else {
                    sec.classList.add('hidden');
                    nav.classList.remove('bg-eco-50', 'text-eco-700', 'border-eco-200');
                    nav.classList.add('text-slate-600', 'border-transparent', 'hover:bg-slate-50');
                }
            }
        });

        const titles = {
            dashboard: 'Panel General de Monitoreo',
            telemetry: 'Nodos Sensores & Muestreo IoT (ESP32)',
            anomalies: 'Módulo de Detección de Anomalías',
            devices: 'Gestión y Control de Cargas Inteligentes',
            tariff: 'Análisis Económico y Tarifas CFE / INEGI',
            architecture: 'Arquitectura Modular del Sistema SMGE',
            reports: 'Recomendaciones Automatizadas de Ahorro'
        };
        const titleEl = document.getElementById('currentSectionTitle');
        if(titleEl) titleEl.innerText = titles[tabId] || 'SMGE GreenTech';

        setTimeout(() => {
            if (tabId === 'dashboard') {
                livePowerChart?.resize();
                deviceShareChart?.resize();
                voltageStabilityChart?.resize();
                dht11Chart?.resize();
            } else if (tabId === 'tariff') {
                monthlyCostChart?.resize();
            }
        }, 100);
    }

    /* ================= BUFFER DE DATOS INICIAL ================= */
    function initHistoryBuffer() {
        const now = new Date();
        for (let i = 14; i >= 0; i--) {
            const t = new Date(now.getTime() - i * 3000);
            const timeStr = t.toLocaleTimeString('es-ES', {hour12: false});
            state.history.labels.push(timeStr);
            state.history.node1Power.push(350 + Math.random() * 40);
            state.history.node2Power.push(240 + Math.random() * 30);
            state.history.totalPower.push(590 + Math.random() * 70);
            state.history.voltage.push(121 + (Math.random() * 2 - 1));
            state.history.temp.push(24.0 + Math.random() * 0.4);
            state.history.humidity.push(55 + Math.random() * 2);
        }
    }

    /* ================= INICIALIZACIÓN DE GRÁFICAS (CHART.JS) ================= */
    function initCharts() {
        if(typeof Chart === 'undefined') return;

        const ctxPower = document.getElementById('livePowerChart')?.getContext('2d');
        if (ctxPower) {
            const gradPower = ctxPower.createLinearGradient(0, 0, 0, 300);
            gradPower.addColorStop(0, 'rgba(16, 185, 129, 0.2)');
            gradPower.addColorStop(1, 'rgba(16, 185, 129, 0.0)');

            livePowerChart = new Chart(ctxPower, {
                type: 'line',
                data: {
                    labels: state.history.labels,
                    datasets: [
                        {
                            label: 'Potencia Total (W)',
                            data: state.history.totalPower,
                            borderColor: '#10b981', // eco-500
                            backgroundColor: gradPower,
                            borderWidth: 2.5,
                            fill: true,
                            tension: 0.35,
                            pointRadius: 2,
                            pointHoverRadius: 6
                        },
                        {
                            label: 'Nodo 1 (W)',
                            data: state.history.node1Power,
                            borderColor: '#3b82f6', // blue-500
                            borderWidth: 1.5,
                            borderDash: [4, 4],
                            fill: false,
                            tension: 0.3,
                            pointRadius: 0
                        },
                        {
                            label: 'Nodo 2 (W)',
                            data: state.history.node2Power,
                            borderColor: '#8b5cf6', // indigo-500
                            borderWidth: 1.5,
                            borderDash: [4, 4],
                            fill: false,
                            tension: 0.3,
                            pointRadius: 0
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: { duration: 300 },
                    plugins: {
                        legend: { position: 'top', labels: { font: { size: 11 } } },
                        tooltip: { mode: 'index', intersect: false }
                    },
                    scales: {
                        x: { grid: { display: false }, ticks: { maxTicksLimit: 7 } },
                        y: { beginAtZero: false, ticks: { callback: v => v + ' W' } }
                    }
                }
            });
        }

        const ctxShare = document.getElementById('deviceShareChart')?.getContext('2d');
        if (ctxShare) {
            deviceShareChart = new Chart(ctxShare, {
                type: 'doughnut',
                data: {
                    labels: ['Refrigeración', 'Iluminación', 'Climatización', 'Standby'],
                    datasets: [{
                        data: [35, 18, 27, 20],
                        backgroundColor: ['#10b981', '#6366f1', '#f59e0b', '#f43f5e'],
                        borderWidth: 2,
                        borderColor: '#ffffff',
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    cutout: '72%'
                }
            });
        }

        const ctxVolt = document.getElementById('voltageStabilityChart')?.getContext('2d');
        if (ctxVolt) {
            voltageStabilityChart = new Chart(ctxVolt, {
                type: 'line',
                data: {
                    labels: state.history.labels,
                    datasets: [{
                        label: 'Voltaje RMS (V)',
                        data: state.history.voltage,
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        fill: true,
                        borderWidth: 2,
                        tension: 0.3,
                        pointRadius: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, ticks: { maxTicksLimit: 6 } },
                        y: { min: 110, max: 130, ticks: { callback: v => v + 'V' } }
                    }
                }
            });
        }

        const ctxDht = document.getElementById('dht11Chart')?.getContext('2d');
        if (ctxDht) {
            dht11Chart = new Chart(ctxDht, {
                type: 'line',
                data: {
                    labels: state.history.labels,
                    datasets: [
                        {
                            label: 'Temperatura (°C)',
                            data: state.history.temp,
                            borderColor: '#10b981',
                            yAxisID: 'yTemp',
                            tension: 0.3,
                            borderWidth: 2,
                            pointRadius: 1
                        },
                        {
                            label: 'Humedad (%)',
                            data: state.history.humidity,
                            borderColor: '#0ea5e9',
                            yAxisID: 'yHum',
                            borderDash: [3, 3],
                            tension: 0.3,
                            borderWidth: 1.5,
                            pointRadius: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: { grid: { display: false }, ticks: { maxTicksLimit: 6 } },
                        yTemp: { type: 'linear', position: 'left', min: 18, max: 35 },
                        yHum: { type: 'linear', position: 'right', min: 30, max: 80, grid: { display: false } }
                    }
                }
            });
        }

        const ctxMonthly = document.getElementById('monthlyCostChart')?.getContext('2d');
        if (ctxMonthly) {
            monthlyCostChart = new Chart(ctxMonthly, {
                type: 'bar',
                data: {
                    labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago'],
                    datasets: [
                        {
                            label: 'Promedio INEGI (213 kWh)',
                            data: [213, 213, 213, 213, 213, 213, 213, 213],
                            backgroundColor: '#cbd5e1',
                            borderRadius: 6
                        },
                        {
                            label: 'Tu Consumo (kWh)',
                            data: [185, 178, 172, 169, 175, 168, 162, 159],
                            backgroundColor: '#10b981',
                            borderRadius: 6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'top' } },
                    scales: {
                        y: { beginAtZero: true, max: 250 },
                        x: { grid: { display: false } }
                    }
                }
            });
        }
    }

    /* ================= MOTOR DE SIMULACIÓN EN TIEMPO REAL ================= */
    function startSimulator() {
        if (state.simInterval) clearInterval(state.simInterval);
        state.simInterval = setInterval(() => {
            if (!state.isSimulating) return;
            tickSimulation();
        }, 1000);
    }

    window.toggleSimulation = function() {
        state.isSimulating = !state.isSimulating;
        const btnIcon = document.getElementById('simIcon');
        const btnText = document.getElementById('simText');
        if (state.isSimulating) {
            btnIcon.className = 'fa-solid fa-play text-[10px]';
            btnText.innerText = 'En Vivo (1s)';
            if(typeof showToast !== 'undefined') showToast('Simulación de telemetría reanudada', 'info');
        } else {
            btnIcon.className = 'fa-solid fa-pause text-[10px]';
            btnText.innerText = 'Pausado';
            if(typeof showToast !== 'undefined') showToast('Simulación pausada', 'warning');
        }
    }

    function tickSimulation() {
        state.tickCount++;
        const now = new Date();
        const timeString = now.toLocaleTimeString('es-ES', {hour12: false});

        let activeDevicesPower = 0;
        state.devices.forEach(d => { if (d.state) activeDevicesPower += d.powerW; });

        const noise = (Math.random() - 0.5) * 20;
        const basePower = Math.max(80, activeDevicesPower + noise);
        
        const vNoise = (Math.random() - 0.5) * 1.2;
        const currentVoltage = +(121.2 + vNoise).toFixed(1);

        const node1P = +(basePower * 0.58 + (Math.random() - 0.5) * 15).toFixed(0);
        const node2P = +(basePower * 0.42 + (Math.random() - 0.5) * 10).toFixed(0);
        const totalP = node1P + node2P;

        const node1I = +(node1P / currentVoltage).toFixed(2);
        const node2I = +(node2P / currentVoltage).toFixed(2);
        const totalI = +(node1I + node2I).toFixed(2);

        const temp = +(24.2 + (Math.random() - 0.5) * 0.3).toFixed(1);
        const hum = +(56 + (Math.random() - 0.5) * 1.5).toFixed(0);
        const lux = +(320 + (Math.random() - 0.5) * 10).toFixed(0);

        state.currentTelemetry.todayKwh += (totalP / 3600000);

        state.currentTelemetry = {
            voltage: currentVoltage,
            node1Current: node1I,
            node2Current: node2I,
            node1Power: node1P,
            node2Power: node2P,
            totalPower: totalP,
            temp: temp,
            humidity: hum,
            lux: lux,
            todayKwh: state.currentTelemetry.todayKwh,
            timestamp: now
        };

        state.history.labels.push(timeString);
        state.history.totalPower.push(totalP);
        state.history.node1Power.push(node1P);
        state.history.node2Power.push(node2P);
        state.history.voltage.push(currentVoltage);
        state.history.temp.push(temp);
        state.history.humidity.push(hum);

        if (state.history.labels.length > 20) {
            state.history.labels.shift();
            state.history.totalPower.shift();
            state.history.node1Power.shift();
            state.history.node2Power.shift();
            state.history.voltage.shift();
            state.history.temp.shift();
            state.history.humidity.shift();
        }

        updateDashboardUI();
        updateChartsUI();
        appendTelemetryRow(timeString, currentVoltage, totalI, totalP, temp, hum);
        
        const syncLabel = document.getElementById('lastSyncTime');
        if(syncLabel) syncLabel.innerText = timeString;
    }

    /* ================= ACTUALIZACIÓN DEL DASHBOARD ================= */
    function updateDashboardUI() {
        const t = state.currentTelemetry;
        
        const el = (id, val) => { const e = document.getElementById(id); if(e) e.innerText = val; };
        
        el('kpiPower', t.totalPower);
        el('kpiVoltage', t.voltage);
        el('kpiCurrent', (t.node1Current + t.node2Current).toFixed(2));
        el('kpiNode1Curr', `${t.node1Current} A`);
        el('kpiNode2Curr', `${t.node2Current} A`);
        el('kpiTemp', t.temp);
        el('kpiHumidity', t.humidity);
        el('kpiLux', `${t.lux} Lux`);

        el('n1SCTValue', `${t.node1Current} A`);
        el('n1ACSValue', `${t.node1Power} W`);
        el('n1DHTValue', `${t.temp} °C | ${t.humidity}%`);

        el('n2SCTValue', `${t.node2Current} A`);
        el('n2ACSValue', `${t.node2Power} W`);
        el('n2DHTValue', `${(t.temp + 0.8).toFixed(1)} °C | ${(t.humidity + 2)}%`);

        const todayCost = t.todayKwh * state.tariffKwhRate;
        el('dashTotalTodayKwh', `${t.todayKwh.toFixed(2)} kWh`);
        el('dashTotalTodayCost', `$${todayCost.toFixed(2)} MXN`);

        updateTariffCalculation();
    }

    function updateChartsUI() {
        if (livePowerChart) {
            livePowerChart.data.labels = state.history.labels;
            livePowerChart.data.datasets[0].data = state.history.totalPower;
            livePowerChart.data.datasets[1].data = state.history.node1Power;
            livePowerChart.data.datasets[2].data = state.history.node2Power;
            livePowerChart.update('none');
        }
        if (voltageStabilityChart) {
            voltageStabilityChart.data.labels = state.history.labels;
            voltageStabilityChart.data.datasets[0].data = state.history.voltage;
            voltageStabilityChart.update('none');
        }
        if (dht11Chart) {
            dht11Chart.data.labels = state.history.labels;
            dht11Chart.data.datasets[0].data = state.history.temp;
            dht11Chart.data.datasets[1].data = state.history.humidity;
            dht11Chart.update('none');
        }
    }

    /* ================= TABLA DE TELEMETRÍA ================= */
    function appendTelemetryRow(time, volt, curr, pwr, temp, hum) {
        const tbody = document.getElementById('telemetryTableBody');
        if (!tbody) return;

        const tr = document.createElement('tr');
        tr.className = 'hover:bg-slate-50 transition border-b border-slate-100';
        tr.innerHTML = `
            <td class="px-6 py-3 text-slate-500">${time}</td>
            <td class="px-6 py-3 font-bold text-slate-700">Nodo 1 + 2</td>
            <td class="px-6 py-3 text-blue-600 font-bold">${volt} V</td>
            <td class="px-6 py-3 text-eco-600 font-bold">${curr} A</td>
            <td class="px-6 py-3 text-slate-900 font-bold">${pwr} W</td>
            <td class="px-6 py-3 text-slate-700">${temp} °C</td>
            <td class="px-6 py-3 text-slate-700">${hum} %</td>
            <td class="px-6 py-3"><span class="px-2 py-0.5 bg-eco-100 text-eco-800 rounded border border-eco-200 text-[10px] font-bold">SQL OK</span></td>
        `;

        tbody.insertBefore(tr, tbody.firstChild);
        while (tbody.children.length > 10) { tbody.removeChild(tbody.lastChild); }
    }

    window.clearTelemetryLog = function() {
        const tbody = document.getElementById('telemetryTableBody');
        if (tbody) tbody.innerHTML = '';
        if(typeof showToast !== 'undefined') showToast('Registro visual de telemetría limpiado', 'info');
    }

    /* ================= GESTIÓN DE DISPOSITIVOS INTELIGENTES ================= */
    function renderSmartDevices() {
        const container = document.getElementById('smartDevicesGrid');
        if (!container) return;

        container.innerHTML = state.devices.map(dev => `
            <div class="bg-white p-6 rounded-3xl border ${dev.state ? 'border-eco-200 shadow-md' : 'border-slate-200 opacity-80'} transition-all card-hover flex flex-col justify-between">
                <div class="flex items-start justify-between">
                    <div class="w-12 h-12 rounded-2xl ${dev.state ? 'bg-eco-100 text-eco-600 border border-eco-200' : 'bg-slate-100 text-slate-400'} flex items-center justify-center text-xl transition">
                        <i class="fa-solid ${dev.icon}"></i>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" ${dev.state ? 'checked' : ''} onchange="toggleDevice(${dev.id})" class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-eco-600"></div>
                    </label>
                </div>
                
                <div class="mt-5">
                    <h4 class="font-black text-slate-800 text-base">${dev.name}</h4>
                    <p class="text-xs font-bold text-slate-400 mt-1">${dev.room}</p>
                </div>

                <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-slate-500 font-bold">Consumo Nominal:</span>
                    <span class="font-mono font-black text-sm ${dev.state ? 'text-eco-700' : 'text-slate-400'}">${dev.powerW} W</span>
                </div>
            </div>
        `).join('');
    }

    window.toggleDevice = function(id) {
        const dev = state.devices.find(d => d.id === id);
        if (dev) {
            dev.state = !dev.state;
            renderSmartDevices();
            if(typeof showToast !== 'undefined') showToast(`${dev.name} ${dev.state ? 'encendido' : 'apagado'} vía Relevador IoT`, dev.state ? 'success' : 'info');
        }
    }

    window.turnOffAllDevices = function() {
        let turnedOff = 0;
        state.devices.forEach(d => {
            if (!d.essential && d.state) {
                d.state = false;
                turnedOff++;
            }
        });
        renderSmartDevices();
        if(typeof showToast !== 'undefined') showToast(`Se apagaron ${turnedOff} cargas no esenciales automáticamente.`, 'success');
    }

    /* ================= DETECCIÓN DE ANOMALÍAS ================= */
    function renderAnomalyList() {
        const container = document.getElementById('anomalyList');
        const badge = document.getElementById('anomalyBadge');
        if (!container) return;

        const activeCount = state.anomalies.filter(a => a.status === 'Activa').length;
        if (badge) badge.innerText = activeCount;

        if (state.anomalies.length === 0) {
            container.innerHTML = `
                <div class="p-8 text-center text-slate-400">
                    <i class="fa-solid fa-circle-check text-4xl text-eco-500 mb-3"></i>
                    <p class="text-sm font-bold">No hay anomalías activas</p>
                    <p class="text-xs mt-1 font-medium">El sistema opera dentro de parámetros seguros.</p>
                </div>
            `;
            return;
        }

        container.innerHTML = state.anomalies.map(a => `
            <div class="p-5 rounded-2xl ${a.status === 'Activa' ? 'bg-rose-50 border border-rose-200' : 'bg-slate-50 border border-slate-200'} flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-sm transition">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl ${a.status === 'Activa' ? 'bg-rose-500 text-white shadow-md shadow-rose-500/20' : 'bg-slate-200 text-slate-500'} flex items-center justify-center shrink-0">
                        <i class="fa-solid ${a.status === 'Activa' ? 'fa-triangle-exclamation' : 'fa-check'} text-base"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <h4 class="font-black text-slate-800 text-sm">${a.title}</h4>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded ${a.status === 'Activa' ? 'bg-rose-200 text-rose-800' : 'bg-slate-200 text-slate-700'}">${a.status}</span>
                        </div>
                        <p class="text-xs text-slate-600 font-medium">${a.msg}</p>
                        <span class="text-[10px] font-bold text-slate-400 mt-1.5 inline-block"><i class="fa-regular fa-clock mr-1"></i>${a.time}</span>
                    </div>
                </div>
                ${a.status === 'Activa' ? `
                    <button onclick="resolveAnomaly(${a.id})" class="px-4 py-2 bg-white border border-rose-200 hover:bg-rose-100 text-rose-700 text-xs font-bold rounded-xl shadow-sm transition whitespace-nowrap self-end sm:self-auto">
                        Resolver
                    </button>
                ` : ''}
            </div>
        `).join('');
    }

    window.resolveAnomaly = function(id) {
        const a = state.anomalies.find(item => item.id === id);
        if (a) {
            a.status = 'Resuelta';
            renderAnomalyList();
            if(typeof showToast !== 'undefined') showToast('Anomalía marcada como atendida', 'success');
        }
    }

    window.clearAlerts = function() {
        state.anomalies.forEach(a => a.status = 'Resuelta');
        renderAnomalyList();
        if(typeof showToast !== 'undefined') showToast('Todas las alertas han sido marcadas como resueltas', 'info');
    }

    window.injectAnomaly = function(type) {
        const nowStr = new Date().toLocaleTimeString('es-ES', {hour12: false});
        if (type === 'phantom') {
            state.anomalies.unshift({
                id: Date.now(), type: 'danger', title: 'Alerta: Fuga Parásita / Carga Vampiro',
                msg: 'Consumo residual no registrado de 95W detectado con luminarias y pantallas en standby.', time: nowStr, status: 'Activa'
            });
            if(typeof showToast !== 'undefined') showToast('¡Anomalía inyectada! Consumo vampiro de 95W detectado.', 'danger');
        } else if (type === 'surge') {
            state.currentTelemetry.voltage = 142.0;
            state.anomalies.unshift({
                id: Date.now(), type: 'danger', title: 'Alerta: Sobretensión Crítica',
                msg: 'Voltaje de red alcanzó 142.0 VAC. Se recomienda protección de compresores.', time: nowStr, status: 'Activa'
            });
            if(typeof showToast !== 'undefined') showToast('¡Alerta de sobretensión! 142.0 VAC en la red.', 'danger');
        }
        renderAnomalyList();
    }

    window.triggerRandomSpike = function() {
        state.currentTelemetry.node1Power += 1200;
        state.currentTelemetry.totalPower += 1200;
        if(typeof showToast !== 'undefined') showToast('Pico momentáneo simulado: +1200W (Ej. Microondas / Calefactor)', 'warning');
        updateDashboardUI();
    }

    /* ================= CÁLCULOS TARIFARIOS Y ECONÓMICOS (CFE / INEGI) ================= */
    window.updateTariffCalculation = function() {
        const inputRate = parseFloat(document.getElementById('tariffRateInput')?.value) || 1.99;
        state.tariffKwhRate = inputRate;

        const dailyKwh = Math.max(2.8, state.currentTelemetry.todayKwh);
        const projectedKwh = dailyKwh * 60;
        const projectedCost = projectedKwh * state.tariffKwhRate;

        const kwhEl = document.getElementById('projectedBimonthKwh');
        const costEl = document.getElementById('projectedBimonthCost');
        if(kwhEl) kwhEl.innerText = projectedKwh.toFixed(1);
        if(costEl) costEl.innerText = `$${projectedCost.toFixed(2)}`;

        const pct = Math.min(100, (projectedKwh / 300) * 100);
        const bar = document.getElementById('kwhProgressBar');
        const label = document.getElementById('currKwhLabel');
        
        if (bar) {
            bar.style.width = `${pct}%`;
            if (projectedKwh > 213) {
                bar.className = 'bg-rose-500 h-full rounded-full transition-all duration-500';
            } else {
                bar.className = 'bg-eco-500 h-full rounded-full transition-all duration-500';
            }
        }
        if (label) label.innerText = `Consumo Proyectado: ${projectedKwh.toFixed(1)} kWh`;
    }

    /* ================= ACCIONES RECOMENDACIONES & AHORRO ================= */
    window.applyAllRecommendations = function() {
        state.devices.forEach(d => { if (!d.essential) d.state = false; });
        renderSmartDevices();

        if (typeof confetti === 'function') {
            confetti({ particleCount: 100, spread: 80, origin: { y: 0.6 }, colors: ['#10b981', '#34d399', '#ffffff'] });
        }
        if(typeof showToast !== 'undefined') showToast('¡Modo Eco Activado! Ahorro proyectado estimado: 22.4% en tu próximo recibo CFE.', 'success');
    }

    /* ================= EXPORTACIÓN A CSV ================= */
    window.exportToCSV = function() {
        let csv = 'Timestamp,Voltaje_RMS_V,Potencia_Total_W,Nodo1_Potencia_W,Nodo2_Potencia_W,Temp_C,Humedad_Pct\n';
        for (let i = 0; i < state.history.labels.length; i++) {
            csv += `${state.history.labels[i]},${state.history.voltage[i]},${state.history.totalPower[i]},${state.history.node1Power[i]},${state.history.node2Power[i]},${state.history.temp[i]},${state.history.humidity[i]}\n`;
        }
        const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `telemetria_SMGE_GreenTech_${Date.now()}.csv`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
        if(typeof showToast !== 'undefined') showToast('Archivo CSV descargado exitosamente.', 'success');
    }
</script>
@endpush
