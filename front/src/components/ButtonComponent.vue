<template>
<div>
  <template v-if="url===''">
    <q-btn-dropdown
      color="green-7"
      no-caps
      icon="add_circle_outline"
      :label="$q.screen.lt.md ? '' : 'Nueva venta'"
    >
      <q-list>
        <q-item clickable v-close-popup>
          <q-item-section avatar>
            <q-avatar icon="o_shopping_basket" color="grey-3" text-color="grey" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Venta de productos</q-item-label>
            <q-item-label caption>Registrar una venta seleccionando los productos de tu inventario</q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable v-close-popup>
          <q-item-section avatar>
            <q-avatar icon="o_payment" color="grey-3" text-color="grey" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Venta libre</q-item-label>
            <q-item-label caption>Registrar un ingreso sin seleccionar productos de tu inventario</q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </q-btn-dropdown>
    <q-btn color="red-9" class="q-ml-xs" no-caps icon="remove_circle_outline" :label="$q.screen.lt.md ? '' : 'Nuevo gasto'" />
  </template>
  <template v-if="url==='inventory'">
    <q-btn outline no-caps :label="$q.screen.lt.md ? 'Cate' : 'Crear categoria'" @click="categoryClick" />
    <q-btn-dropdown
      color="yellow-7"
      no-caps
      class="q-ml-xs text-black"
      :label="$q.screen.lt.md ? 'Produc' : 'Agregar productos'"
    >
      <q-list>
        <q-item clickable v-close-popup>
          <q-item-section avatar>
            <q-avatar icon="o_sell" text-color="grey" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Crear producto manualmente</q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable v-close-popup>
          <q-item-section avatar>
            <q-avatar icon="attach_file" text-color="green" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Subir archivo desde excel</q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </q-btn-dropdown>
  </template>
  <q-dialog v-model="categoryDialog" position="right" full-height :maximized="true">
    <q-card style="width: 500px; max-width: 80vw;">
      <q-card-actions class="row items-center text-h6">
        {{categoryCreate ? 'Crear categoria' : 'Editar categoria'}}
        <q-space />
        <q-btn flat dense round icon="highlight_off" @click="categoryDialog = false" />
      </q-card-actions>
      <q-card-section>
        <q-form @submit.prevent="categorySubmit">
          <q-input filled v-model="category.name" label="Nombre de la categoria" :rules="[val => val.length > 0 || 'El nombre de la categoria es obligatorio']">
            <template v-slot:label>
              <div class="row items-center all-pointer-events">
                Nombre del negocio <span class="text-red">*</span>
              </div>
            </template>
          </q-input>
<!--          <q-input filled v-model="shop.address" label="Dirección del negocio" hint="" />-->
          <q-btn :loading="loading" color="yellow-7" :label="categoryCreate?'Crear categoria':'Guardar cambios'"  type="submit" class="full-width text-black" no-caps  />
<!--          <q-btn :loading="loading" @click="negocioDelete" v-if="!shopCreate" flat color="red" label="Eliminar negocio" icon="o_delete" class="full-width text-black q-mt-md" no-caps  />-->
        </q-form>
      </q-card-section>
    </q-card>
  </q-dialog>
</div>
</template>
<script lang="ts">
import { defineComponent, ref } from 'vue'
import { useGlobalStore } from 'stores/global'
export default defineComponent({
  name: 'ButtonComponent',
  setup () {
    const categoryDialog = ref(false)
    const categoryCreate = ref(true)
    const loading = ref(false)
    const globalStore = useGlobalStore()
    const category = ref({
      name: '',
      shop_id: 0
    })
    return { categoryDialog, categoryCreate, category, loading, globalStore }
  },
  methods: {
    categoryClick () {
      this.categoryDialog = true
      this.categoryCreate = true
      this.category = {
        name: '',
        shop_id: 0
      }
    },
    categorySubmit () {
      if (this.categoryCreate) {
        this.loading = true
        this.category.shop_id = this.globalStore.shop.id
        this.$api.post('categories', this.category).then((response) => {
          this.loading = false
          this.categoryDialog = false
          this.globalStore.categories = response.data
          this.$q.notify({
            message: 'Categoria creada',
            color: 'green-4',
            textColor: 'white',
            icon: 'check_circle'
          })
        }).catch((error) => {
          this.loading = false
          this.$q.notify({
            message: error.response.data.message,
            color: 'red-4',
            textColor: 'white',
            icon: 'error'
          })
        })
      } else {
        this.loading = true
        setTimeout(() => {
          this.loading = false
          this.categoryDialog = false
        }, 2000)
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
