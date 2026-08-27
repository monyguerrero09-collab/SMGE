<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GreenTech | Gestión Inteligente de Energía</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    },
                    colors: {
                        eco: {
                            50: '#F2F9F5',
                            100: '#E2F3E9',
                            200: '#C7E7D4',
                            300: '#9DD5B6',
                            400: '#6BBC92',
                            500: '#41A172',
                            600: '#2F855B',
                            700: '#276A4B',
                            800: '#22553E',
                            900: '#1D4634',
                            950: '#0E271D',
                        },
                        leaf: '#10B981',
                        sprout: '#84CC16',
                        accent: {
                            cyan: '#06b6d4',
                            amber: '#f59e0b',
                            rose: '#f43f5e'
                        }
                    },
                    animation: {
                        'pulse-fast': 'pulse 1.2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'float-slow': 'float 6s ease-in-out infinite',
                        'float-delayed': 'float 7s ease-in-out 2s infinite',
                        'pulse-subtle': 'pulseSlow 4s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px) rotate(0deg)' },
                            '50%': { transform: 'translateY(-12px) rotate(3deg)' },
                        },
                        pulseSlow: {
                            '0%, 100%': { opacity: 0.4, transform: 'scale(1)' },
                            '50%': { opacity: 0.7, transform: 'scale(1.05)' },
                        }
                    }
                }
            }
        }
    </script>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap');
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at 10% 20%, #E9F6EE 0%, #F5FAF6 45%, #E3F2E9 100%);
            min-height: 100vh;
            color: #1e293b; /* text-slate-800 */
        }

        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Glass Effects */
        .glass-eco {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(167, 243, 208, 0.5);
        }

        .glass-card-eco {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }

        .glass-card-glow {
            box-shadow: 0 0 25px -5px rgba(65, 161, 114, 0.25);
        }

        /* Nav actions */
        .nav-btn {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid #e2e8f0;
            color: #64748b;
        }
        .nav-btn:hover {
            color: #2F855B;
            background: #F2F9F5;
            border-color: #C7E7D4;
        }
    </style>
    @stack('styles')
</head>
<body class="flex flex-col text-slate-800 antialiased overflow-x-hidden relative min-h-screen">

    <!-- Elementos decorativos de fondo -->
    <div class="fixed top-[-10%] left-[-5%] w-96 h-96 bg-emerald-200/40 rounded-full blur-3xl pointer-events-none animate-pulse-subtle -z-10"></div>
    <div class="fixed bottom-[-10%] right-[-5%] w-[32rem] h-[32rem] bg-teal-200/40 rounded-full blur-3xl pointer-events-none animate-pulse-subtle -z-10"></div>

    <!-- Mensaje Toast / Notificación Global -->
    <div id="toast-container" class="fixed top-5 right-5 z-50 flex flex-col gap-2 pointer-events-none"></div>

    <!-- Navegación Superior -->
    <header class="sticky top-0 z-40 glass-eco border-b border-eco-200/50 px-4 lg:px-8 py-3.5">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-4">
            
            <!-- Logo & Estado -->
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-eco-500 to-teal-500 flex items-center justify-center text-white shadow-lg shadow-eco-500/30">
                    <i class="fa-solid fa-leaf text-xl"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="font-black text-xl tracking-tight text-slate-900">Green<span class="text-eco-600">Tech</span></span>
                        <span class="text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded-full bg-eco-100 text-eco-700 border border-eco-200">v3.0 Eco</span>
                    </div>
                    <p class="text-xs text-slate-500 font-medium">Gestión Inteligente de Energía</p>
                </div>
            </div>

            <!-- Acciones Rápidas del Sistema -->
            <div class="flex items-center gap-4">
                
                <!-- Notificaciones -->
                <button class="nav-btn w-9 h-9 rounded-lg flex items-center justify-center relative transition-all shadow-sm" onclick="showToast('Notificaciones','Tienes 2 recomendaciones pendientes.', 'info')">
                    <i class="fa-regular fa-bell"></i>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-accent-rose rounded-full border-2 border-white"></span>
                </button>



                <!-- Perfil -->
                <div class="flex items-center gap-2 pl-2 border-l border-slate-300">
                    <div class="w-9 h-9 rounded-lg bg-eco-100 text-eco-700 border border-eco-200 font-bold flex items-center justify-center text-sm shadow-sm">
                        MO
                    </div>
                    <div class="hidden md:block text-xs">
                        <strong class="block text-slate-900">Mónica Olvera</strong>
                        <span class="text-slate-500 font-medium">
                            @if(request()->is('/')) Usuario general 
                            @elseif(request()->is('employee')) Empleado 
                            @else Administrador @endif
                        </span>
                    </div>
                    <a href="{{ route('login') }}" class="ml-2 text-slate-400 hover:text-eco-600 transition-colors" title="Cerrar sesión">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </a>
                </div>

            </div>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="flex-1 max-w-7xl w-full mx-auto p-4 lg:p-8 space-y-6 z-10 relative">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="glass-eco border-t border-eco-200/50 py-4 px-6 text-center text-xs text-slate-500 mt-auto z-10">
        <p>GreenTech &copy; Plataforma de Gestión Sostenible. Desarrollado con Laravel.</p>
    </footer>

    <!-- Chatbot GreenBot Component (Solo para Usuario General) -->
    @if(request()->is('/'))
        <x-greenbot />
    @endif

    <!-- Scripts Base -->
    <script>
        function showToast(title, message, type = 'info') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            
            let colorClasses, iconClass;

            if (type === 'success') {
                colorClasses = 'border-eco-200 text-eco-800 bg-eco-50';
                iconClass = 'fa-leaf text-eco-500';
            } else if (type === 'warning') {
                colorClasses = 'border-amber-200 text-amber-800 bg-amber-50';
                iconClass = 'fa-triangle-exclamation text-amber-500';
            } else {
                colorClasses = 'border-teal-200 text-teal-800 bg-teal-50';
                iconClass = 'fa-info-circle text-teal-500';
            }

            toast.className = `pointer-events-auto flex items-start gap-3 p-3.5 rounded-xl border shadow-xl ${colorClasses} text-xs max-w-sm transition-all duration-300 transform translate-y-2 glass-eco`;
            toast.innerHTML = `
                <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center shrink-0 shadow-sm border border-slate-100 mt-0.5">
                    <i class="fa-solid ${iconClass} text-sm"></i>
                </div>
                <div class="flex-1 pt-1">
                    <h5 class="font-bold text-slate-900 text-xs">${title}</h5>
                    <p class="text-slate-600 text-[11px] mt-0.5">${message}</p>
                </div>
            `;

            container.appendChild(toast);
            setTimeout(() => toast.classList.remove('translate-y-2'), 10);
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        }
    </script>
    @stack('scripts')
</body>
</html>
