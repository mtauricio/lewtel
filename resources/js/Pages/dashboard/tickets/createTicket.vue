<template>
    <div class="m-5">
        <div class="alert" :class="{ 'alert-success': result == 'created', 'alert-danger': result == 'failed', 'd-none': result == undefined }" role="alert">
            <strong >{{ title }}</strong> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
      <form class="needs-validation" novalidate>
          <div class="col-md-6 form-group mb-3">
                <label for="affair">Asunto</label>
                <input type="text" class="form-control" id="affair" name="affair" v-model="form.affair" required>
            </div>
             <div class="col-md-8 form-group mb-3">
                <label for="description">Descripción principal</label>
                <textarea name="description" id="description" cols="30" class="form-control" rows="10" v-model="form.description" required></textarea>
            </div>
            <div class="col-md-4 form-group mb-3">
                <button type="submit" class="btn btn-primary mr-3" @click.prevent="save(form)" :disabled="!isValid">Guardar</button>
                <button type="button" class="btn btn-danger" @click="redirect()">Cancelar</button>
            </div>
      </form>
    </div>
</template>

<script>
import LayoutDashboard from '../../layoutDashboard'
export default {
    name: "createTicket",
    layout: LayoutDashboard,
    props: ['result'],
    data() {
        return {
            title:'',
            form: {
                affair: '',
                description: ''
            }

        }
    },
     mounted() {
        console.log(this.result);
         if (this.result == 'created') {
             this.title = '¡Se ha creado tu caso correctamente!';
         } else if (this.result == 'failed') {
             this.title = 'Hubo un error y no s se pudo crear tu caso...¡Intenta nuevamente!';
         } else {
            this.title = '';
             
         }
     },
    methods: {
        redirect(){
             history.back();
         },

        save(data) {
            this.$inertia.post(`/dasboard/store/ticket`, data);
        } 
    },
    computed: {
        isValid() {
            return this.form.affair !== ''
                && this.form.description !== '';
        },
    }
}
</script>

<style scoped>

</style>
