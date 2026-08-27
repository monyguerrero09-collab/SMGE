<!-- =========================================================
     GREENBOT - CHATBOT DE GREENTECH (Laravel Blade Component)
     Adaptado al tema luminoso / eco
     ========================================================= -->

<!-- BOTÓN FLOTANTE -->
<button id="greenBotButton" class="fixed right-6 bottom-6 w-14 h-14 rounded-full bg-gradient-to-tr from-eco-600 to-eco-400 text-white shadow-lg shadow-eco-500/30 flex items-center justify-center text-2xl z-50 hover:scale-110 transition-transform" onclick="toggleGreenBot()">
    <i class="fa-solid fa-leaf"></i>
</button>

<!-- VENTANA DEL CHATBOT -->
<div id="greenBot" class="fixed right-6 bottom-24 w-80 md:w-96 h-[500px] glass-eco bg-white/95 rounded-2xl flex-col hidden z-50 shadow-2xl overflow-hidden border border-eco-200" style="animation: greenbotOpen 0.3s ease;">

    <!-- ENCABEZADO -->
    <div class="bg-gradient-to-tr from-eco-700 to-eco-500 text-white p-4 flex justify-between items-center shrink-0">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur flex items-center justify-center text-xl shadow-inner border border-white/20">
                <i class="fa-solid fa-robot"></i>
            </div>
            <div>
                <h3 class="font-bold text-sm m-0 leading-tight">GreenBot</h3>
                <span class="text-xs text-eco-100 flex items-center gap-1.5 mt-0.5 font-medium">
                    <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                    Asistente Inteligente
                </span>
            </div>
        </div>
        <button class="text-white hover:text-eco-100 text-xl w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white/10 transition-colors" onclick="toggleGreenBot()">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <!-- MENSAJES -->
    <div id="greenBotMessages" class="flex-1 p-4 overflow-y-auto bg-slate-50/50 flex flex-col gap-4">
        
        <!-- MENSAJE INICIAL -->
        <div class="flex gap-2.5 max-w-[85%]">
            <div class="w-8 h-8 rounded-full bg-eco-100 text-eco-600 flex items-center justify-center text-sm shrink-0 mt-1 border border-eco-200">
                <i class="fa-solid fa-leaf"></i>
            </div>
            <div>
                <div class="text-[10px] text-slate-500 font-medium mb-1 ml-1">GreenBot</div>
                <div class="bg-white border border-slate-200 p-3 rounded-2xl rounded-tl-sm text-xs text-slate-700 leading-relaxed shadow-sm">
                    ¡Hola! 👋 Soy <strong>GreenBot</strong>, tu asistente de eficiencia energética.
                    <br><br>
                    Puedo ayudarte a entender tus datos de consumo o darte recomendaciones de ahorro. ¿En qué te ayudo?
                </div>
            </div>
        </div>

        <!-- OPCIONES SUGERIDAS -->
        <div class="flex flex-col gap-2 pl-10 mt-1">
            <button onclick="greenBotQuestion('consumo')" class="text-left text-xs bg-white border border-eco-200 text-eco-700 font-medium hover:bg-eco-50 hover:border-eco-300 px-3 py-2 rounded-xl transition-colors shadow-sm">
                ⚡ ¿Cuánto estoy consumiendo?
            </button>
            <button onclick="greenBotQuestion('watts')" class="text-left text-xs bg-white border border-eco-200 text-eco-700 font-medium hover:bg-eco-50 hover:border-eco-300 px-3 py-2 rounded-xl transition-colors shadow-sm">
                💡 ¿Qué son los watts?
            </button>
            <button onclick="greenBotQuestion('ahorro')" class="text-left text-xs bg-white border border-eco-200 text-eco-700 font-medium hover:bg-eco-50 hover:border-eco-300 px-3 py-2 rounded-xl transition-colors shadow-sm">
                🌱 ¿Cómo puedo ahorrar?
            </button>
        </div>

    </div>

    <!-- INDICADOR DE ESCRITURA -->
    <div id="greenBotTyping" class="px-4 py-2 text-[10px] text-slate-400 font-medium hidden bg-slate-50/50">
        <i class="fa-solid fa-circle text-[6px] animate-pulse"></i>
        <i class="fa-solid fa-circle text-[6px] animate-pulse delay-75"></i>
        <i class="fa-solid fa-circle text-[6px] animate-pulse delay-150"></i>
        GreenBot está analizando...
    </div>

    <!-- INPUT AREA -->
    <div class="p-3 border-t border-slate-200 bg-white flex gap-2 shrink-0">
        <input type="text" id="greenBotInput" placeholder="Escribe tu consulta..." class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-800 focus:outline-none focus:border-eco-500 focus:ring-1 focus:ring-eco-500 transition-all" autocomplete="off" onkeydown="if(event.key === 'Enter') sendGreenBotMessage()">
        <button onclick="sendGreenBotMessage()" class="w-10 h-10 rounded-xl bg-eco-600 hover:bg-eco-700 text-white flex items-center justify-center transition-colors shadow-md">
            <i class="fa-solid fa-paper-plane"></i>
        </button>
    </div>

