import { defineStore } from 'pinia'

export const useGlobalStore = defineStore('counter', {
  state: () => ({
    counter: 0,
    user: {},
    isLogged: !!localStorage.getItem('tokenMiGan'),
    permissions: [],
    url: import.meta.env.VITE_API_BACK,
    shop: {},
    typeShops: [
      { label: 'Industria o manufactura', value: 'Industria o manufactura', icon: 'o_business' },
      { label: 'Servicios de trasporte', value: 'Servicios de trasporte', icon: 'o_local_shipping' },
      { label: 'Servicios de salud', value: 'Servicios de salud', icon: 'o_local_hospital' },
      { label: 'Servicios de educación', value: 'Servicios de educación', icon: 'o_school' },
      { label: 'Servicios de alimentación', value: 'Servicios de alimentación', icon: 'o_fastfood' },
      { label: 'Servicios de belleza', value: 'Servicios de belleza', icon: 'o_face' },
      { label: 'Servicios de entretenimiento', value: 'Servicios de entretenimiento', icon: 'o_videogame_asset' },
      { label: 'Servicios de tecnología', value: 'Servicios de tecnología', icon: 'o_computer' },
      { label: 'Servicios de hogar', value: 'Servicios de hogar', icon: 'o_home' },
      { label: 'Servicios de mascotas', value: 'Servicios de mascotas', icon: 'o_pets' },
      { label: 'Servicios de deportes', value: 'Servicios de deportes', icon: 'o_sports' },
      { label: 'Servicios de ropa', value: 'Servicios de ropa', icon: 'o_shopping_basket' },
      { label: 'Servicios de otros', value: 'Servicios de otros', icon: 'o_more_horiz' }
    ]
  }),

  getters: {
    doubleCount (state) {
      return state.counter * 2
    }
  },

  actions: {
    increment () {
      this.counter++
    }
  }
})
