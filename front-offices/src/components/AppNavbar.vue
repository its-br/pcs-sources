<template>
  <v-app-bar app color="primary" dark>
    <v-app-bar-nav-icon v-show="drawericon" @click="$emit('change-drawer', !drawer)"></v-app-bar-nav-icon>
    <div class="d-flex align-center">
      <v-img class="shrink mr-0" alt="Vuetify Logo" width="38" contain transition="scale-transition"
        src="@/assets/lighthouse.png"/>
        <!-- <strong>S-PCS</strong> -->
        <span class="font-weight-black opacity-70" style="font-family: Noto Sans;">S-PCS</span>
      <v-toolbar-title class="ml-5"> {{this.$store.state.frontOfficeName}}</v-toolbar-title>
    </div>
    <v-spacer></v-spacer>
    <!--Menu Languages (locale)-->
    <v-menu offset-y>
      <template v-slot:activator="{ on, attrs }">
        <v-btn text v-bind="attrs" v-on="on" v-show="drawericon">
          <v-icon>mdi-earth</v-icon>
        </v-btn>
      </template>
      <v-list>
        <v-list-item @click="change_language('en')">
          <v-list-item-icon>
            <v-icon>{{en_icon}}</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="body-2">{{this.$t('localeEnglish')}}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
      <v-list>
        <v-list-item @click="change_language('pt')">
          <v-list-item-icon>
            <v-icon>{{pt_icon}}</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="body-2">{{this.$t('localePortuguese')}}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-menu>
    <!--Menu Account/logout-->
    <v-menu offset-y>
      <template v-slot:activator="{ on, attrs }">
        <v-btn text v-bind="attrs" v-on="on" v-show="drawericon">
          <v-icon>mdi-account</v-icon>
        </v-btn>
      </template>
      <v-list class="account-title">
        <v-list-item>
          <v-list-item-content >
            <v-img contain class="mb-5 opacity-50" height="96" src="@/assets/user.png" />
            <v-list-item-title>{{this.$store.state.razaoSocial}} </v-list-item-title>
            <v-list-item-subtitle>{{cnpj}}</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
        <v-list-item @click="infoUser">
          <v-list-item-icon>
            <v-icon>mdi-account-details</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="body-2">{{$t('informations')}}
            </v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item to="/AddUserAgent" v-if="actor !== 'UserAgent'">
          <v-list-item-icon>
            <v-icon>mdi-plus</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="body-2">{{$t('addUserAgent')}}
            </v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item to="/logout">
          <v-list-item-icon>
            <v-icon>mdi-logout-variant</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="body-2">{{$t('logout')}}
            </v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-menu>
  </v-app-bar>
</template>

<script>
export default {
  name: "AppNavbar",
  data: () => ({
    appName: 'Santos Port Community System',
    actor: 'Tugboat',
    cnpj: null,
    drawer: null,
    en_icon: "mdi-minus",
    pt_icon: "mdi-minus",
  }),
  components:{
  },
  props:{
    drawericon: Boolean,
  },
  beforeMount(){
    this.cnpj = this.$store.state.cnpj;
    var FOName = {
      'MaritimeAgentSecondary' : this.$t('maritimeAgentSecondary'), 
      'MooringOperators' : this.$t('mooringOperators'),
      'PortFacilities' : this.$t('portFacilities'),
      'MaritimeAgent' : this.$t('maritimeAgency'), 
      'PortAuthority' : this.$t('portAuthority'),
      'ShipSupplier' : this.$t('shipSupplier'),
      'HarborPilot' : this.$t('harborPilot'),
      'UserAgent' : this.$t('userAgent'),
      'Tugboat' : this.$t('tugboat'),
    };
    this.$store.state.frontOfficeName = this.appName
    if (FOName[this.$store.state.profile] !== undefined){
      this.$store.state.frontOfficeName = FOName[this.$store.state.profile];
    }
    if (this.cnpj && this.cnpj.length == 14){
      this.cnpj = this.cnpj.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, "$1.$2.$3/$4-$5");
    }
   
  },
  mounted(){
    this.update_language_icons()
  },
  methods:{
    infoUser(){
      if (typeof this.$store.state.profile !== 'undefined' ){
        this.$router.push("/UserInfo");
      }
    },
    change_language(lang){
        //this.$i18n.locale = 'pt'
        this.$root.$i18n.locale = lang
        this.update_language_icons()
        this.$router.push('/locale')
    },
    update_language_icons(){
      if (this.$root.$i18n.locale==='en')
      {
        this.en_icon = 'mdi-check'
        this.pt_icon = 'mdi-minus'
      }else{
        this.en_icon = 'mdi-minus'
        this.pt_icon = 'mdi-check'
      }
    },
  }
}
</script>

<style scoped>
  .account-title{
    max-width: 256px;
  }
</style>