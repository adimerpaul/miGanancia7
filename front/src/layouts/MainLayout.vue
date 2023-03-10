<template>
  <q-layout view="lHh Lpr lFf">
    <q-header :class="`border-bottom-${url==='' ? 'green' : 'black'}`">
      <q-toolbar class="bg-white text-black">
        <q-btn flat dense round icon="menu" aria-label="Menu" @click="leftDrawerOpen = !leftDrawerOpen"/>
        <q-toolbar-title>
          {{url==='' ? 'Movimientos' : 'Inventario'}}
        </q-toolbar-title>
        <div>
          <button-component></button-component>
        </div>
      </q-toolbar>
    </q-header>
    <q-drawer v-model="leftDrawerOpen" show-if-above bordered :width="300" :breakpoint="400">
      <q-layout view="lHh lpr lFf" container>
        <q-header class="text-subtitle2 text-center bg-white text-grey q-pt-xs" >
          <q-img src="logo.png" width="25px"/>
          miGanancia
        </q-header>
        <q-page-container>
          <ShopChangeComponent class="q-ma-md"/>
          <q-list >
            <q-item active-class="bg-yellow-5 text-bold" exact clickable v-ripple :class="`${option.color}`" :to="option.link" v-for="(option, index) in options" :key="index">
              <q-item-section avatar>
                <q-icon :name="option.icon" />
              </q-item-section>
              <q-item-section>
                {{ option.label }}
              </q-item-section>
            </q-item>
            <q-separator spaced />
            <q-item-label header>Gestióna tus contactos</q-item-label>
            <q-item active-class="bg-yellow-5 text-bold" exact clickable v-ripple :class="`${contact.color}`" :to="contact.link" v-for="(contact, index) in contacts" :key="index">
              <q-item-section avatar>
                <q-icon :name="contact.icon" />
              </q-item-section>
              <q-item-section>
                {{ contact.label }}
              </q-item-section>
            </q-item>
          </q-list>
        </q-page-container>
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
import { useQuasar } from 'quasar'
import ShopChangeComponent from 'components/ShopChangeComponent.vue'
import ButtonComponent from 'components/ButtonComponent.vue'
export default defineComponent({
  name: 'MainLayout',
  components: {
    ShopChangeComponent,
    ButtonComponent
  },
  setup () {
    const shopDialog = ref(false)
    const loading = ref(false)
    const shop = ref({})
    const shopCreate = ref(true)
    const leftDrawerOpen = ref(false)
    const globalStore = useGlobalStore()
    const q = useQuasar()
    const links = [
      { color: 'text-grey', icon: 'o_question_answer', label: '¿Necesitas contactarnos a sopporte? ! Haz click aqui !', link: 'https://api.whatsapp.com/send?phone=+59162963684&text=Muy%20buenas%20tardes%20quisiera%20informaci%C3%B3n%20de%20mi%20ganancia' },
      { color: 'text-grey', icon: 'link', label: 'Terminos y condiciones', link: 'https://www.google.com' },
      { color: 'text-grey', icon: 'link', label: 'Politicas de privacidad', link: 'https://www.google.com' },
      { color: 'text-red', icon: 'logout', label: 'Cerrar sesión', link: 'logout' }
    ]
    const options = [
      { color: 'text-black', label: 'Movimientos', link: '/', icon: 'o_account_balance_wallet' },
      { color: 'text-black', label: 'Inventario', link: '/inventory', icon: 'o_store' }
    ]
    const contacts = [
      { color: 'text-black', label: 'Clientes', link: '/clients', icon: 'o_people' },
      { color: 'text-black', label: 'Proveedores', link: '/providers', icon: 'o_people' }
    ]
    return { leftDrawerOpen, globalStore, q, links, shopDialog, shopCreate, shop, loading, options, contacts }
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
            this.globalStore.user = {
              id: 0
            }
            this.globalStore.isLogged = false
            this.globalStore.shop = { id: 0 }
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
  },
  computed: {
    url () {
      const url = this.$route.path.split('/')
      return url[1]
    }
  }
})
</script>
