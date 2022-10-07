<template>
  <v-layout align-center justify-center>
    <v-col cols="12" sm="10" lg="8">
      <v-card light>
        <v-card-title class="text-h5">{{title}}</v-card-title>
        <v-card-subtitle class="text-h5">{{subtitle}}</v-card-subtitle>
        <v-list two-line class="pa-0">
          <v-list-item>
            <v-list-item-action>
              <v-icon>mdi-account</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>{{fullName}}</v-list-item-title>
              <v-list-item-subtitle>{{$t('name')}}</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
          <v-divider inset></v-divider>
          <v-list-item >
            <v-list-item-action>
              <v-icon>mdi-card-account-details-outline</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>{{cnpj}}</v-list-item-title>
              <v-list-item-subtitle>{{$t('cnpj')}}</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
          <v-divider inset></v-divider>
          <v-list-item >
            <v-list-item-action>
              <v-icon>mdi-card-account-details-outline</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>{{profile}}</v-list-item-title>
              <v-list-item-subtitle>{{$t('userType')}}</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
          <v-divider inset v-show="phone"></v-divider>
          <v-list-item v-show="phone">
            <v-list-item-action>
              <v-icon>mdi-phone</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>{{phone}}</v-list-item-title>
              <v-list-item-subtitle>{{$t('phone')}}
              </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
          <v-divider inset></v-divider>
          <v-list-item>
            <v-list-item-action>
              <v-icon>mdi-email-outline</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>{{email}}</v-list-item-title>
              <v-list-item-subtitle>{{$t('mail')}}
              </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
          <v-divider inset></v-divider>
          <v-list-item>
            <v-list-item-content>
              <v-row class="justify-center">
                <v-btn class="ma-2 error">{{$t('text.form.dataDeletion')}}
                </v-btn>
              </v-row>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-card>
    </v-col>
  </v-layout>
</template>

<script>
import {parseJwt} from '../helpers/utils'
export default {
    data : () => {
      return{
        title: null,
        subtitle: null,
        cnpj: null ,
        fullName: null ,
        profile: null ,
        phone: null ,
        email: null 
      }
    },
    mounted(){
      let openIDProfile = parseJwt(this.$store.state.idToken);
      this.fullName = openIDProfile.name;
      this.profile = openIDProfile.profile;
      this.email = openIDProfile.email;
      this.cnpj = openIDProfile.cnpj.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, "$1.$2.$3/$4-$5");
      this.phone = openIDProfile.phone;
      this.title = this.$t(this.profile);
      this.title = this.$t(this.profile.charAt(0).toLowerCase() + this.profile.slice(1));
      this.subtitle = this.$t("informations");
    },
    components: {
    },
    methods: {
    }
  }
</script>

<style >

</style>