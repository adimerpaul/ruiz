<template>
<q-page>
  <div class="row">
    <div class="col-12">
      <q-table :rows="users" title="Control de usuarios" :rows-per-page-options="[0]" :columns="userColumns" :filter="userFilter">
        <template v-slot:top-right>
          <q-input dense outlined v-model="userFilter" placeholder="Buscar" >
            <template v-slot:append>
              <q-icon name="search"></q-icon>
            </template>
          </q-input>
        </template>
        <template v-slot:body-cell-opciones="props">
          <q-td :props="props" auto-width>
            <q-btn-dropdown size="12px" flat color="primary" icon="more_vert" dropdown-icon="" >
              <q-list>
                <q-item @click="editUser(props.row)">
                  <q-item-section>
                    <q-item-label>Editar</q-item-label>
                  </q-item-section>
                </q-item>
                <q-item @click="deleteUser(props.row)">
                  <q-item-section>
                    <q-item-label>Eliminar</q-item-label>
                  </q-item-section>
                </q-item>
              </q-list>
            </q-btn-dropdown>
          </q-td>
        </template>
      </q-table>
    </div>
  </div>
</q-page>
</template>

<script>
export default {
  name: `User`,
  data() {
    return {
      users: [],
      userFilter:"",
      userColumns:[
        {name:"opciones",field:"opciones",label:"Opciones"},
        {name:"name",field:"name",label:"Nombre"},
        {name:"tipo",field:"tipo",label:"Tipo"},
        {name:"fechaLimite",field:"fechaLimite",label:"Fecha Limite"},
        {name:"email",field:"email",label:"Email"},
      ]
    }
  },
  created() {
    this.getUsers()
    // this.$q.iconSet.arrow.dropdown = ""
  },
  methods: {
    getUsers() {
      this.$api.get('user').then(res => {
        this.users = res.data;
      });
    },
  },
}
</script>

<style scoped>

</style>
