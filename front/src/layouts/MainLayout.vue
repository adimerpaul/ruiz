<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
        />

        <q-toolbar-title>
          {{store.user.name}}
        </q-toolbar-title>

        <div>
          <q-btn
            v-if="store.isLoggedIn"
            flat
            color=""
            dense
            round
            icon="power_settings_new"
            aria-label="Notifications"
            @click="logout"
          >
            <q-tooltip>Salir</q-tooltip>
          </q-btn>
        </div>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
    >
      <q-list>
        <q-item-label
          header
        >
          Opciones de menu
        </q-item-label>
        <q-item clickable exact to="login" v-if="!store.isLoggedIn">
          <q-item-section avatar>
            <q-icon name="login" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Login</q-item-label>
            <q-item-label caption>Ingreso al sistema</q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable exact to="/" v-if="store.isLoggedIn">
          <q-item-section avatar>
            <q-icon name="o_home" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Principal</q-item-label>
            <q-item-label caption>Menu principal</q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable exact to="user" v-if="store.isLoggedIn">
          <q-item-section avatar>
            <q-icon name="o_person_add" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Usuarios</q-item-label>
            <q-item-label caption>Control de usuarios</q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable exact @click="logout" v-if="store.isLoggedIn">
          <q-item-section avatar>
            <q-icon name="power_settings_new" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Salir</q-item-label>
            <q-item-label caption>Salir del sistema</q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import {useCounterStore} from "stores/example-store";

export default {
  name: 'MainLayout',
  data () {
    return {
      leftDrawerOpen: false,
      store: useCounterStore(),
    }
  },
  methods: {
    toggleLeftDrawer () {
      this.leftDrawerOpen = !this.leftDrawerOpen
    },
    logout(){
      this.$q.dialog({
        message:'¿Quieres cerrar sesión?',
        title:"Salir",
        ok:{
          push:true
        },
        cancel:{
          push:true,
          color:'negative'
        }
      }).onOk(()=>{
        this.$q.loading.show()
        this.$api.post('logout').then(res=>{
          this.$api.defaults.headers.common['Authorization']=''
          this.store.user={}
          localStorage.removeItem('tokenruiz')
          this.store.isLoggedIn=false
          this.$router.push('/login')
          this.$q.loading.hide()
        })
      })
    }
  }
}
</script>
