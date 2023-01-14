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
          @click="leftDrawerOpen = !leftDrawerOpen"
        />
        <q-toolbar-title>
          Quasar App
        </q-toolbar-title>
        <div>Quasar v{{ $q.version }}</div>
      </q-toolbar>
    </q-header>
    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
    >
      <q-layout view="lHh lpr lFf" container class="">
        <q-header class="text-subtitle2 text-center bg-white text-grey q-pt-xs" >
          <q-img src="logo.png" width="25px"/>
          miGanancia
        </q-header>

        <q-footer>
          <q-list>
            <q-item clickable v-ripple :class="`bg-white ${link.color}`" @click="logout(link.link)" v-for="(link, index) in links" :key="index">
              <q-item-section avatar>
                <q-icon :name="link.icon" />
              </q-item-section>
              <q-item-section>
                {{ link.label }}
              </q-item-section>
            </q-item>
          </q-list>
        </q-footer>

        <q-page-container>
          <q-card flat bordered class="q-ma-md bg-grey-2">
            <q-list>
              <q-item>
                <q-item-section avatar>
                  <q-avatar>
                    <img :src="`${globalStore.url}../images/${globalStore.shop.avatar}`" v-if="globalStore.shop.avatar!==undefined">
                  </q-avatar>
                </q-item-section>
                <q-item-section>
                  <q-item-label lines="1" class="text-subtitle2 text-grey">{{globalStore.shop.name}}</q-item-label>
                  <q-item-label caption lines="2">
<!--                    <span class="text-weight-bold">Janet</span>-->
                    {{globalStore.shop.address}}
                  </q-item-label>
                </q-item-section>
              </q-item>
              <q-separator inset />
              <q-item clickable v-ripple class="q-py-none q-ma-none" dense>
                <q-item-section class="q-py-none q-ma-none" >
                  <q-item-label> <q-icon name="o_edit" /> Editar negocio</q-item-label>
                </q-item-section>
              </q-item>
              <q-item clickable v-ripple class="q-py-none q-ma-none" dense>
                <q-item-section class="q-py-none q-ma-none" >
                  <q-item-label> <q-icon name="add_circle_outline" /> Agregar otro negocio</q-item-label>
                </q-item-section>
              </q-item>
            </q-list>
          </q-card>
          <pre>{{ globalStore.shop }}</pre>
        </q-page-container>
      </q-layout>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'
import { useGlobalStore } from 'stores/global'
// import { api } from 'boot/axios'
import { useQuasar } from 'quasar'
export default defineComponent({
  name: 'MainLayout',
  setup () {
    const leftDrawerOpen = ref(false)
    const globalStore = useGlobalStore()
    const q = useQuasar()
    const links = [
      { color: 'text-grey', icon: 'o_question_answer', label: '¿Necesitas contactarnos a sopporte? ! Haz click aqui !', link: 'https://api.whatsapp.com/send?phone=+59162963684&text=Muy%20buenas%20tardes%20quisiera%20informaci%C3%B3n%20de%20mi%20ganancia' },
      { color: 'text-grey', icon: 'link', label: 'Terminos y condiciones', link: 'https://www.google.com' },
      { color: 'text-grey', icon: 'link', label: 'Politicas de privacidad', link: 'https://www.google.com' },
      { color: 'text-red', icon: 'logout', label: 'Cerrar sesión', link: 'logout' }
    ]
    return { leftDrawerOpen, globalStore, q, links }
  },
  methods: {
    logout (link: string) {
      if (link === 'logout') {
        this.q.dialog({
          title: 'Cerrar sesión',
          message: '¿Estas seguro de cerrar sesión?',
          ok: { label: 'Si', color: 'yellow-7', textColor: 'black', push: true },
          cancel: { label: 'No', outline: true, push: true }
        }).onOk(() => {
          this.q.loading.show()
          this.$api.post('logout').then(() => {
            this.globalStore.user = {}
            this.globalStore.isLogged = false
            this.globalStore.shop = {}
            this.$api.defaults.headers.common.Authorization = ''
            localStorage.removeItem('tokenMiGan')
            this.$router.push('/login')
          }).catch(() => {
            this.q.notify({
              message: 'Error al cerrar sesión',
              color: 'negative',
              position: 'top'
            })
          }).finally(() => {
            this.q.loading.hide()
          })
        })
      } else {
        window.open(link, '_blank')
      }
    }
  }
})
</script>
