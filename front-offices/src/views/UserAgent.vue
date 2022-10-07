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
  import UserAgentForm from '@/components/UserAgent/UserAgentForm'
  import AppFooter from '@/components/AppFooter.vue'
  import AppNavbar from '@/components/AppNavbar.vue'
  export default {
    name: 'UserAgent',
    components :{
      UserAgentForm,
      AppFooter,
      AppNavbar,
    }
  }
</script>

<style>

</style>