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
                    <div class="logo">
                        <img src="assets/images/logo.png " alt="">
                    </div>

                    <div class="menu-toggle">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <div style="margin: auto"></div>

                    <div class="header-part-right">

                        <!-- User avatar dropdown -->
                        <div class="dropdown">
                            <div class="user col align-self-end">
                                <img src="assets/images/faces/1.jpg" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                    <div class="dropdown-header">
                                        <i class="i-Lock-User mr-1"></i> Timothy Carlson
                                    </div>
                                    <a class="dropdown-item">Account settings</a>
                                    <a class="dropdown-item">Billing history</a>
                                    <a class="dropdown-item" href="#" @click="logout">Sign out</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- header top menu end -->

                <div class="side-content-wrap">
                    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar data-suppress-scroll-x="true">
                        <ul class="navigation-left">
                            <li class="nav-item">
                                <a class="nav-item-hold" href="#">
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
            this.$inertia.post(`logout`);
        },

        }

}
</script>

<style scoped>

</style>
