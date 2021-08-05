<template>
    <div>
       <div class="col-md-12 table-responsive">
        <table class="table table-hover mb-4 " id="invoicesTable">
           <thead class="bg-gray-300">
            <tr>
                <th><input type="checkbox" @click="selectAll($event)" :checked="checkedAll == true"></th>
                <th>Número</th>
                <th>Nombre</th>
                <th>Fecha de vencimiento</th>
                <th>Total</th>
            </tr>
           </thead>
           <tbody>
            <tr v-for="(invoice,index) in invoices">
                <td><input type="checkbox" @click="selectInvoice(invoice)" :checked="checked == true"></td>
                <td>{{ invoice.number }}</td>
                <td>{{ invoice.name }}</td>
                <td>{{ invoice.quote_date }}</td>
                <td>{{ invoice.total_amount }}</td>
            </tr>
           </tbody>
           <tfoot>
               <tr>
                   <td>
                       
                   </td>
               </tr>
           </tfoot>
        </table>
            <div class="col-md-12 mt-5">
                <div class="invoice-summary w-100">
                    <h5 class="font-weight-bold">Total a Pagar: <span> {{ total }}</span></h5>
                    <div class="my-4 btn-toolbar justify-content-between">
                        <button class="btn btn-dark px-5" @click="redirect()" type="button">Volver</button>
                        <button type="button" class="btn btn-success px-5" @click="send" :disabled="disabled == 0">Pagar Factura</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Layout from '../layout'
import datatable from 'datatables.net-bs5'
export default {
    name: "all",
    layout: Layout,
    props: ['invoices', 'dni','message'],
    data() {
        return {
            invoicesIds: [],
            map: new Map(),
            total: 0,
            disabled: 0,
            checked: false,
            checkedAll: false,
            data: {}

        }
    },
     mounted() {
         this.table();
         this.data = {};
         $("#step_2").addClass('active');
         $("#step_1,#step_3,#step_4").removeClass('active');
         if (this.message) {
             Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Por favor selecciona las facturas más antiguas',
            })
         }

     },
    methods: {
        selectInvoice: function (invoice) {
            if (this.map.has(invoice.id)) {
                this.map.delete(invoice.id);
                this.checkedAll = false;
            } else {
                this.map.set(invoice.id, invoice);
            }
            let $self = this;
            this.total = 0;
            this.map.forEach(function (value, key, map) {
                $self.total += parseFloat(value.total_amount);
            });
            if ($self.total > 0) {
                this.disabled = 1;
            }else{
                this.disabled = 0;
            }
        },
        send() {
            let $self = this;
            this.map.forEach(function (value, key, map) {
                $self.invoicesIds.push(key);
            });
            this.data = {invoices: this.invoicesIds};
            console.log(this.data);
            this.$swal({
                title: '¿Está seguro que desea pagar estas facturas?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: `Si`,
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$inertia.get(`/invoices/${this.dni}/all/pay`, this.data);
                }else{
                    $self.invoicesIds = [];
                }
            });
        },
        selectAll(event) {
            this.map.clear();
            let $self = this;
            if (event.target.checked) {
                 this.invoices.forEach(function (value, key, map) {
                 $self.map.set(value.id, value);
                 });
                 this.checked = true;
            } else {
                this.map.clear();
                this.checked = false;
            }
            let $selfInvoice = this;
            this.total = 0;
            this.map.forEach(function (value, key, map) {
                $selfInvoice.total += parseFloat(value.total_amount);
            });
            if ($selfInvoice.total > 0) {
                this.disabled = 1;
            }else{
                this.disabled = 0;
            }
            console.log(this.map);
        },
         table(){
            this.$nextTick(() =>{
            $('#invoicesTable').DataTable({
                "lengthChange": false,
                "ordering": false,
                "info": false,
                "pageLength": 10,
                "searching": false,
                language: {
                    "search":"Buscar:",
                    "zeroRecords":    "No se encontraron resultados",
                    "emptyTable":     "No se encontraron facturas por pagar",
                    "paginate": {
                        "previous": '‹',
                        "next":     '›',
                       
                    }
                }
                
            });
        });
            
        },
        redirect(){
                this.$inertia.get(`/invoices/payment`);
            }
    }
}
</script>

<style scoped>

</style>
