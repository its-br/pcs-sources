<template>
  <footer class="footer" >
    <p>Santos Port Community System &copy; 2022 - {{$t('version')}} <span>{{version}}</span> </p>
  </footer>
</template>

<script>
export default {
    name:"AppFooter",
    data(){
      return {
        version: process.env.VUE_APP_FO_VERSION
      }
    }
}
</script>

<style scoped>
.footer{
  height: 150px;
  display: flex;
  border-top: 2px solid var(--v-bgfooter-darken2);
  align-items: center;
  margin-bottom: 0px;
  justify-content: center;
  background-color: var(--v-bgfooter-base);
}
</style>