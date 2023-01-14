import { boot } from 'quasar/wrappers'
import axios, { AxiosInstance } from 'axios'
import { useGlobalStore } from 'stores/global'
// Import the functions you need from the SDKs you need

declare module '@vue/runtime-core' {
  interface ComponentCustomProperties {
    $api: AxiosInstance;
  }
}

// Be careful when using SSR for cross-request state pollution
// due to creating a Singleton instance here;
// If any client changes this (global) instance, it might be a
// good idea to move this instance creation inside of the
// "export default () => {}" function below (which runs individually
// for each client)
const api = axios.create({ baseURL: import.meta.env.VITE_API_BACK })

export default boot(({ app, router }) => {
  // for use inside Vue files (Options API) through this.$axios and this.$api

  app.config.globalProperties.$axios = axios
  // ^ ^ ^ this will allow you to use this.$axios (for Vue Options API form)
  //       so you won't necessarily have to import axios in each vue file
  const token = localStorage.getItem('tokenMiGan')
  if (token) {
    api.defaults.headers.common.Authorization = `Bearer ${token}`
    api.defaults.headers.common['Content-Type'] = 'application/json'
    api.post('me').then((response) => {
      useGlobalStore().user = response.data
      useGlobalStore().shop = response.data.shop
      useGlobalStore().isLogged = true
    }).catch((error) => {
      useGlobalStore().isLogged = false
      localStorage.removeItem('tokenMiGan')
      useGlobalStore().user = {}
      console.log(error)
      router.push('/login')
    })
  }
  app.config.globalProperties.$api = api
  // ^ ^ ^ this will allow you to use this.$api (for Vue Options API form)
  //       so you can easily perform requests against your app's API
})

export { api }
