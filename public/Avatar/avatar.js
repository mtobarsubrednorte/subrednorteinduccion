const AVATAR_CONFIG = {
  canvas: {
    width: 280,
    height: 420,
    backgroundAlpha: 0
  },
  model: {
    originalWidth: 1000,
    originalHeight: 1000,
    baseScale: 0.8,
    position: {
      x: -250,
      y: -260
    },
    scaleReduction: 0.9
  },
  motion: {
    idle: "Idle",
    flickUp: "FlickUp",
    tap: "Tap",
    flickDown: "FlickDown",
    raiseArms: "RaiseArms",
    Hablar: "Hablar"
  }
};

// Configuración de la IA
const AI_ENABLED = true;
const AI_API_KEY = "AIzaSyA_plcSjhzinb_6_JdwBr8J7kLY9vU--1g";
const AI_ENDPOINT = `https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=${AI_API_KEY}`;

let conversationHistory = [];
const MAX_HISTORY = 5;

// Inicialización de PIXI
const app = new PIXI.Application({
  view: document.getElementById("avatar"),
  autoStart: true,
  backgroundAlpha: AVATAR_CONFIG.canvas.backgroundAlpha,
  width: AVATAR_CONFIG.canvas.width,
  height: AVATAR_CONFIG.canvas.height,
  resolution: window.devicePixelRatio || 1
});

let model;

// Configuración del modelo
const setupModel = () => {
  if (!model) return;
  const { originalWidth, originalHeight, baseScale, scaleReduction, position } = AVATAR_CONFIG.model;
  const { width: targetWidth, height: targetHeight } = app.screen;
  const scaleX = (targetWidth / originalWidth) * baseScale;
  const scaleY = (targetHeight / originalHeight) * baseScale;
  const scale = Math.min(scaleX, scaleY) * scaleReduction;
  model.scale.set(scale, scale);
  model.x = (targetWidth / 2) + position.x;
  model.y = (targetHeight / 2) + position.y;
};


// Control de animaciones
const startMotion = (motionName) => {
  if (!model?.internalModel) return;
  model.internalModel.motionManager.stopAllMotions();
  model.motion(motionName);
};

// Función para reproducir audio
function playAudio(filePath) {
  const audio = new Audio(filePath);
  audio.play().catch(err => console.error("Error al reproducir audio:", err));
}

// Funciones de IA
async function getAIResponse(message) {
  if (!AI_ENABLED) return "La IA está desactivada";

  try {
    conversationHistory.push({ role: "user", content: message });

    if (conversationHistory.length > MAX_HISTORY) {
      conversationHistory = conversationHistory.slice(-MAX_HISTORY);
    }

    const response = await fetch(AI_ENDPOINT, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        contents: [{ parts: [{ text: message }] }]
      })
    });

    const data = await response.json();
    const aiMessage = data.candidates[0].content.parts[0].text;

    conversationHistory.push({ role: "assistant", content: aiMessage });
    return aiMessage;
  } catch (error) {
    console.error("Error con Gemini:", error);
    return "Ups, no pude pensar en nada ahora mismo.";
  }
}

function listVoices() {
  const voices = window.speechSynthesis.getVoices();
  console.log("Voces disponibles:", voices);
}
// Las voces se cargan asíncronamente, necesitas esperar a que estén listas:
speechSynthesis.onvoiceschanged = listVoices;

// Síntesis de voz
function speak(text) {
  return new Promise((resolve) => {
    if (!window.speechSynthesis) {
      console.warn("Tu navegador no soporta síntesis de voz.");
      return resolve(); // Resuelve la promesa inmediatamente si no hay soporte
    }

    // Esperar a que las voces estén cargadas (necesario en algunos navegadores)
    const voices = speechSynthesis.getVoices();
    if (voices.length === 0) {
      speechSynthesis.onvoiceschanged = () => {
        speak(text).then(resolve); // Reintentar y resolver cuando las voces estén listas
      };
      return;
    }

    const utterance = new SpeechSynthesisUtterance(text);

    // Configuración de voz
    utterance.lang = 'es-ES';
    utterance.rate = 1.1;
    utterance.pitch = 1.3;
    utterance.volume = 1;

    // Seleccionar voz específica
    const desiredVoice = voices.find(voice =>
      voice.lang === 'es-ES' && voice.name.includes('Microsoft Pablo - Spanish (Spain)')
    );
    if (desiredVoice) {
      utterance.voice = desiredVoice;
    }

    // Cuando termine el audio, resolver la promesa
    utterance.onend = () => resolve();
    utterance.onerror = (error) => {
      console.error("Error al reproducir voz:", error);
      resolve(); // Asegurarse de resolver incluso si hay error
    };

    // Reproducir
    window.speechSynthesis.speak(utterance);
  });
}

