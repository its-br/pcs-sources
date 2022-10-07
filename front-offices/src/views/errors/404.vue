<template>
  <div>
    <AppNavbar drawericon/>
    <v-main>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <div class="text-md-center">
            <h1>404</h1>
            <h2>{{$t('errors404.page_not_found')}}</h2>
            <div class="mt-8">
              <v-btn color="primary" to="/">{{$t('errors404.go_home')}}</v-btn>
            </div>
          </div>
        </v-layout>
      </v-container>
    </v-main>
  </div>
</template>

<script>
import AppNavbar from '../../components/AppNavbar.vue'
  export default {
    components:{
      AppNavbar
    }
  }
</script>
<style scoped>
h1{
  font-size: 150px;
  line-height: 150px;
  font-weight: 700;
  }
</style>
