<template>
  <div>
    <v-main>
      <v-container fluid class="my-10 pt-15">
        <v-layout align-center justify-center>
          <v-row class="px-15 mx-auto align-center justify-center" >
            <v-col cols="12" xm="12" sm="6" lg="4">
              <v-card class="pa-4" elevation="4" v-if="success">
                <v-card-title>{{$t('text.form.logoutSuccess')}}</v-card-title>
                <v-card-text>
                </v-card-text>  
                <v-card-subtitle>
                  {{$t('text.form.questions')}}
                </v-card-subtitle>
              </v-card>
              <v-card class="pa-4" elevation="4" v-else>
                <v-card-title>{{$t('text.form.logout')}}</v-card-title>
                <v-card-text>
                </v-card-text>  
                <v-card-actions class="d-flex justify-center">
                  <v-btn color="primary" block @click="logout()">{{$t('logout')}}</v-btn>
                </v-card-actions>
                <v-card-subtitle>
                  {{$t('text.form.questions')}}
                </v-card-subtitle>
              </v-card>
            </v-col>
          </v-row>
        </v-layout>
      </v-container>
    </v-main>
  </div>
</template>

<script>
  import axios from 'axios';
  import AppNavbar from '../components/AppNavbar.vue';
  export default {
    name: 'Logout',
    data () {
      return {
        appName: 'S-PCS',
        appFullName: 'Santos Port Community System',
        URL_CALLBACK_LOGOUT: process.env.VUE_APP_URL + 'logout/success',
        URL_LOGOUT: process.env.VUE_APP_LOGOUT_URL,
      }
    },
    components: {
        AppNavbar
    },
    beforeMount() {
      if (this.$route.path == '/logout/success'){
        this.success = true;
        this.$store.commit('clearAll');
        this.$router.push("/login");
      }else{
        this.success = false;
      }
    },
    methods:{
        logout() {
          var params = new URLSearchParams()
          params.append('id_token_hint', this.$store.state.idToken)
          params.append('post_logout_redirect_uri', this.URL_CALLBACK_LOGOUT)
          window.location = this.URL_LOGOUT + '?' + (params.toString()); 
        }
    }
  }
</script>
 <style scoped>


 </style>