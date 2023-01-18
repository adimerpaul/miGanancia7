<template>
  <q-card flat bordered class="q-ma-xs bg-grey-2">
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
            <span class="text-weight-bold">{{globalStore.shop.type}}</span>
          </q-item-label>
        </q-item-section>
        <q-item-section side v-if="globalStore.shops.length>1">
          <q-btn flat dense round icon="keyboard_arrow_down" size="16px">
            <q-menu>
              <q-list>
                <q-item clickable v-ripple v-for="n in globalStore.shops" :key="n.id" @click="changeShop(n)">
                  <q-item-section avatar>
                    <q-avatar>
                      <img :src="`${globalStore.url}../images/${n.avatar}`" v-if="n.avatar!==undefined">
                    </q-avatar>
                  </q-item-section>
                  <q-item-section>
                    <q-item-label>{{ n.name }}</q-item-label>
                    <q-item-label caption lines="1">{{ n.type }}</q-item-label>
                  </q-item-section>
                  <q-item-section side>
                    <q-icon name="check_circle_outline" color="green" v-if="n.id===globalStore.shop.id"/>
                  </q-item-section>
                </q-item>
              </q-list>
            </q-menu>
          </q-btn>
        </q-item-section>
      </q-item>
      <q-separator inset />
      <q-item clickable v-ripple class="q-py-none q-ma-none" dense @click="shopOpen('update')">
        <q-item-section class="q-py-none q-ma-none" >
          <q-item-label> <q-icon size="18px" name="o_edit" /> Editar negocio</q-item-label>
        </q-item-section>
      </q-item>
      <q-item clickable v-ripple class="q-py-none q-ma-none" dense @click="shopOpen('create')">
        <q-item-section class="q-py-none q-ma-none" >
          <q-item-label> <q-icon size="18px" name="add_circle_outline" /> Agregar otro negocio</q-item-label>
        </q-item-section>
      </q-item>
    </q-list>
    <q-dialog v-model="shopDialog" position="right" full-height :maximized="true">
      <q-card style="width: 500px; max-width: 80vw;">
        <q-card-actions class="row items-center text-h6">
          {{shopCreate ? 'Agregar otro negocio' : 'Editar negocio'}}
          <q-space />
          <q-btn flat dense round icon="highlight_off" @click="shopDialog = false" />
        </q-card-actions>
        <q-card-section>
          <q-form @submit.prevent="shopSubmit">
            <div class="text-grey">Los campos marcados con asterisco (<span class="text-red">*</span>) son obligatorios</div>
            <div class="flex flex-center">
              <q-uploader
                accept=".jpg, .png"
                multiple
                auto-upload
                label="Arrastra una imagen o haz click para seleccionar"
                @finish="finishFn"
                ref="uploader"
                max-files="1"
                auto-expand
                :url="`${globalStore.url}upload/${shopCreate ? globalStore.user.id : globalStore.shop.id}/${shopCreate ? 'shopNew' : 'shop'}`"
                stack-label="upload image"/>
            </div>
            <div class="text-grey">Te recomendamos que la imagen tenga un tamaño de 500 x 500 px en formato PNG y pese máximo 2MB.</div>
            <q-select
              filled
              v-model="shop.type"
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
              <template v-slot:label>
                <div class="row items-center all-pointer-events">
                  Tipo negocio <span class="text-red">*</span>
                </div>
              </template>
            </q-select>
            <q-input filled v-model="shop.name" label="Nombre del negocio" :rules="[val => val.length > 0 || 'El nombre del negocio es requerido']" >
              <template v-slot:label>
                <div class="row items-center all-pointer-events">
                  Nombre del negocio <span class="text-red">*</span>
                </div>
              </template>
            </q-input>
            <q-input filled v-model="shop.address" label="Dirección del negocio" hint="" />
            <q-input filled v-model="shop.city" label="Ciudad del negocio" hint="" />
            <q-input filled v-model="shop.phone" label="Teléfono del negocio" hint="" />
            <q-input filled v-model="shop.email" label="Correo electrónico del negocio" hint="" />
            <q-input filled v-model="shop.document" label="Documento del negocio" hint="" />
            <q-btn :loading="loading" color="yellow-7" :label="shopCreate?'Crear Negocio':'Guardar cambios'"  type="submit" class="full-width text-black" no-caps  />
            <q-btn :loading="loading" @click="negocioDelete" v-if="!shopCreate" flat color="red" label="Eliminar negocio" icon="o_delete" class="full-width text-black q-mt-md" no-caps  />
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
  </q-card>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'
import { useGlobalStore } from 'stores/global'
import { useQuasar } from 'quasar'
import { Meta } from 'components/models'
export default defineComponent({
  name: 'ShopChangeComponent',
  setup (/* props */) {
    const globalStore = useGlobalStore()
    const shop = ref({})
    const shopCreate = ref(false)
    const shopDialog = ref(false)
    const loading = ref(false)
    const q = useQuasar()
    return { globalStore, shop, shopCreate, shopDialog, loading, q }
  },
  methods: {
    negocioDelete () {
      this.q.dialog({
        title: 'Eliminar negocio',
        message: '¿Estas seguro de eliminar este negocio?',
        ok: { label: 'Si', color: 'yellow-7', textColor: 'black', push: true },
        cancel: { label: 'No', outline: true, push: true }
      }).onOk(() => {
        this.loading = true
        this.$api.delete(`shops/${this.globalStore.shop.id}`)
          .then((res) => {
            this.loading = false
            this.shopDialog = false
            this.globalStore.shop = res.data.shop
            this.globalStore.shops = res.data.shops
          })
          .catch((err) => {
            this.loading = false
            this.q.notify({
              color: 'negative',
              message: err.response.data.message,
              position: 'top',
              timeout: 2500
            })
          })
      })
    },
    changeShop (shop: any) {
      this.globalStore.shop = shop
      this.$api.post(`shopStatusActive/${shop.id}`)
    },
    shopOpen (status: string) {
      if (status === 'create') {
        this.$api.put(`users/${this.globalStore.user.id}`, { shopAvatar: '' })
        this.shop = {
          name: ''
        }
        this.shopCreate = true
      } else {
        this.shop = this.globalStore.shop
        this.shopCreate = false
      }
      this.shopDialog = true
    },
    shopSubmit () {
      this.loading = true
      if (this.shopCreate) {
        this.shop.user_id = this.globalStore.user.id
        this.$api.post('shops', this.shop).then((res: any) => {
          this.globalStore.shops = res.data.shops
          this.globalStore.shop = res.data.shop
          this.shopDialog = false
        }).finally(() => {
          this.loading = false
        })
      } else {
        this.$api.put(`shops/${this.globalStore.shop.id}`, this.shop).then((res) => {
          this.globalStore.shop = res.data
          this.shopDialog = false
        }).finally(() => {
          this.loading = false
        })
      }
    },
    finishFn () {
      if (!this.shopCreate) {
        this.$api.get(`shops/${this.globalStore.shop.id}`).then((response) => {
          this.globalStore.shop = response.data.shop
          this.globalStore.shops = response.data.shops
        })
      }
    }
  }
})
</script>
