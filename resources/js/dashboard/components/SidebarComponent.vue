<template>
    <aside class="left-sidebar" v-bind:class="{ active:active }">
        <nav class="sidebar-nav" id="sidebar">
            <ul>
                <li class="user-profile mb-2">
                    <a data-toggle="collapse" href="#user_profile" class="collapsed has-arrow" aria-expanded="false">
                        <img  src="/img/default-avatar.png" alt="user">
                        <span class="hide-menu text-capitalize">{{name}} </span>
                    </a>
                    <ul aria-expanded="true" class="collapse" id="user_profile" data-parent="#sidebar">
                        <li><a href="/admin/profile" >Perfil</a></li>
                        <li><span class="link-logout" v-on:click="logout()">Salir</span></li>
                    </ul>
                </li>
                <li class="nav-devider"></li>
                <li class="nav-small-cap">TABLERO</li>
                <li class="mb-2"><a href="/admin"><i class="material-icons">home</i><span class="hide-menu">Incio </span></a></li>
                <li class="mb-2">
                    <a data-toggle="collapse" href="#collapseCatalogo" class="collapsed has-arrow" aria-expanded="false">
                        <i class="material-icons">store</i>
                        <span class="hide-menu">Catalogo </span>
                    </a>
                    <ul aria-expanded="true" class="collapse" id="collapseCatalogo" data-parent="#sidebar">
                        <li><a data-toggle="collapse" href="#collapseProduct" class="collapsed has-arrow" aria-expanded="false">Productos</a>
                            <ul aria-expanded="true" class="collapse" id="collapseProduct" data-parent="#collapseCatalogo">
                                <li><a href="/admin/products">Listado de productos</a></li>
                                <li><a href="/admin/products/create">Añadir nuevo</a></li>
                            </ul>
                        </li>
                        <li><a href="/admin/categories">Categorias</a></li>
                    </ul>
                </li>
                <li class="mb-2"><a href="/admin/customers"><i class="material-icons">account_circle</i><span class="hide-menu">Clientes </span></a></li>
                <li class="mb-2"><a href="/admin/orders"><i class="material-icons">shopping_basket</i><span class="hide-menu">Pedidos </span></a></li>
                <li class="mb-2"><a href="/admin/users"><i class="material-icons">assignment_ind</i><span class="hide-menu">Usuarios </span></a></li>
                <li class="mb-2"><a href="/admin/reports"><i class="material-icons">pie_chart</i><span class="hide-menu">Reportes </span></a></li>
            </ul>
        </nav>
    </aside>
</template>

<script>
export default {
    props: ['active','name'],
    data(){
        return {
            progress: false,
        }
    },
    methods: {
        logout(){
            document.getElementById('logout-form').submit();
        }
    }
};
</script>