</div>

@push('styles')
<style>
    @keyframes greenbotOpen {
        from { opacity: 0; transform: translateY(15px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
</style>
@endpush

@push('scripts')
<script>
    function toggleGreenBot() {
        const bot = document.getElementById("greenBot");
        if(bot.classList.contains('hidden')) {
            bot.classList.remove('hidden');
            bot.classList.add('flex');
        } else {
            bot.classList.add('hidden');
            bot.classList.remove('flex');
        }
    }

    function sendGreenBotMessage() {
        const input = document.getElementById("greenBotInput");
        const message = input.value.trim();
        if (!message) return;

        addUserMessage(message);
        input.value = "";
        
        document.getElementById("greenBotTyping").classList.remove('hidden');
        scrollGreenBot();

        setTimeout(() => {
            document.getElementById("greenBotTyping").classList.add('hidden');
            const response = generateGreenBotResponse(message);
            addBotMessage(response);
        }, 800);
    }

    function addUserMessage(message) {
        const container = document.getElementById("greenBotMessages");
        const msgHtml = `
            <div class="flex gap-2.5 max-w-[85%] self-end flex-row-reverse">
                <div class="w-8 h-8 rounded-full bg-slate-800 text-white flex items-center justify-center text-xs shrink-0 mt-1 shadow-md">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div>
                    <div class="text-[10px] text-slate-500 font-medium mb-1 mr-1 text-right">Tú</div>
                    <div class="bg-slate-800 p-3 rounded-2xl rounded-tr-sm text-xs text-white leading-relaxed shadow-sm">
                        ${escapeHTML(message)}
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', msgHtml);
        scrollGreenBot();
    }

    function addBotMessage(message) {
        const container = document.getElementById("greenBotMessages");
        const msgHtml = `
            <div class="flex gap-2.5 max-w-[85%]">
                <div class="w-8 h-8 rounded-full bg-eco-100 text-eco-600 flex items-center justify-center text-sm shrink-0 mt-1 border border-eco-200">
                    <i class="fa-solid fa-leaf"></i>
                </div>
                <div>
                    <div class="text-[10px] text-slate-500 font-medium mb-1 ml-1">GreenBot</div>
                    <div class="bg-white border border-slate-200 p-3 rounded-2xl rounded-tl-sm text-xs text-slate-700 leading-relaxed shadow-sm">
                        ${message}
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', msgHtml);
        scrollGreenBot();
    }

    function greenBotQuestion(type) {
        let question = "";
        if(type === 'consumo') question = "¿Cuánto estoy consumiendo?";
        if(type === 'watts') question = "¿Qué son los watts?";
        if(type === 'ahorro') question = "¿Cómo puedo ahorrar energía?";
        
        addUserMessage(question);
        document.getElementById("greenBotTyping").classList.remove('hidden');
        scrollGreenBot();

        setTimeout(() => {
            document.getElementById("greenBotTyping").classList.add('hidden');
            addBotMessage(generateGreenBotResponse(question));
        }, 800);
    }

    function generateGreenBotResponse(message) {
        const text = message.toLowerCase();
        
        if (text.includes("consumo") || text.includes("estoy consumiendo")) {
            return `⚡ <strong>Tu consumo eléctrico actual:</strong><br><br>En el dashboard puedes ver el flujo en tiempo real (aproximadamente 2.4 kW). <br><br>🟢 <span class="text-eco-600 font-bold">Nivel actual: Normal.</span><br>El dispositivo de mayor demanda suele ser el Aire Acondicionado.`;
        }
        if (text.includes("watt") || text.includes("potencia")) {
            return `💡 <strong>¿Qué son los Watts (W)?</strong><br><br>Indican cuánta <strong>potencia</strong> está utilizando un dispositivo en el momento.<br><br>Ejemplo:<br>Foco LED → pocos Watts<br>Aire Acondicionado → muchos Watts`;
        }
        if (text.includes("ahorro") || text.includes("ahorrar")) {
            return `🌱 <strong>Consejos de ahorro:</strong><br><br>1. Apaga luces innecesarias.<br>2. Revisa el consumo en reposo (standby).<br>3. En <strong>GreenTech</strong> te sugiero activar el 'Modo Eco' en tu climatización para un ahorro del 30%.`;
        }
        if (text.includes("alto") || text.includes("mucho")) {
            return `⚠️ Si notas picos altos en la gráfica, suele deberse al encendido de motores (refrigerador o bombas). GreenTech te enviará una alerta si superas tu umbral seguro.`;
        }
        
        return `🌱 Entiendo tu consulta. <br><br>Por ahora me especializo en explicarte datos de consumo, watts y darte tips de ahorro. ¿Quieres saber sobre los Watts o el Consumo?`;
    }

    function scrollGreenBot() {
        const container = document.getElementById("greenBotMessages");
        setTimeout(() => { container.scrollTop = container.scrollHeight; }, 50);
    }

    function escapeHTML(text) {
        const div = document.createElement("div");
        div.textContent = text;
        return div.innerHTML;
    }
</script>
@endpush
