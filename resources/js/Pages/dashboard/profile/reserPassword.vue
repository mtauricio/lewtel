<template>
   <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="auth-content">
                <div class="card o-hidden">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="p-4">
                                <h1 class="mb-3 text-18">Cambiar Contraseña</h1>
                                <form >
                                    <div class="form-group">
                                        <label for="password">Contraseña actual</label>
                                        <input id="password" class="form-control form-control-rounded" v-model="form.password"
                                        type="password" name="password" required autocomplete="new-password"  @change="onChange($event)">
                                         <input type="hidden" id="id" name="id_user" v-model="form.id_user" >
                                         <small v-show="form.valid > 0" class="danger">Contraseña incorrecta</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="password-confirm">Nueva contraseña</label>
                                        <input id="password_new" class="form-control form-control-rounded" v-model="form.password_new"
                                        type="password" name="password_new" required autocomplete="new-password">
                                    </div>

                                    <div class="form-group">
                                        <label for="password-confirm">Nueva contraseña (repetir)</label>
                                        <input id="password_confirm" class="form-control form-control-rounded" v-model="form.password_confirm"
                                        type="password" name="password_confirmation" required autocomplete="new-password">
                                        <small v-show="equalsPass" class="danger">Las contrtaseñas no coinciden</small>
                                    </div>
                                    <button type="submit" class="btn btn-rounded btn-primary btn-block mt-4" @click.prevent="save(form)" :disabled="!isValid"> Cambiar contraseña</button>
    
                                </form>
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
    name: "createTicket",
    layout: LayoutDashboard,
    props: ['id'],
    data() {
        return {
            title:'',
            form: {
                password: '',
                password_new: '',
                password_confirm: '',
                valid: '',
                id_user: this.id
            }

        }
    },
     mounted() {
        console.log(this.id);
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
          onChange(event) {
             this.form.valid = 0;
        },

        save(data) {
                axios.post(`/reset/password`, data).then(response => {
                    let responseReset = response.data;
                    if (responseReset === "diferent") {
                        this.form.valid = 1;
                    }else{
                        this.form.valid = 0;
                    }

                    if (responseReset === "diferents") {
                      this.$swal({
                            icon: 'warning',
                            title: 'Tus contraseñas no coinciden',
                            showConfirmButton: true,
                            });
                    }

                    if (responseReset === true) {
                        this.$swal({
                            icon: 'success',
                            title: 'Tu contraseña se actualizó con exito',
                            showConfirmButton: false,
                            timer: 3000
                            });
                    }else if (responseReset === false) {
                          this.$swal({
                            icon: 'error',
                            title: 'No se pudo actualizar tu conytaseña',
                            showConfirmButton: false,
                            timer: 3000
                            });
                    } 
            })
        } 
    },
    computed: {
        isValid() {
            return this.form.password !== ''
                && this.form.password_new !== ''
                && this.form.password_confirm !== ''
                && this.form.password_new === this.form.password_confirm;
        },

        equalsPass() {
            return this.form.password_new !== this.form.password_confirm;
        },
    }
}
</script>

<style scoped>

.danger {
    color: red;
}

</style>