// Control del chat
function setupChat() {
  const chatContainer = document.getElementById('chatContainer');
  const chatBox = document.getElementById('chatBox');
  const chatInput = document.getElementById('chatInput');
  const sendButton = document.getElementById('sendButton');
  const openChatBtn = document.getElementById('openChatBtn');
  const closeChatBtn = document.getElementById('closeChatBtn');

  function addMessage(role, message) {
    const messageElement = document.createElement('div');
    messageElement.className = `message ${role}`;
    messageElement.textContent = message;
    chatBox.appendChild(messageElement);
    chatBox.scrollTop = chatBox.scrollHeight;

    if (role === 'assistant') {
      let motionInterval;

      // Iniciar animación en bucle
      const startAnimationLoop = () => {
        motionInterval = setInterval(() => {
          startMotion(AVATAR_CONFIG.motion.Hablar);
        }, 800); // Repetir cada 800 milisegundos (ajusta según la duración de tu animación)
      };

      // Detener animación y volver a "idle"
      const stopAnimationLoop = () => {
        clearInterval(motionInterval);
        startMotion(AVATAR_CONFIG.motion.idle);
      };

      // Iniciar el bucle de animación
      startAnimationLoop();

      // Reproducir voz y detener animación cuando termine
      speak(message).then(stopAnimationLoop);
    }
  }

  async function sendMessage() {
    const message = chatInput.value.trim();
    if (!message) return;

    addMessage('user', message);
    chatInput.value = '';

    const response = await getAIResponse(message);
    addMessage('assistant', response);
  }

  // Event listeners
  chatInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') sendMessage();
  });

  sendButton.addEventListener('click', sendMessage);
  openChatBtn.addEventListener('click', () => {
    chatContainer.style.display = 'flex';
    chatInput.focus();
  });
  closeChatBtn.addEventListener('click', () => {
    chatContainer.style.display = 'none';
  });
}

// Cargar modelo Live2D
PIXI.live2d.Live2DModel.from("/Avatar/assets/Haru/mark_free_en/runtime/mark_free_t04.model3.json")
  .then((loadedModel) => {
    model = loadedModel;
    app.stage.addChild(model);
    setupModel();
    startMotion(AVATAR_CONFIG.motion.idle);

    if (AI_ENABLED) {
      setupChat();
      // Mensaje inicial del avatar
      setTimeout(() => {
        const welcomeMessage = "¡Hola!";
        document.getElementById('chatBox').innerHTML = `
          <div class="message assistant">${welcomeMessage}</div>
        `;
        speak(welcomeMessage);
      }, 1000);
    }
  })
  .catch(console.error);


async function sendSpecificMessage(message) {
  let motionInterval;
  const chatBox = document.getElementById('chatBox');

  // Agrega el mensaje como si fuera del usuario (aunque es una acción del botón)
  const messageElement = document.createElement('div');
  messageElement.className = 'message user';
  messageElement.textContent = message;
  chatBox.appendChild(messageElement);
  chatBox.scrollTop = chatBox.scrollHeight;

  // Obtiene la respuesta de la IA
  const response = await getAIResponse(message);




  // Agrega la respuesta del asistente
  const responseElement = document.createElement('div');
  responseElement.className = 'message assistant';
  responseElement.textContent = response;
  chatBox.appendChild(responseElement);
  chatBox.scrollTop = chatBox.scrollHeight;


  // Iniciar animación en bucle
  const startAnimationLoop = () => {
    motionInterval = setInterval(() => {
      startMotion(AVATAR_CONFIG.motion.Hablar);
    }, 1000); // Repetir cada 1 segundo (ajusta según la duración de tu animación)
  };
  // Detener animación y volver a "idle"
  const stopAnimationLoop = () => {
    clearInterval(motionInterval);
    startMotion(AVATAR_CONFIG.motion.idle);
  };
  // Iniciar el bucle de animación
  startAnimationLoop();
  // Reproducir voz y detener animación cuando termine
  speak(response).then(stopAnimationLoop);
}

// Event listeners para botones de acción
document.getElementById("actionsFlickUp").addEventListener("click", () => {
  startMotion(AVATAR_CONFIG.motion.raiseArms)
  // reproducir sonido
  const audio = new Audio("/avatar/audios/Hola.mp3");
  audio.play();
});
document.getElementById("actionsTap").addEventListener("click", () => startMotion(AVATAR_CONFIG.motion.tap));
document.getElementById("actionsFlickDown").addEventListener("click", () => startMotion(AVATAR_CONFIG.motion.flickDown));
document.getElementById("actionsRaiseArms").addEventListener("click", () => {
  sendSpecificMessage("Cuentame un chiste que tenga que ver con la secretaria de la salud");
  startMotion(AVATAR_CONFIG.motion.Hablar);
  centerEyes();

});



document.getElementById("saludar").addEventListener("click", () => startMotion("Saludar"));