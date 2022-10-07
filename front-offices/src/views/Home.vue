<template>
  <div>
    <AppNavbar />
    <div class="bgmain">
      <v-main fluid class="mb-10 mt-10">
        <v-layout align-center justify-center>
            <v-col cols="12" sm="12" lg="10">
              <v-row>
                <v-col v-for="(card, index) in cards" :key="index" :cols="cols" :sm="sm" :lg="lg">
                  <v-card light :to="card.view">
                      <v-card-title>
                        <v-icon left>{{card.icon}} </v-icon>
                        <span class="title ">{{card.name}}</span>
                      </v-card-title>
                      <v-card-text>
                        {{card.desc}}
                      </v-card-text>
                  </v-card>
                </v-col>
              </v-row>
            </v-col>
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
    name: 'Home',
    data (){
      return{
        cards:[
          {view: "MaritimeAgent", icon: "mdi-ferry", name:  this.$t("maritimeAgent"), desc: this.$t("text.maritimeAgentInfo")},
          {view: "MooringOperators", icon: "mdi-anchor", name: this.$t("mooringOperators"), desc: this.$t("text.mooringOperatorsInfo")},
          {view: "Tugboat", icon: "mdi-ship-wheel", name: this.$t("tugboat"), desc: this.$t("text.tugboarInfo")},
          {view: "PortFacilities", icon: "mdi-pier-crane", name: this.$t("portFacilities"), desc: this.$t("text.portFacilitiesInfo")},
          {view: "UserAgent", icon: "mdi-card-account-details", name: this.$t("userAgent"), desc: this.$t("text.userAgentInfo")},
          {view: "ShipSupplier", icon: "mdi-truck", name: this.$t("shipSupplier"), desc: this.$t("text.shipSuplierInfo")},
        ],
        cols: 12,
        sm: 6,
        lg: 4
      }
    },
    components: {
      AppFooter,
      AppNavbar,

    }
  }
</script>
 <style scoped>
   
 </style>