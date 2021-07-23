<template>
    <div>
            <div class="breadcrumb">
                <h1>Inicio</h1>
                <!-- <ul>
                    <li><a href="">UI Kits</a></li>
                    <li>Cards</li>
                </ul> -->
            </div>

            <div class="separator-breadcrumb border-top"></div>

            <div class="row">
                <!-- ICON BG -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4" @click="getTickets" style="cursor: pointer">
                        <div class="card-body text-center">
                            <i class="i-Information"></i>
                            <div class=" mini-cards">
                                <p class="text-muted mt-2 mb-0">Reclamos</p>
                                <p class="lead text-primary text-24 mb-2">{{allTickets}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4" @click="getTickets(type)" style="cursor: pointer">
                        <div class="card-body text-center">
                            <i class="i-Information"></i>
                            <div class=" mini-cards">
                                <p class="text-muted mt-2 mb-0">Reclamos Abiertos</p>
                                <p class="lead text-primary text-24 mb-2">{{openTickets}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4" @click="getInvoices(type)" style="cursor: pointer">
                        <div class="card-body text-center">
                            <i class="i-Receipt"></i>
                            <div class=" mini-cards">
                                <p class="text-muted mt-2 mb-0">Facturas</p>
                                <p class="lead text-primary text-24 mb-2">{{allInvoices}}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6" >
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4" style="cursor: pointer" @click="getInvoices">
                        <div class="card-body text-center">
                            <i class="i-Receipt"></i>
                            <div class=" mini-cards">
                                <p class="text-muted mt-2 mb-0">Facturas Pendientes</p>
                                <p class="lead text-primary text-24 mb-2">{{unpaidInvoices}}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

    </div>
</template>

<script>
import LayoutDashboard from '../layoutDashboard'

export default {
    name: "home",
    layout: LayoutDashboard,
    props: ['allTickets',
            'openTickets',
            'unpaidInvoices',
            'allInvoices'],
    
    data() {
        return {
            type: {
                open: 'opened',
                pay: 'all'
            },

        }
    },

     mounted() {
     },

    methods: {
        demoFunction: function () {
            alert('Hola Mundo');
        },

        getTickets(opened) {
            this.$inertia.get(`/dasboard/tickets`, opened);
        },
          getInvoices(all) {
            this.$inertia.get(`/dasboard/invoices`, all);
        },
      
    }

}
</script>

<style scoped>
 .mini-cards {
    margin: auto;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
 }
</style>
