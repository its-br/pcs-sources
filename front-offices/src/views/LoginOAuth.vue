<template>
  <div>
    <AppNavbar />
    <v-main>
      <v-container v-if="callback" class="d-flex align-center justify-center py-16 my-16" >
        <v-card flat >
          <v-alert v-if="OAuthError" type="error" outlined><span>{{OAuthResponse}}</span><br><span class="caption font-italic">{{OAuthResponseSubtitle}}</span></v-alert>
          <v-card-actions class="d-flex align-center justify-center">
            <v-btn color="primary" @click="callback = false" to="/">{{$t('return')}}</v-btn>
          </v-card-actions>
        </v-card>
      </v-container>
      <v-container v-else fluid class="my-10 pt-15">
        <v-layout align-center justify-center>
          <v-row class="px-15 mx-auto align-center justify-center" >
            <v-col cols="12" xm="12" sm="6" lg="4" >
              <v-layout class="pa-15" column align-center justify-center>
                <v-img contain height="150" src="@/assets/lighthouse.png" />
                <h4>{{this.env.VUE_APP_FULL_NAME}} </h4>
              </v-layout>
            </v-col>
            <v-col cols="12" xm="12" sm="6" lg="4">
              <v-card class="pa-4" elevation="4">
                <v-card-title>{{$t('text.form.signin')}}</v-card-title>
                <v-card-actions class="d-flex justify-center">
                  <v-btn color="primary" block @click="login()">{{$t('authenticate')}}</v-btn>
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
    <AppFooter />
  </div>
</template>

<script>
  import axios from 'axios';
  import Vue from 'vue';
  import VueMask from 'v-mask';
  import {randomCodeVerifier, getCodeChallenge, parseJwt, genPcsJwt} from '../helpers/utils'

  Vue.use(VueMask);

  import AppNavbar from '../components/AppNavbar.vue';
  import AppFooter from '../components/AppFooter.vue';
  export default {
    name: 'Login',
    data () {
      return {
        env: process.env,
        OAuthError: true,
        OAuthResponse: 'Autenticando...',
        OAuthResponseSubtitle: '',
        callback: false,
        CLIENT_ID: process.env.VUE_APP_CLIENT_ID,
        URL_CALLBACK: process.env.VUE_APP_URL + 'callback',
        URL_TOKEN: process.env.VUE_APP_TOKEN_URL,
        URL_AUTHORIZE: process.env.VUE_APP_AUTHORIZE_URL
      }
    },
    components: {
        AppNavbar,
        AppFooter
    },
    beforeMount() {
      this.codeVerifier = randomCodeVerifier();
      getCodeChallenge(this.codeVerifier)
      .then((code) => {
        this.codeChallenge = code;
      });
      if (this.$route.path == '/callback'){
        this.callback = true;
        this.getAccessToken(this.URL_CALLBACK, this.$route.query.code);
      }else{
        this.callback = false;
      }
    },
    methods:{
        getAccessToken(redirect_uri, code) {
          const params = new URLSearchParams()
          params.append('grant_type', 'authorization_code')
          params.append('redirect_uri', redirect_uri)
          params.append('code', code)
          params.append('client_id', this.CLIENT_ID)
          // params.append('code_verifier', this.codeVerifier)
          // params.append('client_secret', 'VIFxYfgJOEfGv_BkWI5cAwrFNdAa')
          delete axios.defaults.headers.common['PCSAuthorization']
          axios.post(this.URL_TOKEN, params)
          .then(response => {
            if (response.status == 200) {
              this.OAuthError = false
              this.$store.commit('setIDToken', response.data.id_token)
              this.$store.commit('setAccessToken', response.data.access_token)
              this.$store.commit('setRefreshToken', response.data.refresh_token)
              this.parseIDToken(response.data.id_token)
              this.setAxiosDefaultHeaders()
              this.$router.push("/");
            }else{
              this.OAuthError = true
              this.OAuthResponse = 'Erro na Autenticação do usuário!'
            }
          }).catch(error => {
            this.OAuthError = true
            this.OAuthResponse = 'Erro na Autenticação do usuário!'
            if (error.response && error.response.data && error.response.data.error_description){
              this.OAuthResponseSubtitle = error.response.data.error_description
            }
            console.error(error);
          }
          );
        },
        login() {
            this.loginOAuth();
        },
        loginOAuth() {
          var params = new URLSearchParams();
          params.append('response_type', 'code')
          params.append('client_id', this.CLIENT_ID)
          params.append('scope', 'openid')
          params.append('redirect_uri', this.URL_CALLBACK)
          // params.append('code_challenge', this.codeChallenge)
          // params.append('code_challenge_method', 'S256')
          
          window.location = this.URL_AUTHORIZE + '?' + (params.toString());
        },
        parseIDToken(idToken) {
          let openIDProfile = parseJwt(idToken)
          this.$store.commit('setRazaoSocial', openIDProfile.name)
          this.$store.commit('setCnpj', openIDProfile.sub)
          this.$store.commit('setProfile', openIDProfile.profile)
          let jwt = genPcsJwt(openIDProfile.sub)
          this.$store.commit('setPCSAuthorization', jwt)
        },
        setAxiosDefaultHeaders(){
          if ( this.$store.state.accessToken != null )
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.$store.state.accessToken
          if ( this.$store.state.PCSAuthorization != null )
            axios.defaults.headers.common['PCSAuthorization'] = this.$store.state.PCSAuthorization
          axios.defaults.headers.common['Accept'] = 'application/json'
        },
    }
  }
</script>
 <style scoped>


 </style>