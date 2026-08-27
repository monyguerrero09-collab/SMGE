@extends('layouts.app')

@section('content')
<!-- Fila de Tarjetas KPI -->
<div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
    <div class="glass-card-eco rounded-2xl p-5 relative overflow-hidden">
        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Usuarios</span>
        <h3 class="text-3xl font-extrabold font-mono text-slate-900 mt-2">128</h3>
        <p class="text-xs text-eco-600 font-medium mt-1"><i class="fa-solid fa-arrow-trend-up"></i> +12 este mes</p>
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-eco-500"></div>
    </div>
    <div class="glass-card-eco rounded-2xl p-5 relative overflow-hidden">
        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Empleados Activos</span>
        <h3 class="text-3xl font-extrabold font-mono text-slate-900 mt-2">14</h3>
        <p class="text-xs text-eco-600 font-medium mt-1"><i class="fa-solid fa-users"></i> En plataforma</p>
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-eco-500"></div>
    </div>
    <div class="glass-card-eco rounded-2xl p-5 relative overflow-hidden">
        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Consumo General</span>
        <h3 class="text-3xl font-extrabold font-mono text-slate-900 mt-2">842 <span class="text-lg text-slate-600">kW</span></h3>
        <p class="text-xs text-amber-600 font-medium mt-1"><i class="fa-solid fa-bolt"></i> Monitoreado en tiempo real</p>
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-amber-500"></div>
    </div>
    <div class="glass-card-eco rounded-2xl p-5 relative overflow-hidden">
        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Alertas de Red</span>
        <h3 class="text-3xl font-extrabold font-mono text-slate-900 mt-2">8</h3>
        <p class="text-xs text-rose-600 font-medium mt-1"><i class="fa-solid fa-circle-exclamation"></i> Requieren atención</p>
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-rose-500"></div>
    </div>
</div>

<!-- Tabla de Usuarios Registrados -->
<div class="glass-card-eco rounded-2xl border border-slate-200 mt-6 overflow-hidden shadow-sm">
    <div class="p-5 border-b border-slate-200 flex justify-between items-center bg-white/40">
        <div>
            <h3 class="text-base font-bold text-slate-900">Usuarios Registrados</h3>
            <p class="text-xs text-slate-500 font-medium">Panel de control y asignación técnica</p>
        </div>
        <button onclick="showToast('Nuevo Usuario', 'Abriendo formulario para registrar usuario.', 'success')" class="bg-eco-600 hover:bg-eco-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition-all shadow-md shadow-eco-600/20">
            <i class="fa-solid fa-user-plus mr-1.5"></i> Añadir Usuario
        </button>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50/80 border-b border-slate-200 text-xs uppercase text-slate-500 font-bold">
                <tr>
                    <th class="px-5 py-3">Usuario / Cliente</th>
                    <th class="px-5 py-3">Consumo Actual</th>
                    <th class="px-5 py-3">Estado de Red</th>
                    <th class="px-5 py-3">Técnico Asignado</th>
                    <th class="px-5 py-3 text-right">Acción</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white/60">
                <tr class="hover:bg-eco-50/50 transition-colors">
                    <td class="px-5 py-4 font-bold text-slate-900">Mónica Olvera</td>
                    <td class="px-5 py-4 font-mono text-xs font-semibold text-slate-700">2.46 kW</td>
                    <td class="px-5 py-4">
                        <span class="bg-emerald-100 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wide shadow-sm">NORMAL</span>
                    </td>
                    <td class="px-5 py-4 text-xs font-medium text-slate-700">Carlos Hernández</td>
                    <td class="px-5 py-4 text-right">
                        <button onclick="showToast('Perfil de Usuario', 'Cargando datos completos de Mónica.')" class="bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 text-xs font-semibold px-3 py-1.5 rounded-lg shadow-sm transition-colors">
                            Ver Perfil
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-eco-50/50 transition-colors">
                    <td class="px-5 py-4 font-bold text-slate-900">Roberto García</td>
                    <td class="px-5 py-4 font-mono text-xs font-semibold text-rose-600">5.83 kW</td>
                    <td class="px-5 py-4">
                        <span class="bg-rose-100 text-rose-700 border border-rose-200 px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wide shadow-sm">CRÍTICO</span>
                    </td>
                    <td class="px-5 py-4 text-xs text-slate-400 italic font-medium">Sin asignar</td>
                    <td class="px-5 py-4 text-right">
                        <button onclick="showToast('Asignación', 'Selecciona un técnico disponible.')" class="bg-eco-600 hover:bg-eco-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg shadow-sm shadow-eco-600/20 transition-all">
                            Asignar Técnico
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-eco-50/50 transition-colors">
                    <td class="px-5 py-4 font-bold text-slate-900">Industrias Eco</td>
                    <td class="px-5 py-4 font-mono text-xs font-semibold text-slate-700">12.40 kW</td>
                    <td class="px-5 py-4">
                        <span class="bg-amber-100 text-amber-700 border border-amber-200 px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wide shadow-sm">ADVERTENCIA</span>
                    </td>
                    <td class="px-5 py-4 text-xs font-medium text-slate-700">Laura Montes</td>
                    <td class="px-5 py-4 text-right">
                        <button onclick="showToast('Perfil de Usuario', 'Cargando datos completos de Industrias Eco.')" class="bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 text-xs font-semibold px-3 py-1.5 rounded-lg shadow-sm transition-colors">
                            Ver Perfil
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
