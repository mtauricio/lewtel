<template>
    <div>
        <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-icon mb-4">
                        <div class="card-body text-center">
                            <div >
                                <i class="text-50 i-Close-Window"></i>
                                <p class="lead text-22 m-2"><strong>{{ message }}</strong> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn-toolbar sw-toolbar sw-toolbar-bottom justify-content-end">
                <div class="btn-group mr-2 sw-btn-group" role="group">
                    <button class="btn btn-dark px-5" @click="redirect()" type="submit">Volver</button>
                </div>
            </div>
    </div>
</template>
<script>
import LayoutDashboard from '../../layoutDashboard'

export default {
    name: "noDniFound",
    layout: LayoutDashboard,
    props:['error'],
    data() {
        return {
            message:''    
        }
    },

     mounted() {
       if (this.error == 'nodni') {
           this.message = 'DNI NO ENCONTRADO';
       } else if (this.error == 'newinvoice') {
           this.message = 'ELIGE LAS FACTURAS MAS ANTIGUAS';
       }

     },

     methods: {
         redirect(){
             history.back();
         }
     }

   

}
</script>

<style scoped>

</style>