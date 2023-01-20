<template>
    <q-card style="width: 500px; max-width: 80vw;">
      <q-card-actions class="row items-center text-h6">
        {{categoryCreate ? 'Crear categoria' : 'Editar categoria'}}
        <q-space />
        <q-btn flat dense round icon="highlight_off" @click="$emit('close')" />
      </q-card-actions>
      <q-card-section>
        <q-form @submit.prevent="categorySubmit">
          <q-input filled v-model="categoryLocal.name" label="Nombre de la categoria" :rules="[val => val.length > 0 || 'El nombre de la categoria es obligatorio']">
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
</template>
<script lang="ts">
import { defineComponent, PropType, ref } from 'vue'
import { useGlobalStore } from 'stores/global'
import { Category } from 'components/models'
export default defineComponent({
  props: {
    category: {
      type: Object as PropType<Category>,
      required: true
    },
    categoryCreate: {
      type: Boolean,
      default: true
    }
  },
  name: 'CategoryCreate',
  setup () {
    // const categoryDialog = ref(false)
    // const categoryCreate = ref(true)
    const loading = ref(false)
    const globalStore = useGlobalStore()
    const categoryLocal = ref({})
    return { loading, globalStore, categoryLocal }
  },
  created () {
    this.categoryLocal = this.category
  },
  methods: {
    categorySubmit () {
      if (this.categoryCreate) {
        this.loading = true
        this.categoryLocal.shop_id = this.globalStore.shop.id
        this.$api.post('categories', this.categoryLocal).then((response) => {
          this.globalStore.categories = response.data
          this.$emit('close')
          this.$q.notify({
            message: 'Categoria creada',
            color: 'green-4',
            textColor: 'white',
            icon: 'check_circle'
          })
        }).catch((error) => {
          this.$q.notify({
            message: error.response.data.message,
            color: 'red-4',
            textColor: 'white',
            icon: 'error'
          })
        }).finally(() => {
          this.loading = false
        })
      } else {
        this.loading = true
        setTimeout(() => {
          this.loading = false
          // this.categoryDialog = false
        }, 2000)
      }
    }
  }
})
</script>
