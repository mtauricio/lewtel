<template>
    <div class="m-5">
       <div class="col-md-12 table-responsive">
        <table class="table table-hover mb-4 display nowrap" id="invoicesTable" style="display:nowrap;">
           <thead class="bg-gray-300">
            <tr>
                <th><input type="checkbox" @click="selectAll($event)" :checked="checkedAll == true"></th>
                <th>Número</th>
                <th>Nombre</th>
                <th>Fecha de vencimiento</th>
                <th>Estado</th>
                <th>Total</th>
            </tr>
           </thead>
           <tbody>
            <tr v-for="(invoice,index) in invoices">
                <td><input type="checkbox" @click="selectInvoice(invoice)" v-if="invoice.status == 'Unpaid'" :checked="checked == true"></td>
                <td>{{ invoice.number }}</td>
                <td>{{ invoice.name }}</td>
                <td>{{ invoice.quote_date }}</td>
                <td>{{ invoice.status }}</td>
                <td>{{ parseFloat(invoice.total_amount) }}</td>
            </tr>
           </tbody>
             <tfoot>
               <tr >
                   <td colspan="6">
                     <div class="col-md-12 mt-4">
                        <div class="invoice-summary w-100">
                            <h5 class="font-weight-bold">Total a Pagar: <span> {{ total }}</span></h5>
                            <div class="my-5 justify-content-end">
                            <button type="button" class="btn btn-success px-5" @click="send" :disabled="disabled == 0">Pagar Factura</button>
                            </div>
                        </div>
                    </div>
                   </td>
               </tr>
           </tfoot>
        </table>
        </div>
    </div>
</template>

<script>
import LayoutDashboard from '../../layoutDashboard';
import datatable from 'datatables.net-bs5'
export default {
    name: "invoicesTable",
    layout: LayoutDashboard,
    props: ['invoices','pay'],
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
         this.data = {};
         console.log(this.pay);
         this.table();

     },
    methods: {
        table(){
            this.$nextTick(() =>{
            $('#invoicesTable').DataTable({
                "lengthChange": false,
                "ordering": false,
                "info": false,
                "pageLength": 10,
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
                    this.$inertia.get(`/dasboard/invoices/all/pay/`, this.data);
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
                 if (value.status == 'Unpaid') {
                     $self.map.set(value.id, value);
                 }    
                 
                 });
                 this.checked = true;
            } else {
                this.map.clear();
                this.checked = false;
            }
            let $selfInvoice = this;
            this.total = 0;
            this.map.forEach(function (value, key, map) {
                if (value.status == 'Unpaid') {
                    $selfInvoice.total += parseFloat(value.total_amount);
                }
            });
            if ($selfInvoice.total > 0) {
                this.disabled = 1;
            }else{
                this.disabled = 0;
            }
            console.log(this.map);
        }
    }
}
</script>

<style scoped>

</style>
