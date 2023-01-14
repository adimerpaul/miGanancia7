<template>
  <q-layout>
    <q-page-container>
      <q-page>
        <div :class="$q.screen.lt.md ? 'row' : 'row reverse'">
          <div class="col-12 col-md-7">
            <q-page class="flex flex-center">
              <div class="column">
                <q-form class="full-width" @submit.prevent="login">
                  <div class="text-h4 text-bold" style="width: 300px;max-width:50vh">{{userLogin? 'Iniciar sesión' : 'Registrarse'}}</div>
                  <div class="q-mt-md text-grey">{{userLogin? 'Inicia sesión para acceder a tu cuenta' : 'Regístrate para acceder a tu cuenta'}}</div>
                  <q-input
                    v-model="user.email"
                    label="Email"
                    filled
                    :rules="[val => val && val.length > 0 || 'El email es requerido']"
                  />
                  <q-input
                    v-model="user.password"
                    label="Contraseña"
                    filled
                    :type="showPassword ? 'text' : 'password'"
                    :rules="[val => val && val.length > 0 || 'La contraseña es requerida']"
                  >
                    <template v-slot:append>
                      <q-icon :name="showPassword ? 'visibility' : 'visibility_off'" class="cursor-pointer" @click="showPassword = !showPassword" />
                    </template>
                  </q-input>
                  <div v-if="userLogin">
                    <q-btn
                      :loading="loading"
                      label="Iniciar sesión"
                      no-caps
                      type="submit"
                      color="yellow-7"
                      text-color="black"
                      class="q-mt-xs full-width"
                    />
                    <q-btn
                      :loading="loading"
                      outline
                      label="Registrarse"
                      no-caps
                      color="black"
                      class="q-mt-md full-width"
                      @click="userLogin = !userLogin"
                    />
                  </div>
                  <div v-else>
                    <q-input
                      v-model="user.password_confirmation"
                      label="Confirmar contraseña"
                      filled
                      :type="showPassword ? 'text' : 'password'"
                      :rules="[val => val && val.length > 0 || 'La contraseña es requerida' , val => val === user.password || 'Las contraseñas no coinciden']"
                    >
                      <template v-slot:append>
                        <q-icon :name="showPassword ? 'visibility' : 'visibility_off'" class="cursor-pointer" @click="showPassword = !showPassword" />
                      </template>
                    </q-input>
                    <q-input
                      v-model="user.name"
                      label="Nombre"
                      filled
                      :rules="[val => val && val.length > 0 || 'El nombre es requerido']"
                    />
                    <q-input v-model="user.nameShop" label="Nombre de la tienda" filled :rules="[val => val && val.length > 0 || 'El nombre de la tienda es requerido']" />
                    <q-select
                      filled
                      v-model="user.type"
                      name="type"
                      :options="globalStore.typeShops"
                      options-dense
                      emit-value
                      map-options
                      label="Selecciona el tipo de tienda"
                      :rules="[val => val && Object.keys(val).length > 0 || 'El tipo de tienda es requerido']"
                    >
                      <template v-slot:option="scope">
                        <q-item v-bind="scope.itemProps">
                          <q-item-section avatar>
                            <q-icon :name="scope.opt.icon" />
                          </q-item-section>
                          <q-item-section>
                            <q-item-label>{{ scope.opt.label }}</q-item-label>
                          </q-item-section>
                        </q-item>
                      </template>
                    </q-select>
                    <q-btn
                      :loading="loading"
                      outline
                      type="submit"
                      label="Registrarse"
                      no-caps
                      color="black"
                      class="q-mt-xs full-width"
                    />
                    <q-btn
                      :loading="loading"
                      label="Iniciar sesión"
                      no-caps
                      color="yellow-7"
                      text-color="black"
                      class="q-mt-md full-width"
                      @click="userLogin = !userLogin"
                    />
                  </div>
                </q-form>
              </div>
            </q-page>
          </div>
          <div class="col-12 col-md-5  background flex flex-center">
          <q-page class="flex flex-center">
              <q-carousel
                v-model="slide"
                transition-prev="scale"
                transition-next="scale"
                swipeable
                animated
                control-color="black"
                navigation
                padding
                :autoplay="5000"
                infinite
                arrows
                style="height: 100%; width: 100%;"
                class="background rounded-borders"
              >
                <q-carousel-slide :name="slide.name" class="column no-wrap flex-center" v-for="(slide, index) in slides" :key="index">
                  <q-img :src="slide.img" height="350px"></q-img>
                  <div class="text-h6 text-bold">{{ slide.title }}</div>
                  <div class="q-mt-md text-center text-grey" v-html="slide.text"></div>
                </q-carousel-slide>
              </q-carousel>
          </q-page>
          </div>
        </div>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'
