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
  <CategoryCreate :categoryCreate="categoryCreate" @close="closeDialog" :category="category" />
  </q-dialog>
</div>
</template>
<script lang="ts">
import { defineComponent, ref } from 'vue'
import { useGlobalStore } from 'stores/global'
import CategoryCreate from './CategoryCreate.vue'
export default defineComponent({
  name: 'ButtonComponent',
  components: {
    CategoryCreate
  },
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
    closeDialog () {
      this.categoryDialog = false
    },
    categoryClick () {
      this.categoryDialog = true
      this.categoryCreate = true
      this.category = {
        name: '',
        shop_id: 0
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
