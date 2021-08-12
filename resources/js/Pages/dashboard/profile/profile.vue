<template>
    <div>
        <div class="alert" :class="{ 'alert-success': change == 'Approved', 'alert-warning': change == 'pending', 'alert-danger': change == 'failure' }" role="alert">
            <strong >{{ title }}</strong> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            </button>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card card-icon mb-4">    
                    <div class="card-body">
                        <div class="ul-widget__head pb-20 v-margin">
                        <div class="ul-widget__head-label">
                            <h3 class="ul-widget__head-title">
                            Información personal
                            </h3>
                        </div>
                        </div>
                        <div class="ul-widget__body">
                            <div class="ul-widget1">
                                <div class="ul-widget4__item ul-widget4__users">
                                    <div class="ul-widget2__info ul-widget4__users-info">
                                        <span  class="ul-widget2__username">
                                        Nombre
                                        </span>
                                         <a  class="ul-widget2__title">
                                        {{ name }}
                                        </a>
                                    </div>
                                </div>

                                <div class="ul-widget4__item ul-widget4__users">
                                    <div class="ul-widget2__info ul-widget4__users-info">
                                        <span class="ul-widget2__username">
                                        Apellido
                                        </span>
                                         <a class="ul-widget2__title">
                                        {{ lastName }}
                                        </a>
                                    </div>
                                </div>

                                <div class="ul-widget4__item ul-widget4__users">
                                    <div class="ul-widget2__info ul-widget4__users-info">
                                        <span class="ul-widget2__username">
                                        Correo electrónico
                                        </span>
                                        <a class="ul-widget2__title">
                                        {{ email }}
                                        </a>
                                    </div>
                                </div>
                                <div class="ul-widget-notification-item-div">
                                    <a href="#" class="ul-widget-notification-item" @click="resetPassword">
                                        <div class="ul-widget-notification-item-icon">
                                        <i class="i-Arrow-Refresh"></i>
                                        </div>
                                        <div class="ul-widget-notification-item-details">
                                        <div class="ul-widget-notification-item-title">
                                            Cambiar contraseña.
                                        </div>
                                        </div>
                                    </a>
                                </div>
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
    name: "profile",
    layout: LayoutDashboard,
    props: ['name',
            'lastName',
            'email',
            'change'],
    data() {
        return {
                title: ''
        }
    },

     mounted() {
        //  if (this.statuspay == 'Approved') {
        //      this.title = '¡Excelente su transacción fué exitosa!'
        //  } else if (this.statuspay == 'pending') {
        //      this.title = '¡Tu transaccion está en proceso!'
        //  } else if (this.statuspay == 'failure') {
        //     this.title = 'Su transaccion fué rechazada'
             
        //  }

     },

    methods: {
        demoFunction: function () {
            alert('Hola Mundo');
        },

        resetPassword() {
            this.$inertia.get(`/show/password/reset/`);
        }
    }

}
</script>

<style scoped>

</style>