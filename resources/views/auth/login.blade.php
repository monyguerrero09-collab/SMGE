<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GreenTech — Acceso a la Plataforma Ecológica</title>
  
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  
  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- FontAwesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'sans-serif'],
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
          },
          animation: {
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

  <style>
    /* Efecto de degradado orgánico suave en el fondo */
    body {
      background: radial-gradient(circle at 10% 20%, #E9F6EE 0%, #F5FAF6 45%, #E3F2E9 100%);
      min-height: 100vh;
    }

    /* Desenfoque de cristal ecológico */
    .glass-eco {
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border: 1px solid rgba(167, 243, 208, 0.5);
    }

    .glass-card-eco {
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.8);
    }
  </style>
</head>
<body class="font-sans text-slate-800 antialiased flex items-center justify-center min-h-screen p-4 sm:p-6 lg:p-8 relative overflow-x-hidden">

  <!-- Elementos decorativos de fondo -->
  <div class="fixed top-[-10%] left-[-5%] w-96 h-96 bg-emerald-200/40 rounded-full blur-3xl pointer-events-none animate-pulse-subtle"></div>
  <div class="fixed bottom-[-10%] right-[-5%] w-[32rem] h-[32rem] bg-teal-200/40 rounded-full blur-3xl pointer-events-none animate-pulse-subtle"></div>
  
  <div class="fixed top-12 left-10 text-eco-400/30 text-5xl pointer-events-none animate-float-slow hidden md:block">
    <i class="fa-solid fa-leaf"></i>
  </div>
  <div class="fixed bottom-16 left-1/4 text-eco-300/30 text-4xl pointer-events-none animate-float-delayed hidden md:block">
    <i class="fa-solid fa-seedling"></i>
  </div>
  <div class="fixed top-1/3 right-12 text-teal-400/20 text-6xl pointer-events-none animate-float-slow hidden md:block">
    <i class="fa-solid fa-wind"></i>
  </div>

  <main class="w-full max-w-5xl glass-eco rounded-3xl shadow-2xl shadow-emerald-950/10 overflow-hidden border border-emerald-100 z-10 transition-all duration-300">
    <div class="grid grid-cols-1 lg:grid-cols-12 min-h-[640px]">
      
      <section class="lg:col-span-5 bg-gradient-to-br from-eco-600 via-eco-700 to-teal-800 p-8 sm:p-10 text-white flex flex-col justify-between relative overflow-hidden">
        <div class="absolute -right-16 -top-16 w-60 h-60 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
        <div class="absolute -left-12 -bottom-12 w-48 h-48 bg-emerald-400/20 rounded-full blur-lg pointer-events-none"></div>
        
        <div class="relative z-10">
          <div class="flex items-center gap-3 mb-6">
            <div class="w-11 h-11 rounded-2xl bg-white/15 backdrop-blur-md flex items-center justify-center text-emerald-300 border border-white/20 shadow-inner text-xl">
              <i class="fa-solid fa-seedling"></i>
            </div>
            <div>
              <span class="text-2xl font-black tracking-tight text-white flex items-center gap-1.5">
                Green<span class="text-emerald-300 font-extrabold">Tech</span>
              </span>
              <p class="text-[11px] font-medium tracking-widest text-emerald-200/80 uppercase">Tecnología Sostenible</p>
            </div>
          </div>

          <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs text-emerald-200 font-medium mb-6">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
            Plataforma 100% Cero Emisiones
          </div>

          <h1 class="text-2xl sm:text-3xl font-bold leading-tight mb-3 text-white">
            Impulsa tus operaciones con inteligencia ambiental.
          </h1>
          <p class="text-emerald-100/80 text-sm leading-relaxed">
            Monitoriza la huella de carbono, optimiza recursos renovables y lidera la transición hacia un modelo de negocio regenerativo.
          </p>
        </div>

        <div class="relative z-10 my-8">
          <div class="glass-card-eco rounded-2xl p-4 bg-white/10 border-white/15 text-white shadow-lg space-y-3">
            <div class="flex items-center justify-between text-xs text-emerald-200 font-medium">
              <span class="flex items-center gap-1.5">
                <i class="fa-solid fa-chart-line text-emerald-300"></i> Impacto Colectivo
              </span>
              <span class="bg-emerald-400/20 text-emerald-300 px-2 py-0.5 rounded-full text-[11px] font-semibold">En tiempo real</span>
            </div>
            <div class="grid grid-cols-2 gap-3 pt-1">
              <div class="bg-black/10 rounded-xl p-2.5 border border-white/10">
                <p class="text-[11px] text-emerald-200/90 font-medium">CO₂ Mitigado</p>
                <p class="text-lg font-bold text-white tracking-tight">428.5 <span class="text-xs font-normal text-emerald-300">Ton</span></p>
              </div>
              <div class="bg-black/10 rounded-xl p-2.5 border border-white/10">
                <p class="text-[11px] text-emerald-200/90 font-medium">Energía Limpia</p>
                <p class="text-lg font-bold text-white tracking-tight">98.2 <span class="text-xs font-normal text-emerald-300">%</span></p>
              </div>
            </div>
          </div>
        </div>

        <div class="relative z-10 text-xs text-emerald-200/75 flex items-center justify-between pt-4 border-t border-white/10">
          <span class="flex items-center gap-1.5">
            <i class="fa-solid fa-shield-halved text-emerald-300"></i> Seguridad de grado bancario
          </span>
          <span>v3.0 EcoCore</span>
        </div>
      </section>

      <section class="lg:col-span-7 p-6 sm:p-10 lg:p-12 flex flex-col justify-center bg-white/70">
        
        <div class="flex p-1.5 bg-eco-100/70 rounded-2xl mb-8 max-w-sm mx-auto w-full border border-eco-200/50">
          <button 
            id="tabLoginBtn" 
            onclick="switchTab('login')" 
            class="flex-1 py-2.5 text-xs sm:text-sm font-semibold rounded-xl transition-all duration-200 flex items-center justify-center gap-2 bg-white text-eco-800 shadow-md shadow-eco-900/5">
            <i class="fa-solid fa-arrow-right-to-bracket text-eco-600"></i> Iniciar Sesión
          </button>
          <button 
            id="tabRegisterBtn" 
            onclick="switchTab('register')" 
            class="flex-1 py-2.5 text-xs sm:text-sm font-semibold rounded-xl transition-all duration-200 flex items-center justify-center gap-2 text-slate-600 hover:text-eco-700">
            <i class="fa-solid fa-user-plus"></i> Registrarse
          </button>
        </div>

        <div id="loginFormContainer" class="transition-opacity duration-300">
          <div class="mb-6 text-center sm:text-left">
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight flex items-center justify-center sm:justify-start gap-2">
              ¡Hola de nuevo! <span class="text-2xl">🌱</span>
            </h2>
            <p class="text-sm text-slate-500 mt-1">Ingresa tus credenciales para acceder a tu panel ecológico.</p>
          </div>

          <form id="loginForm" onsubmit="handleLogin(event)" class="space-y-4">
            <div>
              <label for="loginEmail" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                Correo Electrónico
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                  <i class="fa-regular fa-envelope"></i>
                </div>
                <input 
                  type="email" 
                  id="loginEmail" 
                  required 
                  placeholder="admin@greentech.eco"
                  class="w-full pl-10 pr-4 py-3 bg-white/90 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-eco-500 focus:border-eco-500 transition-all text-slate-800 placeholder-slate-400 shadow-sm"
                />
              </div>
            </div>

            <div>
              <div class="flex items-center justify-between mb-1.5">
                <label for="loginPassword" class="block text-xs font-bold uppercase tracking-wider text-slate-600">
                  Contraseña
                </label>
                <button type="button" onclick="openForgotPasswordModal()" class="text-xs font-semibold text-eco-600 hover:text-eco-700 hover:underline">
                  ¿Olvidaste tu contraseña?
                </button>
              </div>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                  <i class="fa-solid fa-lock"></i>
                </div>
                <input 
                  type="password" 
                  id="loginPassword" 
                  required 
                  placeholder="••••••••••••"
                  class="w-full pl-10 pr-11 py-3 bg-white/90 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-eco-500 focus:border-eco-500 transition-all text-slate-800 placeholder-slate-400 shadow-sm"
                />
                <button 
                  type="button" 
                  onclick="togglePasswordVisibility('loginPassword', 'loginEyeIcon')"
                  class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                  <i id="loginEyeIcon" class="fa-regular fa-eye"></i>
                </button>
              </div>
            </div>

            <div class="flex items-center justify-between pt-1">
              <label class="flex items-center gap-2.5 cursor-pointer text-sm text-slate-600 select-none">
                <input type="checkbox" class="w-4 h-4 rounded text-eco-600 focus:ring-eco-500 border-slate-300 cursor-pointer accent-eco-600">
                <span>Recordar este dispositivo</span>
              </label>
            </div>

            <button 
              type="submit" 
              id="loginSubmitBtn"
              class="w-full mt-2 py-3.5 px-4 bg-eco-600 hover:bg-eco-700 text-white font-semibold rounded-xl text-sm shadow-lg shadow-eco-600/25 hover:shadow-eco-700/35 transition-all duration-200 transform active:scale-[0.99] flex items-center justify-center gap-2">
              <span>Ingresar a GreenTech</span>
              <i class="fa-solid fa-arrow-right"></i>
            </button>
          </form>

          <div class="mt-6">
            <div class="relative flex items-center justify-center">
              <div class="border-t border-slate-200 w-full"></div>
              <span class="bg-white/80 px-3 text-xs text-slate-500 font-medium absolute">o continúa con</span>
            </div>

            <div class="grid grid-cols-2 gap-3 mt-4">
              <button 
                type="button" 
                onclick="showNotification('Conectando con Google Enterprise...', 'info')"
                class="flex items-center justify-center gap-2 py-2.5 px-4 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 hover:border-slate-300 transition-all shadow-sm">
                <i class="fa-brands fa-google text-red-500"></i>
                <span>Google</span>
              </button>
              <button 
                type="button" 
                onclick="showNotification('Conectando con Microsoft Azure...', 'info')"
                class="flex items-center justify-center gap-2 py-2.5 px-4 bg-white hover:bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 hover:border-slate-300 transition-all shadow-sm">
                <i class="fa-brands fa-microsoft text-blue-500"></i>
                <span>Microsoft</span>
              </button>
            </div>
          </div>
        </div>

        <div id="registerFormContainer" class="hidden transition-opacity duration-300">
          <div class="mb-5 text-center sm:text-left">
            <h2 class="text-2xl font-bold text-slate-900 tracking-tight flex items-center justify-center sm:justify-start gap-2">
              Crea tu cuenta verde <span class="text-2xl">🌿</span>
            </h2>
            <p class="text-sm text-slate-500 mt-1">Únete a la red global de organizaciones sostenibles.</p>
          </div>

          <form id="registerForm" onsubmit="handleRegister(event)" class="space-y-3.5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
              <div>
                <label for="regName" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">
                  Nombre
                </label>
                <input type="text" id="regName" required placeholder="Ana Valenzuela" class="w-full px-3.5 py-2.5 bg-white/90 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-eco-500 focus:border-eco-500 transition-all text-slate-800 placeholder-slate-400 shadow-sm" />
              </div>
              <div>
                <label for="regOrg" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">
                  Organización / Eco-Proyecto
                </label>
                <input type="text" id="regOrg" placeholder="EcoLogistics S.A." class="w-full px-3.5 py-2.5 bg-white/90 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-eco-500 focus:border-eco-500 transition-all text-slate-800 placeholder-slate-400 shadow-sm" />
              </div>
            </div>

            <div>
              <label for="regEmail" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">
                Correo Corporativo o Personal
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                  <i class="fa-regular fa-envelope"></i>
                </div>
                <input type="email" id="regEmail" required placeholder="ana@empresa.com" class="w-full pl-10 pr-4 py-2.5 bg-white/90 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-eco-500 focus:border-eco-500 transition-all text-slate-800 placeholder-slate-400 shadow-sm" />
              </div>
            </div>

            <div>
              <label for="regPassword" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">
                Crear Contraseña
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                  <i class="fa-solid fa-lock"></i>
                </div>
                <input type="password" id="regPassword" required placeholder="Mínimo 8 caracteres" oninput="checkPasswordStrength(this.value)" class="w-full pl-10 pr-11 py-2.5 bg-white/90 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-eco-500 focus:border-eco-500 transition-all text-slate-800 placeholder-slate-400 shadow-sm" />
                <button type="button" onclick="togglePasswordVisibility('regPassword', 'regEyeIcon')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                  <i id="regEyeIcon" class="fa-regular fa-eye"></i>
                </button>
              </div>

              <div class="mt-2 space-y-1">
                <div class="flex items-center justify-between text-[11px]">
                  <span class="text-slate-500 font-medium">Seguridad de la clave:</span>
                  <span id="strengthLabel" class="font-semibold text-slate-500">Pendiente</span>
                </div>
                <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden flex gap-1">
                  <div id="bar1" class="h-full w-1/4 bg-slate-200 transition-all duration-300"></div>
                  <div id="bar2" class="h-full w-1/4 bg-slate-200 transition-all duration-300"></div>
                  <div id="bar3" class="h-full w-1/4 bg-slate-200 transition-all duration-300"></div>
                  <div id="bar4" class="h-full w-1/4 bg-slate-200 transition-all duration-300"></div>
                </div>
              </div>
            </div>

            <div class="pt-1">
              <label class="flex items-start gap-2.5 cursor-pointer text-xs text-slate-600 select-none">
                <input type="checkbox" required class="w-4 h-4 mt-0.5 rounded text-eco-600 focus:ring-eco-500 border-slate-300 cursor-pointer accent-eco-600">
                <span>
                  Acepto los <a href="javascript:void(0)" onclick="showNotification('Términos de servicio ecológico', 'info')" class="text-eco-600 hover:underline font-semibold">Términos de Servicio</a> y el <a href="javascript:void(0)" onclick="showNotification('Compromiso de Privacidad y Carbono Cero', 'info')" class="text-eco-600 hover:underline font-semibold">Tratamiento de Datos Responsable</a>.
                </span>
              </label>
            </div>

            <button type="submit" id="registerSubmitBtn" class="w-full mt-3 py-3.5 px-4 bg-eco-600 hover:bg-eco-700 text-white font-semibold rounded-xl text-sm shadow-lg shadow-eco-600/25 hover:shadow-eco-700/35 transition-all duration-200 transform active:scale-[0.99] flex items-center justify-center gap-2">
              <i class="fa-solid fa-leaf"></i>
              <span>Crear Cuenta Gratuita</span>
            </button>
          </form>
        </div>

      </section>
    </div>
  </main>

  <div id="forgotModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-emerald-100 transform scale-95 transition-transform duration-300" id="forgotModalCard">
      <div class="w-12 h-12 bg-eco-100 text-eco-600 rounded-2xl flex items-center justify-center text-xl mb-4 mx-auto sm:mx-0">
        <i class="fa-solid fa-key"></i>
      </div>
      
      <h3 class="text-xl font-bold text-slate-900 mb-1 text-center sm:text-left">Recuperar Acceso</h3>
      <p class="text-sm text-slate-500 mb-5 text-center sm:text-left">
        Ingresa el correo electrónico asociado a tu cuenta de GreenTech y te enviaremos un enlace de restablecimiento seguro.
      </p>

      <form onsubmit="handleForgotPassword(event)" class="space-y-4">
        <div>
          <label for="resetEmail" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">
            Correo Registrado
          </label>
          <input type="email" id="resetEmail" required placeholder="ejemplo@greentech.eco" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-eco-500 focus:border-eco-500 transition-all text-slate-800" />
        </div>
        
        <div class="flex gap-3 pt-2">
          <button type="button" onclick="closeForgotPasswordModal()" class="flex-1 py-3 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-sm transition-all">
            Cancelar
          </button>
          <button type="submit" class="flex-1 py-3 px-4 bg-eco-600 hover:bg-eco-700 text-white font-semibold rounded-xl text-sm shadow-md shadow-eco-600/20 transition-all flex items-center justify-center gap-2">
            <span>Enviar Enlace</span>
            <i class="fa-solid fa-paper-plane text-xs"></i>
          </button>
        </div>
      </form>
    </div>
  </div>

  <div id="toastNotification" class="fixed bottom-5 right-5 z-50 transform translate-y-24 opacity-0 transition-all duration-300 max-w-sm w-full pointer-events-none">
    <div class="glass-eco bg-white/95 rounded-2xl p-4 shadow-xl border border-emerald-200 flex items-start gap-3 pointer-events-auto">
      <div id="toastIconContainer" class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 text-white bg-eco-600">
        <i id="toastIcon" class="fa-solid fa-check"></i>
      </div>
      <div class="flex-1 pr-2">
        <h4 id="toastTitle" class="text-xs font-bold text-slate-900 uppercase tracking-wide">Notificación</h4>
        <p id="toastMessage" class="text-xs text-slate-600 mt-0.5 leading-relaxed">Mensaje del sistema.</p>
      </div>
      <button onclick="hideNotification()" class="text-slate-400 hover:text-slate-600 text-sm">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>
  </div>

  <script>
    function switchTab(tab) {
      const tabLoginBtn = document.getElementById('tabLoginBtn');
      const tabRegisterBtn = document.getElementById('tabRegisterBtn');
      const loginFormContainer = document.getElementById('loginFormContainer');
      const registerFormContainer = document.getElementById('registerFormContainer');

      if (tab === 'login') {
        tabLoginBtn.className = "flex-1 py-2.5 text-xs sm:text-sm font-semibold rounded-xl transition-all duration-200 flex items-center justify-center gap-2 bg-white text-eco-800 shadow-md shadow-eco-900/5";
        tabRegisterBtn.className = "flex-1 py-2.5 text-xs sm:text-sm font-semibold rounded-xl transition-all duration-200 flex items-center justify-center gap-2 text-slate-600 hover:text-eco-700";
        loginFormContainer.classList.remove('hidden');
        registerFormContainer.classList.add('hidden');
      } else {
        tabRegisterBtn.className = "flex-1 py-2.5 text-xs sm:text-sm font-semibold rounded-xl transition-all duration-200 flex items-center justify-center gap-2 bg-white text-eco-800 shadow-md shadow-eco-900/5";
        tabLoginBtn.className = "flex-1 py-2.5 text-xs sm:text-sm font-semibold rounded-xl transition-all duration-200 flex items-center justify-center gap-2 text-slate-600 hover:text-eco-700";
        registerFormContainer.classList.remove('hidden');
        loginFormContainer.classList.add('hidden');
      }
    }

    function togglePasswordVisibility(inputId, iconId) {
      const input = document.getElementById(inputId);
      const icon = document.getElementById(iconId);
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }

    function checkPasswordStrength(password) {
      const strengthLabel = document.getElementById('strengthLabel');
      const bars = [document.getElementById('bar1'), document.getElementById('bar2'), document.getElementById('bar3'), document.getElementById('bar4')];
      bars.forEach(b => { b.className = 'h-full w-1/4 bg-slate-200 transition-all duration-300'; });
      if (!password) {
        strengthLabel.innerText = 'Pendiente';
        strengthLabel.className = 'font-semibold text-slate-400';
        return;
      }
      let score = 0;
      if (password.length >= 8) score++;
      if (/[A-Z]/.test(password)) score++;
      if (/[0-9]/.test(password)) score++;
      if (/[^A-Za-z0-9]/.test(password)) score++;

      if (score === 1) {
        strengthLabel.innerText = 'Débil';
        strengthLabel.className = 'font-semibold text-red-500';
        bars[0].className = 'h-full w-1/4 bg-red-500 transition-all duration-300';
      } else if (score === 2) {
        strengthLabel.innerText = 'Moderada';
        strengthLabel.className = 'font-semibold text-amber-500';
        bars[0].className = 'h-full w-1/4 bg-amber-500 transition-all duration-300';
        bars[1].className = 'h-full w-1/4 bg-amber-500 transition-all duration-300';
      } else if (score === 3) {
        strengthLabel.innerText = 'Buena';
        strengthLabel.className = 'font-semibold text-emerald-500';
        bars[0].className = 'h-full w-1/4 bg-emerald-500 transition-all duration-300';
        bars[1].className = 'h-full w-1/4 bg-emerald-500 transition-all duration-300';
        bars[2].className = 'h-full w-1/4 bg-emerald-500 transition-all duration-300';
      } else if (score === 4) {
        strengthLabel.innerText = 'Excelente (EcoSegura)';
        strengthLabel.className = 'font-semibold text-eco-600';
        bars[0].className = 'h-full w-1/4 bg-eco-600 transition-all duration-300';
        bars[1].className = 'h-full w-1/4 bg-eco-600 transition-all duration-300';
        bars[2].className = 'h-full w-1/4 bg-eco-600 transition-all duration-300';
        bars[3].className = 'h-full w-1/4 bg-eco-600 transition-all duration-300';
      }
    }

    function handleLogin(event) {
      event.preventDefault();
      const email = document.getElementById('loginEmail').value.toLowerCase();
      const btn = document.getElementById('loginSubmitBtn');
      
      btn.disabled = true;
      btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Autenticando...';

      let redirectUrl = '{{ url("/") }}';
      if (email.includes('admin')) {
          redirectUrl = '{{ url("/admin") }}';
      } else if (email.includes('empleado')) {
          redirectUrl = '{{ url("/employee") }}';
      }

      setTimeout(() => {
        btn.disabled = false;
        btn.innerHTML = '<span>Ingresar a GreenTech</span><i class="fa-solid fa-arrow-right"></i>';
        showNotification(`¡Bienvenido de nuevo! Redirigiendo a tu panel...`, 'success');
        
        setTimeout(() => {
            window.location.href = redirectUrl;
        }, 1000);
      }, 1200);
    }

    function handleRegister(event) {
      event.preventDefault();
      const name = document.getElementById('regName').value;
      const btn = document.getElementById('registerSubmitBtn');

      btn.disabled = true;
      btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Registrando entidad...';

      setTimeout(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-leaf"></i><span>Crear Cuenta Gratuita</span>';
        showNotification(`¡Cuenta creada con éxito para ${name}! Ya puedes iniciar sesión.`, 'success');
        
        setTimeout(() => {
          switchTab('login');
          document.getElementById('loginEmail').value = document.getElementById('regEmail').value;
        }, 1500);
      }, 1400);
    }

    function openForgotPasswordModal() {
      const modal = document.getElementById('forgotModal');
      const card = document.getElementById('forgotModalCard');
      modal.classList.remove('hidden');
      setTimeout(() => {
        modal.classList.remove('opacity-0');
        card.classList.remove('scale-95');
        card.classList.add('scale-100');
      }, 10);
    }

    function closeForgotPasswordModal() {
      const modal = document.getElementById('forgotModal');
      const card = document.getElementById('forgotModalCard');
      modal.classList.add('opacity-0');
      card.classList.remove('scale-100');
      card.classList.add('scale-95');
      setTimeout(() => {
        modal.classList.add('hidden');
      }, 300);
    }

    function handleForgotPassword(event) {
      event.preventDefault();
      const email = document.getElementById('resetEmail').value;
      closeForgotPasswordModal();
      setTimeout(() => {
        showNotification(`Enlace de restablecimiento enviado a ${email}.`, 'success');
      }, 350);
    }

    let toastTimeout;
    function showNotification(message, type = 'info') {
      const toast = document.getElementById('toastNotification');
      const toastTitle = document.getElementById('toastTitle');
      const toastMsg = document.getElementById('toastMessage');
      const toastIcon = document.getElementById('toastIcon');
      const iconContainer = document.getElementById('toastIconContainer');

      clearTimeout(toastTimeout);
      toastMsg.innerText = message;

      if (type === 'success') {
        toastTitle.innerText = 'Éxito';
        iconContainer.className = 'w-9 h-9 rounded-xl flex items-center justify-center shrink-0 text-white bg-eco-600 shadow-sm';
        toastIcon.className = 'fa-solid fa-leaf';
      } else if (type === 'error') {
        toastTitle.innerText = 'Atención';
        iconContainer.className = 'w-9 h-9 rounded-xl flex items-center justify-center shrink-0 text-white bg-amber-500 shadow-sm';
        toastIcon.className = 'fa-solid fa-triangle-exclamation';
      } else {
        toastTitle.innerText = 'Información';
        iconContainer.className = 'w-9 h-9 rounded-xl flex items-center justify-center shrink-0 text-white bg-teal-600 shadow-sm';
        toastIcon.className = 'fa-solid fa-info';
      }

      toast.classList.remove('translate-y-24', 'opacity-0');
      toast.classList.add('translate-y-0', 'opacity-100');

      toastTimeout = setTimeout(() => {
        hideNotification();
      }, 4500);
    }

    function hideNotification() {
      const toast = document.getElementById('toastNotification');
      toast.classList.remove('translate-y-0', 'opacity-100');
      toast.classList.add('translate-y-24', 'opacity-0');
    }
  </script>
</body>
</html>
