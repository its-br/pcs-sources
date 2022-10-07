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
  import MooringOperatorsForm from '@/components/MooringOperators/MooringOperatorsForm'
  import AppFooter from '@/components/AppFooter.vue'
  import AppNavbar from '@/components/AppNavbar.vue'
  export default {
    name: 'MooringOperators',
    components :{
      MooringOperatorsForm,
      AppFooter,
      AppNavbar,
    }
  }
</script>

<style>

</style>