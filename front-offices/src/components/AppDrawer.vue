<template>
  <v-navigation-drawer temporary app v-model="drawerFlag" class="">
    <!-- <v-navigation-drawer :mini-variant.sync="drawer" app permanent class="bgdrawer"> -->
    <v-toolbar color="primary" dark fixed prominent flat class="">
      <v-list class="ma-0 pa-0">
        <v-list-item class="justify-center pb-1">
          <v-img class="shrink mr-0" alt="Vuetify Logo" width="38" contain transition="scale-transition" src="@/assets/lighthouse.png"/>
            <span class="font-weight-black opacity-70" style="font-family: Noto Sans;">S-PCS</span>
        </v-list-item>
        <v-list-item>
          <v-list-item-title class="text-h6 text-wrap" >{{appName}} </v-list-item-title>
        </v-list-item>
        <v-list-item>
        </v-list-item>
      </v-list>
    </v-toolbar>
    <v-list>
      <v-list-item to="/">
        <v-list-item-icon>
          <v-icon>mdi-home</v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title class="body-2">Home</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      <v-divider></v-divider>
      <v-list-group no-action v-show="showVoyage">
        <template v-slot:activator >
          <v-list-item-icon>
            <v-icon class="item-color">mdi-ferry</v-icon>
          </v-list-item-icon>
          <v-list-item-content >
            <v-list-item-title class="body-2" style="">{{$t('voyage')}}
            </v-list-item-title>
          </v-list-item-content>
        </template>
        <v-list-item @click="goto_VoyageCreation">
        <!--<v-list-item to="/Voyage/Creation" > -->
          <v-list-item-content>
            <v-list-item-title class="body-2">{{$t('createVoyage')}}
            </v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <!-- <v-list-item to="/Voyage/Find" >
          <v-list-item-content>
            <v-list-item-title class="body-2">{{$t('findVoyage')}}
            </v-list-item-title>
          </v-list-item-content>
        </v-list-item> -->
        <v-list-item to="/Voyage/Edit" >
          <v-list-item-content>
            <v-list-item-title class="body-2">{{$t('editVoyage')}}
            </v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item to="/Voyage/Delete">
          <v-list-item-content>
            <v-list-item-title class="body-2">{{$t('cancelVoyage')}}
            </v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list-group>
      <v-divider></v-divider>
      <v-list-group no-action v-show="showNomination">
        <template v-slot:activator >
          <v-list-item-icon>
            <v-icon class="item-color">mdi-flag</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="body-2" style="">{{$t('nomination')}}
            </v-list-item-title>
          </v-list-item-content>
        </template>
        <v-list-item >
          <v-list-item-content>
            <v-list-item-title class="body-2">{{$t('noNomination')}}
            </v-list-item-title>
          </v-list-item-content>
          <v-list-item-icon>
            <v-icon>mdi-mdi-hand-pointing</v-icon>
          </v-list-item-icon>
        </v-list-item>
      </v-list-group>
      <!-- Fixed item -->
      <v-list-group >
        <template v-slot:activator style="">
          <v-list-item-icon><v-icon>mdi-cog</v-icon></v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="body-2">{{$t('settings')}}</v-list-item-title>
          </v-list-item-content>
        </template>
        <v-list-group
          :value="true"
          no-action
          sub-group
        >
          <template v-slot:activator>
            <v-list-item-content>
              <v-list-item-title class="body-2">{{$t('localeLanguage')}}</v-list-item-title>
            </v-list-item-content>
          </template>
          <v-list-item @click="change_language('en')">
            <v-list-item-icon>
              <v-icon small>{{en_icon}}</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title class="caption">{{this.$t('localeEnglish')}}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
          <v-list-item @click="change_language('pt')">
            <v-list-item-icon>
              <v-icon small>{{pt_icon}}</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
              <v-list-item-title class="caption">{{this.$t('localePortuguese')}}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-group>
        <v-list-item >
          <v-list-item-content >
            <v-switch class="pl-3" dense v-model="$vuetify.theme.dark" inset persistent-hint>
            <template v-slot:label>
              <span class="v-label-switch">{{$t('themeDark')}}</span>
            </template>
            </v-switch>
          </v-list-item-content>
        </v-list-item>
      </v-list-group>
    </v-list>
  </v-navigation-drawer>
</template>

<script>

export default {
  name: "AppDrawer",
  data (){
    return{
      items:[
        // {view: "/MaritimeAgent", name:  "Maritime Agent", icon: "mdi-ferry"},
        // {view: "/MooringOperators", name: "Mooring Operators", icon: "mdi-anchor"},
        // {view: "/Tugboat", name: "Tugboat", icon: "mdi-ship-wheel"},
        // {view: "/PortFacilities", name: "Port Facilities", icon: "mdi-pier-crane"},
        // {view: "/UserAgent", name: "User Agent", icon: "mdi-card-account-details"},
        // {view: "/ShipSupplier", name: "Ship Supplier", icon: "mdi-truck"},
      ],
      cols: 12,
      sm: 6,
      lg: 4,
      showVoyage: false,
      showNomination: true,
      // drawer: null
      en_icon: "mdi-minus",
      pt_icon: "mdi-minus",
    }
  },
  props:{
    appName: String, 
    drawer: Boolean
  },
  beforeMount() {
    if (this.$store.state.profile == 'MaritimeAgent'){
      this.showVoyage = true
    }
    if (this.$store.state.profile == 'HarborPilot'){
      this.showNomination = false
    }
  },
  mounted(){
    this.update_language_icons()
  },
  computed:{
    drawerFlag:{
      get: function() {
        return this.drawer
      },
      set: function(drawer) {
        this.$emit('emitDrawer', drawer)
      }
    }
  },
  methods:{
    goto_VoyageCreation(){
       this.$store.state.step1 = null
       this.$store.state.step2 = new Array()
       this.$store.state.step3 = new Array()
       this.$router.push('/Voyage/Creation')
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

</style>
<style>
.v-list-item__icon.v-list-group__header__append-icon{
  min-width:24px!important;
}
.v-label-switch{
  color: grey;
  font-weight: normal;
  font-size: 12px;
}
</style>