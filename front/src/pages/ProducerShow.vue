<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>        <q-toolbar-title>
          Información del productor
        </q-toolbar-title>
      </q-toolbar>
    </q-header>
    <q-page-container>
      <q-page>
        <div class="row">
          <div class="col-12 col-sm-2"></div>
          <div class="col-12 col-sm-8">
            <q-card>
              <q-card-section class="q-py-xs">
                <div class="row">
                  <div class="col-6"><q-input disable dense outlined v-model="producer.nombres" label="NOMBRES(S)" required /></div>
                  <div class="col-6"><q-input disable dense outlined v-model="producer.apellidos" label="APELLIDOS" /></div>
                  <div class="col-4"><q-input disable dense outlined v-model="producer.ci" label="CI" /></div>
                  <div class="col-4"><q-input disable dense outlined v-model="producer.edad" label="EDAD" /></div>
                  <div class="col-4"><q-input disable dense outlined v-model="producer.nroFamilia" label="NO FAMILIA" /></div>
                  <div class="col-3"><q-input disable dense outlined v-model="producer.masculino" label="MASCULINO" /></div>
                  <div class="col-3"><q-input disable dense outlined v-model="producer.femenino" label="FEMENINO" /></div>
                  <div class="col-3"><q-input disable dense outlined v-model="producer.varones" label="VARONES" /></div>
                  <div class="col-3"><q-input disable dense outlined v-model="producer.mujeres" label="MUJERES" /></div>
                  <div class="col-6"><q-input disable dense outlined v-model="producer.celular" label="CELULAR" /></div>
                  <div class="col-6"><q-input disable dense outlined v-model="producer.provincia" label="PROVINCIA" /></div>
                  <div class="col-6"><q-input disable dense outlined v-model="producer.departamento" label="1 DEPARTAMENTO" /></div>
                  <div class="col-6"><q-input disable dense outlined v-model="producer.municipio" label="2 MUNICIPIO" /></div>
                  <div class="col-6"><q-input disable dense outlined v-model="producer.comunidad" label="3 COMUNIDAD" /></div>
                  <div class="col-6"><q-input disable dense outlined v-model="producer.superficie" label="4 SUPERFICIE CULTIVADA" /></div>
                  <div class="col-6"><q-input disable dense outlined v-model="producer.semilla" label="5 SEMILLA UTILIZADA" /></div>
                  <div class="col-6"><q-input disable dense outlined v-model="producer.abono" label="6 TIPO DE ABONO UTILIZADO" /></div>
                  <div class="col-12"><q-input disable dense outlined v-model="producer.maquinaria" label="7 MAQUINARIA Y HERRAMIENTAS EMPLEADAS" /></div>
                  <div class="col-12"><q-input disable dense outlined v-model="producer.riego" label="8 TIPO DE RIEGO AL QUE TIENE ACCESO" /></div>
                  <div class="col-12"><q-input disable dense outlined v-model="producer.quinua" label="9 CANTIDAD DE QUINUA RECOLECTADA POR HECTAREA" /></div>
                  <div class="col-12"><q-input disable dense outlined v-model="producer.asociacion" label="10 PERTENECE A ALGUNA ASOCIACIÓN?" /></div>
                  <div class="col-6"><q-input disable dense outlined v-model="producer.si" label="SI" /></div>
                  <div class="col-6"><q-input disable dense outlined v-model="producer.no" label="NO" /></div>
                  <div class="col-12"><q-input disable dense outlined v-model="producer.mejorar" label="11 COMO CREE QUE PODRÍA MEJORAR SU PRODUCCIÓN" /></div>
                  <div class="col-12 text-center flex flex-center">
                    <q-img :src="url+'../imagenes/'+producer.foto" style="width: 200px; height: 200px;" />
                  </div>
                </div>
              </q-card-section>
            </q-card>
          </div>
          <div class="col-12 col-sm-2"></div>
        </div>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script>
export default {
  name: `ProducerShow`,
  data () {
    return {
      producer: {},
      url:process.env.API
    }
  },
  created() {
    this.$api.get(`producer/${this.$route.params.id}`).then(res => {
      this.producer = res.data
    })
  }
}
</script>

<style scoped>

</style>
