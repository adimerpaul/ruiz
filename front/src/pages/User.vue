<template>
<q-page>
  <div class="row">
    <div class="col-12">
      <q-table :rows="users" title="Control de usuarios" :rows-per-page-options="[0]" :columns="userColumns" :filter="userFilterData">
        <template v-slot:top-right>
          <q-btn icon="add_circle" color="green" label="Crear usuario" @click="userDialog=true" :loading="loading"  />
          <q-input dense outlined v-model="userFilterData" placeholder="Buscar" >
            <template v-slot:append>
              <q-icon name="search"></q-icon>
            </template>
          </q-input>
        </template>
        <template v-slot:body-cell-tipo="props">
          <q-td :props="props"><q-badge :color="props.row.tipo=='ADMINISTRADOR'?'red':'green'" :label="props.row.tipo" /></q-td>
        </template>
        <template v-slot:body-cell-opciones="props">
          <q-td :props="props" auto-width>
            <q-btn-dropdown size="12px" label="Opciones" color="primary" dropdown-icon="more_vert" >
              <q-list>
                <q-item clickable @click="userUpdateDialog=true;userU=props.row">
                  <q-item-section>
                    <q-item-label>Editar</q-item-label>
                  </q-item-section>
                </q-item>
                <q-item clickable @click="deleteUser(props.row)">
                  <q-item-section>
                    <q-item-label>Eliminar</q-item-label>
                  </q-item-section>
                </q-item>
                <q-item clickable @click="userUpdatePassword(props.row)">
                  <q-item-section>
                    <q-item-label>Cambiar password</q-item-label>
                  </q-item-section>
                </q-item>
              </q-list>
            </q-btn-dropdown>
          </q-td>
        </template>
      </q-table>
    </div>
  </div>
  <q-dialog v-model="userDialog">
    <q-card>
      <q-card-section class="row items-center q-mb-none">
        <div class="text-h6">Crear usuario</div>
        <q-space/>
        <q-btn icon="highlight_off" flat round dense v-close-popup />
      </q-card-section>
      <q-form @submit.prevent="userCreate">
      <q-card-section>
        <div class="row">
          <div class="col-12"><q-input outlined v-model="user.name" label="Nombre completo" required /></div>
          <div class="col-12"><q-input outlined v-model="user.email" label="Email" type="email" required/></div>
          <div class="col-12"><q-select outlined v-model="user.tipo" label="Tipo de usuario" :options="['ADMINISTRADOR','REGISTRADOR']" required /></div>
          <div class="col-12"><q-input outlined v-model="user.fechaLimite" label="Fechalimite de contrato" type="date"/></div>
          <div class="col-12"><q-input outlined v-model="user.password" label="Contraseña" type="password" required /></div>
          <div class="col-12"><q-input outlined v-model="user.password_confirmation" label="Confirmar contraseña" type="password" required /></div>
        </div>
      </q-card-section>
      <q-card-section>
        <div class="row">
          <div class="col-12">
            <q-btn color="green" icon="check_circle" class="full-width" label="Crear" type="submit" :loading="loading"  />
          </div>
        </div>
      </q-card-section>
      </q-form>
    </q-card>
  </q-dialog>
  <q-dialog v-model="userUpdateDialog">
    <q-card>
      <q-card-section class="row items-center q-mb-none">
        <div class="text-h6">Modificar usuario</div>
        <q-space/>
        <q-btn icon="highlight_off" flat round dense v-close-popup />
      </q-card-section>
      <q-form @submit.prevent="userUpdate">
        <q-card-section>
          <div class="row">
            <div class="col-12"><q-input outlined v-model="userU.name" label="Nombre completo" required /></div>
            <div class="col-12"><q-input outlined v-model="userU.email" label="Email" type="email" required/></div>
            <div class="col-12"><q-select outlined v-model="userU.tipo" label="Tipo de usuario" :options="['ADMINISTRADOR','REGISTRADOR']" required /></div>
            <div class="col-12"><q-input outlined v-model="userU.fechaLimite" label="Fechalimite de contrato" type="date"/></div>
          </div>
        </q-card-section>
        <q-card-section>
          <div class="row">
            <div class="col-12">
              <q-btn color="yellow-9" icon="o_edit" class="full-width" label="Modificar" type="submit" :loading="loading"  />
            </div>
          </div>
        </q-card-section>
      </q-form>
    </q-card>
  </q-dialog>
</q-page>
</template>

<script>
import {date} from "quasar";

export default {
  name: `User`,
  data() {
    return {
      users: [],
      userFilterData:"",
      userDialog:false,
      userUpdateDialog:false,
      loading:false,
      user:{tipo:'REGISTRADOR',fechaLimite:'2022-12-31'},
      userU:{},
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
    this.userGet()
  },
  methods: {
    userUpdatePassword(user){
      this.$q.dialog({
        title: 'Cambiar password',
        message: 'Ingrese la nueva contraseña',
        prompt: {
          type: 'password',
          model: '123',
        }
      }).onOk(password => {
        this.loading=true
        this.$api.post('updatePassword/'+user.id,{
          password:password,
          password_confirmation:password
        }).then(response=>{
          this.loading=false
          this.$q.notify({
            color: 'positive',
            textColor: 'white',
            icon: 'check',
            position: 'top',
            message: 'Contraseña cambiada correctamente'
          })
        }).catch(error=>{
          this.loading=false
          this.$q.notify({
            color: 'negative',
            textColor: 'white',
            icon: 'highlight_off',
            message: 'Error al cambiar contraseña'
          })
        })
      })
    },
    deleteUser(user){
      this.$q.dialog({
        title: 'Eliminar usuario',
        message: '¿Está seguro de eliminar este usuario?',
        cancel: 'Cancelar',
        ok: 'Eliminar',
        okColor: 'red',
        cancelColor: 'green',
        icon: 'highlight_off',
        color: 'red',
        persistent: true,
        showCancelButton: true,
        showOkButton: true,
        width: 'auto'
      }).onOk(() => {
        this.loading=true
        this.$api.delete(`user/${user.id}`).then(res => {
          this.loading=false
          this.userGet()
        })
      })
    },
    userCreate(){
      this.loading=true
      this.$api.post('user',this.user).then(res => {
        this.userGet()
        this.loading=false
        this.user={tipo:'REGISTRADOR',fechaLimite:date.formatDate(new Date(),'YYYY-MM-DD')}
        this.userDialog=false
      }).catch(err=>{
        this.loading=false
        this.$q.notify({
          color: 'negative',
          textColor: 'white',
          message: err.response.data.message,
          position: 'top',
          icon: 'error'
        })
      })
    },
    userUpdate(){
      this.loading=true
      this.$api.put('user/'+this.userU.id,this.userU).then(res => {
        this.userGet()
        this.loading=false
        this.userUpdateDialog=false
      }).catch(err=>{
        this.loading=false
        this.$q.notify({
          color: 'negative',
          textColor: 'white',
          message: err.response.data.message,
          position: 'top',
          icon: 'error'
        })
      })
    },
    userGet() {
      this.$api.get('user').then(res => {
        this.users = res.data;
      });
    },
  },
}
</script>

<style scoped>

</style>
