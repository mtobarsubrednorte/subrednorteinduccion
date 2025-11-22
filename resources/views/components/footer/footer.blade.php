<style>
  /* Estilo general del pie de página */
  .mi-footer-personalizado {
    text-align: center;
    color: #8b8686;
    font-family: sans-serif;
    padding: 30px 15px;
    font-size: 14px;

    /* O el color de fondo que uses */
  }

  /* CONTENEDOR FLEX: Esto es lo que crea las dos columnas */
  .contenedor-columnas {
    display: flex;
    /* <--- ESTO PONE LOS ELEMENTOS DE LADO */
    justify-content: center;
    /* Centra el grupo en la pantalla */
    align-items: flex-start;
    /* Alinea el contenido arriba */
    gap: 60px;
    /* Espacio libre entre la columna izq y der */
    margin-top: 20px;
    margin-bottom: 30px;
    flex-wrap: wrap;
    /* Para que no se rompa en pantallas muy chicas */
  }

  /* Estilo de cada columna individual */
  .columna-footer {
    text-align: center;
    max-width: 350px;
    /* Controla que tan ancha puede ser cada columna */
  }

  /* Títulos azules */
  .titulo-azul {
    color: #007bff;
    font-weight: bold;
    font-size: 16px;
    margin-top: 15px;
    margin-bottom: 5px;
    display: block;
  }

  /* Nombres */
  .nombre-staff {
    margin-bottom: 2px;
    line-height: 1.5;
  }

  /* Caja del desarrollador */
  .caja-desarrollador {
    display: inline-block;
    font-weight: bold;
    color: white;
    font-size: 15px;
    padding: 8px 20px;
    border-radius: 8px;
    background: rgba(0, 123, 255, 0.10);
    border: 1px solid rgba(0, 123, 255, 0.2);
  }

  /* Línea separadora */
  .separador {
    width: 50%;
    height: 1px;
    background-color: #ccc;
    opacity: 0.3;
    border: none;
    margin: 20px auto;
  }
</style>

<footer class="mi-footer-personalizado">

  <div>
    &copy; 2025 <strong>MAS Bienestar en tu hogar</strong>. Todos los derechos reservados.
  </div>

  <div class="contenedor-columnas">

    <div class="columna-footer">
      <span class="titulo-azul">Profesionales en salud</span>
      <div class="nombre-staff">ADRIANA GINNETT MARIÑO URREGO</div>
      <div class="nombre-staff">ANA VICTORIA VERGARA RODRIGUEZ</div>
      <div class="nombre-staff">DEISY KATHERINE BARRERA VARGAS</div>
      <div class="nombre-staff">ELISA CAROLINA VARGAS FONTECHA</div>
      <div class="nombre-staff">SINDY PAOLA ORTIZ CASTRO</div>

      <span class="titulo-azul">Comunicadora</span>
      <div class="nombre-staff">DIANA CAROLINA ESCOBAR CÁRDENAS</div>
    </div>

    <div class="columna-footer">
      <span class="titulo-azul">Técnicos en sistemas</span>
      <div class="nombre-staff">DUVAN DARIO HERNÁNDEZ BURGOS</div>
      <div class="nombre-staff">MICHELL DAYANN ROJAS TOBAR</div>

      <span class="titulo-azul">Ingenieros en sistemas</span>
      <div class="nombre-staff">Juan Pablo Tello Mendoza</div>
      <div class="nombre-staff">Yair Fernando Chaves Montenegro</div>

      <span class="titulo-azul">Diseñador</span>
      <div class="nombre-staff">Oscar Hernando Ramírez Espinosa</div>
    </div>

  </div>
  <hr class="separador">

  <div class="caja-desarrollador">
    ✦ Desarrollado por <span style="color:white;">Gabriel Monhabell Acosta</span> ✦
  </div>

</footer>