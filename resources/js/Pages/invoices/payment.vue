<template>
    <div>
            <!-- <form > -->
            <div class="form-group my-5">
                <label for="name" class="col-md-4 col-form-label">DNI</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="dni" name="dni" v-model="dni" required>
                </div>
            </div>


             <div class="btn-toolbar sw-toolbar sw-toolbar-bottom justify-content-end">
                <div class="btn-group mr-2 sw-btn-group" role="group">
                    <button class="btn btn-dark px-5" @click="getInvoices()" type="submit">Siguiente</button>
                </div>
            </div>
        <!-- </form> -->
    </div>
</template>

<script>
import Layout from '../layout'

export default {
    name: "payment",
    layout: Layout,
    props: ['test'],
    data() {
        return {
            dni: '',

        }
    },

     mounted() {
         $("#step_1").addClass('active');
         $("#step_3,#step_2,#step_4").removeClass('active');

     },

    methods: {
        demoFunction: function () {
            alert('Hola Mundo');
        },
        getInvoices() {
            if (this.dni) {
            this.$inertia.get('/invoices/' + this.dni + '/all',{
                onProgress: progress => {NProgress.start},
                onError: (errors) => { 
                Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Este',
                        })
                        },
                    });
            }else{
                alert('Por favor ingrese su DNI.')
            }

        }
    }

}
</script>

<style scoped>

</style>
