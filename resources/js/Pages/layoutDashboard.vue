<template>
    <main>
        <article>
            <!-- Pre Loader Strat  -->
            <div class='loadscreen' id="preloader">

                <div class="loader spinner-bubble spinner-bubble-primary">



                </div>
            </div>
            <!-- Pre Loader end  -->


            <div class="app-admin-wrap layout-sidebar-large">
                <div class="main-header">
                    <div class="logo" style="background: black;">
                        <img src="/assets/images/logo.jpeg " alt="" style="width: 100px; height: 77px;">
                    </div>

                    <div class="menu-toggle">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <div style="margin: auto"></div>

                    <div class="header-part-right">

                        <!-- User avatar dropdown -->
                        <!-- <div class="dropdown">
                            <div class="user col align-self-end">
                                <i class="text-45 i-Male-21" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                    <div class="dropdown-header">
                                        <i class="i-Lock-User mr-1"></i> Timothy Carlson
                                    </div>
                                    <a class="dropdown-item">Account settings</a>
                                    <a class="dropdown-item">Billing history</a>
                                    <a class="dropdown-item" href="#" @click="logout">Sign out</a>
                                </div>
                            </div>
                        </div> -->
                  <div class="dropdown">
                    <div class="user col align-self-end">
                        <b-dropdown size="lg"  variant="link" toggle-class="text-decoration-none" no-caret>
                            <template #button-content>
                            <span class="text-45 i-Male-21"></span>
                            </template>
                            <b-dropdown-item href="#" @click="changePass">Perfil</b-dropdown-item>
                            <b-dropdown-item href="#" @click="logout">Cerrar Sesión</b-dropdown-item>
                        </b-dropdown>
                        </div>
                  </div>
                    </div>

                </div>
                <!-- header top menu end -->

                <div class="side-content-wrap">
                    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
                        <ul class="navigation-left">
                            <li class="nav-item">
                                <a class="nav-item-hold" href="#" @click="home">
                                    <i class="nav-icon i-Home1"></i>
                                    <span class="nav-text">Inicio</span>
                                </a>
                                <div class="triangle"></div>
                            </li>
                            <li class="nav-item" data-item="invoices">
                                <a class="nav-item-hold" href="#">
                                    <i class="nav-icon i-Receipt"></i>
                                    <span class="nav-text">Facturas</span>
                                </a>
                                <div class="triangle"></div>
                            </li>
                            <li class="nav-item" data-item="tickets">
                                <a class="nav-item-hold" href="#">
                                    <i class="nav-icon i-Information"></i>
                                    <span class="nav-text">Reclamos</span>
                                </a>
                                <div class="triangle"></div>
                            </li>

                        </ul>
                    </div>

                    <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
                        <!-- Submenu Dashboards -->
                        <ul class="childNav" data-parent="tickets">
                            <li class="nav-item">
                                <a href="#"  @click="getTickets">
                                    <span class="item-name">Reclamos</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" @click="getTickets(type)">
                                    <span class="item-name">Reclamos Abiertos</span>
                                </a>
                            </li>
                        </ul>
                        <ul class="childNav" data-parent="invoices">
                            <li class="nav-item">
                                <a href="#" @click="getInvoices(type)">
                                    <span class="item-name">Facturas</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#"  @click="getInvoices()">
                                    <span class="item-name">Facturas Pendientes</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="sidebar-overlay"></div>
                </div>
                <!--=============== Left side End ================-->

                <!-- ============ Body content start ============= -->
                <div class="main-content-wrap sidenav-open d-flex flex-column">
                    <div class="main-content">
                        <slot/>
                    </div>
                    <!-- end of main content -->

                </div>
                <!-- ============ Body content End ============= -->
            </div>
            <!--=============== End app-admin-wrap ================-->

            <!-- ============ Search UI Start ============= -->
            
            <!-- ============ Search UI End ============= -->

        </article>
    </main>
</template>

<script>
export default {
    name: "layoutDashboard",
    data() {
            return {
                type: {
                    open: 'opened',
                    pay: 'all'
                },

            }
        },
    methods: {

        getTickets(opened) {
            this.$inertia.get(`/dasboard/tickets`, opened);
        },

        getInvoices(all) {
            this.$inertia.get(`/dasboard/invoices`, all);
        },

         logout() {
            this.$inertia.post(`/to/logout`);
        },

        home() {
            this.$inertia.get(`/home`);
        },

        changePass() {
            this.$inertia.get(`/show/profile/`);
        }

        }

}
</script>

<style scoped>

</style>
