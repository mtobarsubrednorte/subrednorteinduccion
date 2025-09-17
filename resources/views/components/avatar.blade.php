<div>
  <canvas id="avatar"></canvas>

  <!-- <div class="actions-container">
    <h2 class="actions-title">Acciones Activas</h2>
    <div class="actions">
      <button id="actionsFlickUp" class="active">Feliz</button>
      <button id="actionsTap" class="active">Aceptación</button>
      <button id="actionsFlickDown" class="active">Bailar</button>
      <button id="actionsRaiseArms" class="active">Dime un chiste</button>
      <button id="saludar" class="active">Saludar</button>
    </div>
  </div> -->

  <button class="open-chat-btn" id="openChatBtn">💬</button>
  <div class="chat-container" id="chatContainer">
    <div class="chat-header">
      <h3 class="chat-title">Chat con el Avatar</h3>
      <button class="close-chat" id="closeChatBtn">×</button>
    </div>
    <div class="chat-box" id="chatBox"></div>
    <div class="chat-input-container">
      <input type="text" id="chatInput" placeholder="Escribe tu mensaje...">
      <button id="sendButton">Enviar</button>
    </div>
  </div>

  {{-- Estilos --}}
  <link rel="stylesheet" href="{{ asset('avatar/avatar.css') }}">

  {{-- Scripts --}}
  <script src="https://cubism.live2d.com/sdk-web/cubismcore/live2dcubismcore.min.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/dylanNew/live2d/webgl/Live2D/lib/live2d.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/pixi.js@6.5.2/dist/browser/pixi.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/pixi-live2d-display/dist/index.min.js"></script>
  <script src="{{ asset('avatar/avatar.js') }}"></script>
</div>
