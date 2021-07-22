<template>
    <main>
        <div class="main-header">
            <div class="logo-law mx-3">
                LewTel
            </div>
            <div style="margin: auto"></div>
        </div>
        <article>
             <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">

                        <div class="col-md-12">
                            <!-- SmartWizard html -->
                            <div id="smartwizard" class="sw-main sw-theme-default mt-5" style="box-shadow: 0 0px 0px rgb(0 0 0 / 30%);">
                                <ul class="nav nav-tabs step-anchor">
                                    <li class="nav-item" id="step_1"><a class="nav-link" href="#step-1">Paso 1<br /><p>Consultar Facturas</p></a></li>
                                    <li class="nav-item" id="step_2"><a class="nav-link" href="#step-2">Paso 2<br /><p>Seleccionar Facturas</p></a></li>
                                    <li class="nav-item" id="step_3"><a class="nav-link" href="#step-3">Paso 3<br /><p>Pagar Facturas</p></a></li>
                                    <li class="nav-item" id="step_4"><a class="nav-link" href="#step-4">Paso 4<br /><p>Fin Transacción</p></a></li>
                                    </ul>

                                <div>
                                    <div id="step-1" class="">
                                        <slot/>
                                    </div>
                                            
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
             </div>
        </article>
    </main>
</template>

<script>
export default {
    name: "layout"
}
</script>

<style scoped>

</style>
