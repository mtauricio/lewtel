<template>
    <div class="m-5">
        <div class="alert" :class="{ 'alert-success': result == 'created', 'alert-danger': result == 'failed', 'd-none': result == undefined }" role="alert">
            <strong >{{ title }}</strong> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
       <div class="col-md-12">
            <h5>Consulta</h5>
            <span class="badge badge-pill badge-secondary p-2 m-2">#{{ticket.number}}</span>
            <span class="badge badge-pill badge-info p-2 m-2">{{ticket.status}}</span>
            <span class="badge badge-pill badge-dark p-2 m-2">{{ticket.date_entered}}</span>
            <p class="my-2">{{ticket.description}}</p>
            <p>{{ticket.secundary_description}}</p>
       </div>
       <div class="row mt-5">
            <div class="col-md-6 pr-5">
                    <h5 class="mb-4"><b>Historial de actualizaciones</b></h5>
                    <table class="table">
                        <tr>
                            <th> Nombre</th>
                            <th> Fecha</th>
                        </tr> 
                        <tr v-for="(update,index) in updates">
                            <td> {{ update.name }}</td>
                            <td> {{ update.date_entered }}</td>
                        </tr> 
                    </table>
            </div>
                <div class="col-md-6">
                <h5 class="mb-4"><b>Agregar actualización</b></h5>
                <form action="">
                <textarea name="update" id="update" class="form-control" cols="30" rows="10" v-model="form.update" required></textarea>
                <input type="hidden" v-model="form.id">
                <button type="submit" class="btn btn-dark ripple mt-3" @click.prevent="save(form)" :disabled="!isValid">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import LayoutDashboard from '../../layoutDashboard'
export default {
    name: "ticket",
    layout: LayoutDashboard,
    props: ['ticket', 'updates','result'],
    data() {
        return {
            title:'',
            form: {
                id: this.ticket.id,
                update: ''
            }

        }
    },
     mounted() {
        console.log(this.result);
         if (this.result == 'created') {
             this.title = '¡Se ha agregado la actualización!';
         } else if (this.result == 'failed') {
             this.title = 'Hubo un error y no se pudo agregar la actualización...¡Intenta nuevamente!';
         } else {
            this.title = '';
             
         }
     },
    methods: {
       save(data) {
            this.$inertia.post(`/dasboard/ticket/update`, data);
        } 

    },
    computed: {
        isValid() {
            return this.form.update !== '';
        },
    }
}
</script>

<style scoped>

</style>
