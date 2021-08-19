<template>
    <div class="m-5">
        <div class="col-md-12 ">
            <table class="table table-hover table-responsive-lg mb-4 ">
                 <thead class="bg-gray-300">
                    <tr>
                        <td>Número</td>
                        <td>Nombre</td>
                        <td>Total</td>
                    </tr>
                 </thead>
                 <tbody>
                    <tr v-for="(invoice,index) in invoicespay">
                        <td>{{ invoice.number }}</td>
                        <td>{{ invoice.name }}</td>
                        <td>{{ invoice.total_amount }}</td>
                    </tr>
                 </tbody>
            </table>
          
            <!-- <button @click="send">Pay Invoices</button> -->
            <div class="col-md-12">
                <div class="invoice-summary">
                    <div class="btn-toolbar justify-content-between my-5" >
                    <button class="btn btn-dark" @click="redirect()" type="button">Volver</button>
                        <div class="cho-container" style="font-size: 17px;"></div>
                    </div>
                </div>
            </div>
            </div>
           
        </div>
</template>
<script>
import LayoutDashboard from '../../layoutDashboard'
export default {
    name: "summaryInvoices",
     layout: LayoutDashboard,
    props: ['invoicespay', 'preferenceid'],
    data() {
        return {
             total: 0

        }
    },

      mounted() {

          let public_key = process.env.MIX_MP_PUBLIC_KEY;
          let totalll = 0;
            this.invoicespay.forEach(function (value, key, map) {
                totalll += parseFloat(value.total_amount);
            });
            this.total = totalll;

                  // Agrega credenciales de SDK
                const mp = new MercadoPago(public_key, {
                        locale: 'es-AR'
                });

                // Inicializa el checkout
                mp.checkout({
                    preference: {
                        id: this.preferenceid
                    },
                    render: {
                            container: '.cho-container', // Indica dónde se mostrará el botón de pago
                            label: 'Pagar: '+ this.total, // Cambia el texto del botón de pago (opcional)
                    }
                });
        },

         methods: {
            redirect(){
                this.$inertia.get('/dasboard/invoices');
            }
        }

    
}
</script>

<style scoped>

</style>