<template>
    <div>
        <div class="col-md-12 table-responsive">
            <table class="table table-hover mb-4 ">
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
                    <td>{{ parseFloat(invoice.total_amount) }}</td>
                </tr>
                </tbody>
            </table>

            <!-- <button @click="send">Pay Invoices</button> -->
            <div class="col-md-12">
                <div class="w-100 text-center my-5" style="font-size: 17px;">
                    <div class="cho-container"></div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
import Layout from '../layout'

export default {
    name: "summaryInvoices",
    layout: Layout,
    props: ['invoicespay', 'preferenceid'],
    data() {
        return {
            total: 0

        }
    },

    mounted() {
        let totalll = 0;
        this.invoicespay.forEach(function (value, key, map) {
            totalll += parseFloat(value.total_amount);
        });
        this.total = totalll;
        $("#step_1,#step_2,#step_4").removeClass('active');
        $("#step_3").addClass('active');

        // Agrega credenciales de SDK
        const mp = new MercadoPago('APP_USR-e2f4d387-5825-4f0d-85cf-320c0d6fcc4a', {
            locale: 'es-CO'
        });
        // Inicializa el checkout
        mp.checkout({
            preference: {
                id: this.preferenceid
            },
            render: {
                container: '.cho-container', // Indica dónde se mostrará el botón de pago
                label: 'Pagar: ' + this.total, // Cambia el texto del botón de pago (opcional)
            }
        });
    },
}
</script>

<style scoped>

</style>
