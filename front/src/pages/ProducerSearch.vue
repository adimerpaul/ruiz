<template>
<q-page>
<div class="row">
  <div class="col-12">
    <q-input :loading="loading" @keyup.enter="producerSearch" outlined clearable counter v-model="store.producerSearch" label="Buscar productor*">
      <template v-slot:append>
        <q-icon name="o_search"/>
      </template>
    </q-input>
  </div>
  <div class="col-12" v-if="store.producerSearchs.length > 0">
    <q-table title="Filtro de productores" :rows="store.producerSearchs" dense :rows-per-page-options="[0]" :columns="producerColumns">
      <template v-slot:top-right>
        <div class="row full-width">
          <div class="col-12 q-pa-xs">
<!--            <q-btn-->
<!--              class="full-width"-->
<!--              color="green"-->
<!--              icon-right="o_description"-->
<!--              :label="$q.screen.lt.md?'':'Descargar excel'"-->
<!--              no-caps-->
<!--            />-->
          </div>
        </div>
      </template>
      <template v-slot:body-cell-opciones="props">
        <q-td :props="props" auto-width>
          {{props.row.id }}
          <q-btn-dropdown size="12px" label="Opciones" color="primary" dropdown-icon="more_vert" >
            <q-list>
<!--              <q-item clickable @click="producerUpdateDialog=true;producerU=props.row">-->
<!--                <q-item-section>-->
<!--                  <q-item-label>Editar</q-item-label>-->
<!--                </q-item-section>-->
<!--              </q-item>-->
<!--              <q-item clickable @click="userDelete(props.row)">-->
<!--                <q-item-section>-->
<!--                  <q-item-label>Eliminar</q-item-label>-->
<!--                </q-item-section>-->
<!--              </q-item>-->
              <q-item clickable>
<!--                <q-item-section>-->
<!--                  <q-item-label>Imprimir credecial</q-item-label>-->
                  <q-btn label="Credencial" icon="credit_card" color="blue-8"/>
<!--                </q-item-section>-->
              </q-item>
            </q-list>
          </q-btn-dropdown>
        </q-td>
      </template>
    </q-table>
<!--    <pre>{{store.producerSearchs}}</pre>-->
  </div>
  <div class="col-12" v-else>
    <div  class="text-bold text-center text-h4 text-grey">
      Buscar productor
    </div>
  </div>
</div>
</q-page>
</template>

<script>
import {useCounterStore} from "stores/example-store";

export default {
  name: `ProducerSearch`,
  data() {
    return {
      loading: false,
      store: useCounterStore(),
      producerColumns:[
        {name:"opciones",field:"opciones",label:"Opciones"},
        {name:'fecha',field: row => row.fecha+' '+row.hora,label: 'fecha',sortable:true},
        {name:'nombres',field: 'nombres',label: 'nombres',sortable:true},
        {name:'apellidos',field: 'apellidos',label: 'apellidos',sortable:true},
        {name:'ci',field: 'ci',label: 'ci',sortable:true},
        {name:'edad',field: 'edad',label: 'edad',sortable:true},
        // {name:'fechanNacimiento',field: 'fechanNacimiento',label: 'fechanNacimiento',sortable:true},
        {name:'nroFamilia',field: 'nroFamilia',label: 'nroFamilia',sortable:true},
        {name:'varones',field: 'varones',label: 'varones',sortable:true},
        {name:'mujeres',field: 'mujeres',label: 'mujeres',sortable:true},
        {name:'celular',field: 'celular',label: 'celular',sortable:true},
        {name:'provincia',field: 'provincia',label: 'provincia',sortable:true},
        {name:'departamento',field: 'departamento',label: 'departamento',sortable:true},
        {name:'municipio',field: 'municipio',label: 'municipio',sortable:true},
        {name:'comunidad',field: 'comunidad',label: 'comunidad',sortable:true},
        {name:'superficie',field: 'superficie',label: 'superficie',sortable:true},
        {name:'semilla',field: 'semilla',label: 'semilla',sortable:true},
        {name:'abono',field: 'abono',label: 'abono',sortable:true},
        {name:'maquinaria',field: 'maquinaria',label: 'maquinaria',sortable:true},
        {name:'riego',field: 'riego',label: 'riego',sortable:true},
        {name:'quinua',field: 'quinua',label: 'quinua',sortable:true},
        {name:'asociacion',field: 'asociacion',label: 'asociacion',sortable:true},
        {name:'mejorar',field: 'mejorar',label: 'mejorar',sortable:true},
        {name:'user_id',field: row=>row.user.name,label: 'user_id',sortable:true},
      ]
    };
  },
  methods: {
    producerSearch() {
      this.loading=true
      this.$api.post(`producerSearch`, {dato: this.store.producerSearch}).then((res) => {
        this.store.producerSearchs = res.data;
        this.loading=false
      });
    }
  }
}
</script>

<style scoped>

</style>
