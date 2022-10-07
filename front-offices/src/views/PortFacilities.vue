<template>
  <div>
    <AppNavbar />
    <v-main class="bgmain">
      <v-container fluid class="mb-10 mt-10">
        <v-layout align-center justify-center>
          <router-view/>
        </v-layout>
      </v-container>
      <AppFooter />
    </v-main>
  </div>
</template>

<script>
  import PortFacilitiesForm from '@/components/PortFacilities/PortFacilitiesForm'
  import AppFooter from '@/components/AppFooter.vue'
  import AppNavbar from '@/components/AppNavbar.vue'
  export default {
    name: 'PortFacilities',
    components :{
      PortFacilitiesForm,
      AppFooter,
      AppNavbar,
    }
  }
</script>

<style>

</style>