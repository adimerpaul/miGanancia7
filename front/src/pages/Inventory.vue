<template>
  <q-page>
    <div class="row q-pt-md">
      <div class="col-12 col-md-3 flex flex-center">
        <q-input outlined dense v-model="productSearch" placeholder="Buscar producto" clearable hide-hint>
          <template v-slot:prepend>
            <q-icon name="search" />
          </template>
        </q-input>
      </div>
      <div class="col-6 col-md-3">
        <q-list>
          <q-item class="border-all-grey-round q-py-none">
            <q-item-section>
              <q-item-label class="text-subtitle2"> <q-icon name="qr_code" /> Activar lector</q-item-label>
            </q-item-section>
            <q-item-section avatar>
              <q-toggle color="green" v-model="qr" val="qrActive" />
            </q-item-section>
          </q-item>
        </q-list>
      </div>
      <div class="col-6 col-md-3">
        <q-list>
          <q-item class="border-all-grey-round q-py-none">
            <q-item-section>
              <q-item-label class="text-subtitle2"> <q-icon name="qr_code" /> Activar impresora</q-item-label>
            </q-item-section>
            <q-item-section avatar>
              <q-toggle color="green" v-model="print" val="printActive" />
            </q-item-section>
          </q-item>
        </q-list>
      </div>
      <div class="col-12 col-md-3 flex flex-center">
        <q-btn flat icon="attach_file" label="Descargar reporte" no-caps />
      </div>
      <div class="col-12 col-md-6 q-pa-md">
        <q-card bordered flat>
          <q-item >
            <q-item-section avatar >
              <q-avatar square  icon="view_in_ar" color="grey-1" text-color="grey" size="60px" />
            </q-item-section>
            <q-item-section>
              <q-item-label class="text-subtitle2 text-grey">Total de referencias</q-item-label>
              <q-item-label class="text-h5">100</q-item-label>
            </q-item-section>
          </q-item>
          <q-tooltip>
            Este es el total de referencias de productos que hay en tu inventario.
          </q-tooltip>
        </q-card>
      </div>
      <div class="col-12 col-md-6 q-pa-md">
        <q-card bordered flat>
          <q-item >
            <q-item-section avatar >
              <q-avatar square  icon="monetization_on" color="green-1" text-color="green" size="60px" />
            </q-item-section>
            <q-item-section>
              <q-item-label class="text-subtitle2 text-grey">Costo total de inventario</q-item-label>
              <q-item-label class="text-h5 text-green">100 Bs</q-item-label>
            </q-item-section>
          </q-item>
        </q-card>
      </div>
      <div class="col-12 col-sm-3 q-pa-xs flex flex-center">
        <q-btn class="full-width full-height" @click="categoryUpdate" label="Editar categorías" icon="o_edit" outline no-caps/>
      </div>
      <div class="col-12 col-sm-3 q-pa-xs flex flex-center">
        <q-select class="full-width full-height text-bold" dense :options="globalStore.categoryOptions" v-model="category" emit-value map-options outlined />
      </div>
      <div class="col-12 col-sm-6 q-pa-xs flex flex-center">
        <q-select class="full-width full-height" dense outlined emit-value map-options v-model="order" :options="orderOption">
          <template v-slot:selected>
            <span class="text-bold">Ordernar: </span>
            <div v-if="order" class="q-pl-xs">
              {{ order }}
            </div>
            <q-badge v-else>*none*</q-badge>
          </template>
        </q-select>
      </div>
      <div class="col-12">
        <q-card flat>
          <q-card-section>
            <div class="row">
              <div class="col-12 flex flex-center">
                <q-avatar size="150px" font-size="150px" color="white" text-color="grey" icon="view_in_ar" />
              </div>
              <div class="col-12">
                <div class="text-bold text-grey text-center">No tienes productos en tu inventario</div>
              </div>
              <div class="col-12 col-sm-6 text-center">
                <q-btn size="lg" color="grey-8" label="Agregar manualmente" outline no-caps />
              </div>
              <div class="col-12 col-sm-6 text-center">
                <q-btn size="lg" text-color="grey-9" color="yellow-6" label="Subir productos desde Excel" no-caps class="text-black"/>
              </div>
            </div>
          </q-card-section>
        </q-card>
      </div>
    </div>
    <q-dialog v-model="categoryDialog" position="right" full-height :maximized="true">
    <q-card style="width: 500px; max-width: 80vw;">
      <q-card-actions class="row items-center text-h6">
        Editar categorias
        <q-space />
        <q-btn flat dense round icon="highlight_off" v-close-popup />
      </q-card-actions>
      <q-card-section>
        <q-table :filter="categorySearch" :rows="globalStore.categories" :rows-per-page-options="[0]" flat hide-bottom hide-header :columns="categoryColumns">
          <template v-slot:top >
            <q-input outlined v-model="categorySearch" placeholder="Buscar" class="full-width" dense>
              <template v-slot:append>
                <q-icon name="search" />
              </template>
            </q-input>
          </template>
          <template v-slot:body="props">
            <q-tr :props="props">
              <q-td :props="props" key="name">
                {{props.row.name }}
              </q-td>
              <q-td :props="props" key="option">
                <q-icon name="arrow_forward_ios"/>
              </q-td>
            </q-tr>
          </template>
<!--          <template v-slot:body-cell-name="props">-->
<!--            <q-td :props="props" class="row items-center">-->
<!--              {{props.row.name }}-->
<!--            </q-td>-->
<!--          </template>-->
<!--          <template v-slot:body-cell-option="props">-->
<!--            <q-td :props="props" auto-width>-->
<!--              <q-icon name="arrow_forward_ios"/>-->
<!--            </q-td>-->
<!--          </template>-->
        </q-table>
        <q-btn  color="yellow-7" label="Crear categoria"  type="submit" class="full-width text-black" no-caps  />
      </q-card-section>
    </q-card>
    </q-dialog>
  </q-page>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'
import { useGlobalStore } from 'stores/global'

export default defineComponent({
  name: 'InventoryPage',
  setup () {
    const productSearch = ref('')
    const qr = ref(false)
    const categorySearch = ref('')
    const print = ref(false)
    const category = ref(0)
    const globalStore = useGlobalStore()
    const categoryDialog = ref(false)
    const order = ref('Productos más vendidos')
    const orderOption = ref([
      { label: 'Productos más vendidos', value: 'Productos más vendidos', icon: 'list' },
      { label: 'Alfabéticamente', value: 'Alfabéticamente', icon: 'list' },
      { label: 'Productos más rentables', value: 'Productos más rentables', icon: 'list' },
      { label: 'Últimas unidades disponibles', value: 'Últimas unidades disponibles', icon: 'list' }
    ])
    const categoryColumns = ref([
      { name: 'name', label: 'Nombre', field: 'name', align: 'left' },
      { name: 'option', label: 'Opciones', field: 'option', align: 'right' }
    ])
    return { productSearch, qr, print, category, order, orderOption, globalStore, categoryDialog, categorySearch, categoryColumns }
  },
  mounted () {
    this.categoriesGet()
  },
  methods: {
    categoriesGet () {
      this.$api.get('categories').then((response) => {
        this.globalStore.categories = response.data
      })
    },
    categoryUpdate () {
      this.categoryDialog = true
    }
  }
})
</script>