import { useGlobalStore } from 'stores/global'
import { api } from 'boot/axios'
import { useQuasar } from 'quasar'

export default defineComponent({
  name: 'LoginLayout',
  setup () {
    const q = useQuasar()
    const slide = ref('slide1')
    const user = ref({})
    const loading = ref(false)
    const userLogin = ref(true)
    const showPassword = ref(false)
    const globalStore = useGlobalStore()
    const lorem = 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Itaque voluptatem totam, architecto cupiditate officia rerum, error dignissimos praesentium libero ab nemo.'
    const slides = [
      {
        name: 'slide1',
        title: 'Carga todo tu inventario en un solo lugar',
        text: 'Lo mejor de tu App, ¡ahora disponible en tu computador!<br> <br> Además, agregamos nuevas funciones que te encantarán, como la posibilidad de llevar grandes inventarios.',
        img: '61ae42d8388fc22bce57e509_img-appweb-home.webp'
      },
      {
        name: 'slide2',
        title: '100% gratis',
        text: 'Utiliza la App miGanancia Libre sin costo alguno. <br> <br> ¡Y si te gusta, puedes descargar la App de Mercado Libre para Android!',
        img: '6255c69655538902457f5fa8_vende-en-linea.webp'
      },
      {
        name: 'slide3',
        title: 'Pequeños negocios',
        text: 'Si tienes un pequeño negocio, la App miGanancia Libre te permite llevar tu inventario en un solo lugar, sin costo alguno.',
        img: '6255c65e6420905ef89a1c8a_pequeños-negocios.png'
      },
      {
        name: 'slide4',
        title: 'Mejora tu experiencia',
        text: 'La App miGanancia Libre te permite llevar tu inventario en un solo lugar, sin costo alguno.',
        img: '62545e4559e61017ad894133_metodos-de-pago-p-800.webp'
      }
    ]
    return { slide, lorem, slides, user, showPassword, userLogin, globalStore, q, loading }
  },
  methods: {
    userValidate (text: string, res: any) {
      this.globalStore.user = res.data.user
      this.globalStore.shop = res.data.user.shop
      this.$router.push('/')
      this.globalStore.isLogged = true
      api.defaults.headers.common.Authorization = `Bearer ${res.data.token}`
      localStorage.setItem('tokenMiGan', res.data.token)
      this.q.notify({
        message: text,
        color: 'green-4',
        textColor: 'white',
        icon: 'check_circle',
        position: 'top'
      })
    },
    login () {
      this.loading = true
      if (this.userLogin) {
        api.post('login', this.user).then((res) => {
          this.userValidate('Bienvenido', res)
        }).catch((err) => {
          this.q.notify({
            position: 'top',
            message: err.response.data.message,
            color: 'negative',
            icon: 'error'
          })
        }).finally(() => {
          this.loading = false
        })
      } else {
        api.post('register', this.user).then((res) => {
          this.userValidate('Usuario registrado correctamente', res)
        }).catch((err) => {
          this.q.notify({
            message: err.response.data.message,
            color: 'red-4',
            textColor: 'white',
            icon: 'error',
            position: 'top'
          })
        }).finally(() => {
          this.loading = false
        })
      }
    }
  }
})
</script>
