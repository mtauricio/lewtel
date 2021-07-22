<template>
    <div>
        <div class="text-center">
            <div class="alert" :class="{ 'alert-success': statuspay == 'Approved', 'alert-warning': statuspay == 'pending', 'alert-danger': statuspay == 'failure' }" role="alert">
                <strong >{{ title }}</strong> 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-icon mb-4">
                        <div class="card-body text-center">
                            <div style="color:green" v-if="statuspay == 'Approved'">
                                <i class="text-50 i-Smile"></i>
                                <p class="lead text-22 m-2"><strong>APROBADA</strong> </p>
                            </div>

                             <div style="color:goldenrod" v-if="statuspay == 'pending'">
                                <i class="text-50 i-Over-Time"></i>
                                <p class="lead text-22 m-2"><strong>PENDIENTE</strong> </p>
                                <p class="text-muted mt-2 my-3">Tu transacción está pendiente, te notificaremos en cuanto sea aprobada o rechazada.</p>
                            </div>

                             <div style="color:red" v-if="statuspay == 'failure'" >
                                <i class="text-50 i-Depression"></i>
                                <p class="lead text-22 m-2"><strong>FALLÓ</strong> </p>
                            </div>

                                 <div class="col-md-12 table-responsive">
                                    <table class="table table-hover mb-4 ">
                                    <thead class="bg-gray-300">
                                         <tr>
                                            <th colspan="3"><b>Facturas:</b></th>
                                        </tr>
                                        <tr>
                                            <th>Número</th>
                                            <th>Nombre</th>
                                            <th>Fecha de Emisión</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="invoice in invoices">
                                            <td>{{ invoice.number }}</td>
                                            <td>{{ invoice.name }}</td>
                                            <td>{{ invoice.quote_date }}</td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </div>
                               
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import LayoutDashboard from '../../layoutDashboard'

export default {
    name: "thankpage",
    layout: LayoutDashboard,
    props: ['invoices', 'statuspay'],
    data() {
        return {
                title: ''
        }
    },

     mounted() {
         console.log(this.statuspay);
         if (this.statuspay == 'Approved') {
             this.title = '¡Excelente su transacción fué exitosa!'
         } else if (this.statuspay == 'pending') {
             this.title = '¡Tu transaccion está en proceso!'
         } else if (this.statuspay == 'failure') {
            this.title = 'Su transaccion fué rechazada'
             
         }

     },

    methods: {
        demoFunction: function () {
            alert('Hola Mundo');
        },
    }

}
</script>

<style scoped>

</style>