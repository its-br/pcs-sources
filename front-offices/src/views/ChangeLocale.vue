<template>
 <div>
    <AppNavbar />
    <div class="bgmain">
      <v-main fluid class="mb-10 mt-10">
        <v-layout align-center justify-center>
            
        </v-layout>
      </v-main>
      <AppFooter />
    </div>
  </div>    
</template>
<script>
import AppFooter from '@/components/AppFooter.vue'
import AppNavbar from '@/components/AppNavbar.vue'


export default {
    name:"ChangeLocale",
    components: {
      AppFooter,
      AppNavbar,

    },
    mounted(){
        this.goBackHome()
    },
    
    data(){
      return {
        
      }
    },
    methods:{
        goBackHome(){
            this.$router.push('/')
        }
    }
}
</script>
