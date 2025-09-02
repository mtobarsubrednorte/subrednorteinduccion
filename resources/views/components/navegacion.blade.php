<aside class="navegacion">
    <h3><i class="fas fa-bars"></i> NAVEGACIÓN</h3>
    <ul>
        <li><i class="fas fa-home"></i> <a href="{{ asset('pages/home') }}">Página Principal</a></li>
        <li><i class="fas fa-user"></i> <a href="{{ asset('pages/perfil') }}">Área personal</a></li>

        <!-- Cursos con submenu tipo acordeón -->
        <li class="submenu">
            <button class="toggle">
                <i class="fas fa-graduation-cap"></i> Cursos 
                <i class="fas fa-chevron-down arrow"></i>
            </button>
            <ul class="submenu-items">
                <li><a href="{{ asset('modules/module1') }}">Modulo 1</a></li>
                <li><a href="#">Modulo 2</a></li>
                <li><a href="#">Modulo 3</a></li>
                <li><a href="#">Modulos 4</a></li>
            </ul>
        </li>
    </ul>
</aside>

<style>


.navegacion ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.navegacion ul li {
    margin: 10px 0;
}

.navegacion a {
    text-decoration: none;
    color: #333;
}

.submenu .toggle {
    width: 100%;
    background: none;
    border: none;
    text-align: left;
    font-size: 16px;
    padding: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-weight: bold;
}

.submenu-items {
    display: none;
    margin-left: 15px;
}

.submenu-items li {
    margin: 6px 0;
}

.submenu.open .submenu-items {
    display: block;
}

.submenu .arrow {
    transition: transform 0.3s ease;
}

.submenu.open .arrow {
    transform: rotate(180deg);
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const toggle = document.querySelector(".submenu .toggle");
    const submenu = document.querySelector(".submenu");

    toggle.addEventListener("click", function() {
        submenu.classList.toggle("open");
    });
});
</script>
