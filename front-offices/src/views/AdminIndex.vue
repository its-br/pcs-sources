<template>
  <div>
    <AppDrawer :app-name="appFullName" :drawer="drawer" v-on:emitDrawer="drawer=$event"/>

    <AppNavbar :app-name="appFullName" drawericon v-on:change-drawer="drawer=$event" />
    <v-main class="bgmain">
      <div fluid class="min-height justify-center overflow-auto">
        <router-view/>
      </div>
      <AppFooter />
    </v-main>
  </div>
</template>

<script>
import AppNavbar from "@/components/AppNavbar";
import AppDrawer from "@/components/AppDrawer";
import AppFooter from "@/components/AppFooter";

export default {
  name: 'AdminIndex',
  data: () => ({
    appName: 'S-PCS',
    appFullName: 'Santos Port Community System',
    drawer: null
  }),
  components:{
    AppNavbar,
    AppDrawer,
    AppFooter
  }
};
</script>
<style scoped>
.min-height{
  min-height: calc(100vh - 200px);
}
</style>