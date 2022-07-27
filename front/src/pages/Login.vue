<template>
  <q-page>
    <div class="row">
      <div class="col-12 col-md-2"></div>
      <div class="col-12 col-md-8">
        <q-card>
          <q-tabs
            v-model="tab"
            dense
            class="text-grey"
            active-color="primary"
            indicator-color="primary"
            align="justify"
            narrow-indicator
          >
            <q-tab name="login" label="Ingresar" class="full-width" />
          </q-tabs>
          <q-separator />
          <q-tab-panels v-model="tab" animated>
            <q-tab-panel name="login">
              <div class="text-h6">Ingresar al Sistema </div>
              <div class="text-subtitle2 text-grey">Por favor colocar email y contraseña </div>
              <q-form @submit.prevent="login">
                <div class="row">
                  <div class="col-12 ">
                    <q-input type="email" outlined v-model="email" label="Email*" hint="Porfavor ingresar email" :rules="rule">
                      <template v-slot:prepend>
                        <q-icon name="email" />
                      </template>
                    </q-input>
                  </div>
                  <div class="col-12 ">
                    <q-input outlined v-model="password" label="password*" :type="isPwd ? 'password' : 'text'" hint="Porfavor ingresar password" :rules="rule">
                      <template v-slot:prepend>
                        <q-icon name="lock" />
                      </template>
                      <template v-slot:append>
                        <q-icon
                          :name="isPwd ? 'visibility_off' : 'visibility'"
                          class="cursor-pointer"
                          @click="isPwd = !isPwd"
                        />
                      </template>
                    </q-input>
                  </div>
                  <div class="col-12 q-py-md">
                    <q-btn label="INGRESAR" color="primary" icon="login" class="full-width" type="submit"/>
                    <div class="text-caption q-py-xs">
                      <a target="_blank" href="https://api.whatsapp.com/send?phone=59169603027&text=olvide mi contraseña">Olvidate tu contraseña?</a>
                    </div>

                  </div>
                </div>
              </q-form>
            </q-tab-panel>
          </q-tab-panels>
        </q-card>
      </div>
      <div class="col-12 col-md-2">
      </div>
    </div>
  </q-page>
</template>

<script>
import {useCounterStore} from "stores/example-store";
export default {
  name:`Login`,
  data(){
    return{
      tab:'login',
      store:useCounterStore(),
      user:{},
      email:'',
      password:'',
      rule:[
        val => (val && val.length > 0) || 'Por favor escriba algo'
      ],
      isPwd:true,
    }
  },
  created() {
    if (this.store.isLoggedIn){
      this.$router.push('/')
    }
  },
  methods: {
    login(){
      this.$q.loading.show()
      this.$api.post('login', { email:this.email, password:this.password }).then((res) =>{
        this.$q.loading.hide()
        this.store.user=res.data.user
        localStorage.setItem('tokenruiz', res.data.token)
        this.store.isLoggedIn=true
        this.$api.defaults.headers.common['Authorization'] = 'Bearer '+res.data.token
        this.$router.push('/')
      }).catch(err => {
        this.$q.loading.hide();
        this.$q.notify({
          message:err.response.data.res,
          color:'red',
          icon:'error'
        })
      })
    }
  }
}
</script>

<style scoped>

</style>
