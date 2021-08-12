<template>
    <div class="m-5">
            <div class="row row-xs ml-1 mb-5">
                <!-- <div class="col-md-3">
                    <input type="text" name="number" id="number" class="form-control" placeholder="Número de caso">
                </div> -->
                <!-- <div class="col-md-1 mt-3 mt-md-0">
                    <button class="btn btn-primary btn-block">Buscar</button>
                </div> -->
              
                    <div class="col-md-1 mr-1 justify-content-end" style="margin-bottom: -34px;">
                        <button class="btn btn-lg btn-success btn-block" @click="add">Agregar</button>
                    </div>
         
            </div>
       <div class="col-md-12 table-responsive">
        <table class="table table-hover mb-4 " id="ticketsTable">
           <thead class="bg-gray-300">
            <tr>
                <th>Número</th>
                <th>Asunto</th>
                <th>Estado</th>
                <th>Descripción</th>
                <th>Descripción secundaria</th>
                <th>Acción</th>
            </tr>
           </thead>
           <tbody>
            <tr v-for="(ticket,index) in tickets">
                <td>{{ ticket.number }}</td>
                <td>{{ ticket.affair }}</td>
                <td>{{ ticket.status }}</td>
                <td>{{ ticket.description }}</td>
                <td>{{ ticket.secundary_description }}</td>
                <td>  <button type="button" class="btn btn btn-outline-success px-4" @click="show(ticket)" >Ver</button></td>
            </tr>
           </tbody>
        </table>
        </div>
    </div>
</template>

<script>
import LayoutDashboard from '../../layoutDashboard'
import datatable from 'datatables.net-bs5'
export default {
    name: "ticketsTable",
    layout: LayoutDashboard,
    props: ['tickets', 'dni'],
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
     },
    methods: {

        show(ticket) {
           
            this.$inertia.get(`/dasboard/ticket/${ticket.id}`);
        },
        add() {
    
            this.$inertia.get(`/dasboard/create/ticket`);
        },
        table(){
            this.$nextTick(() =>{
            $('#ticketsTable').DataTable({
                "lengthChange": false,
                "info": false,
                "pageLength": 10,
                   language: {
                    "search":"Buscar:",
                    "zeroRecords":    "No se encontraron resultados",
                    "emptyTable":     "No se encontraron casos",
                    "paginate": {
                        "previous": '‹',
                        "next":     '›',
                       
                    }
                }
                
            });
        });
            
        }

    }
}
</script>

<style scoped>

</style>
