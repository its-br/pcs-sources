<template>
  <div>
    <v-card elevation="2" class="py-2 my-3">
      <v-row class="pa-3 pb-0"> 
        <!--Gráfico de eventos-->
        <v-item-group  >
          <v-icon v-for="(eventColor, index) in eventColors" :color="eventColor" class="pl-2" :size="iconSize"  :key="index">{{iconName}}</v-icon>
        </v-item-group>
        <v-spacer></v-spacer>
        <!--Botão de notificações da viagem-->
        <v-tooltip bottom>
          <template v-slot:activator="{ on, attrs }">
            <v-btn class="mx-2" fab dark x-small color="primary" v-bind="attrs" v-on="on" @click="showNotifications()">
              <v-icon dark>mdi-bell</v-icon>
              <v-badge color="blue lighten-5 black--text" :content="notificationCount"></v-badge>
            </v-btn>
          </template>
          <span>{{this.$t('VoyageKanban.Notifications')}}</span>
        </v-tooltip>
        <v-spacer></v-spacer>
        <!--Ícone para menu do card-->
        <v-tooltip bottom>
          <template v-slot:activator="{ on, attrs }">
            <v-btn dark icon v-bind="attrs" v-on="on">
          <v-icon color="grey" class="pr-4 ">mdi-dots-horizontal</v-icon>
            </v-btn>
          </template>
          <span>{{(this.voyage.PCSVoyageID)?'PCSVoyageID: '+this.voyage.PCSVoyageID:'receiptID: '+this.voyage.receiptID}} </span>
        </v-tooltip>
      </v-row>
      <!--Informações gerais-->
      <VoyageCardInfo :voyage="voyage" :voyageStatus="voyageStatus" />
      <!--Botões de informações específicas da viagem-->
      <v-layout v-if="cardType=='eventplanning'" class="px-3 mt-0 d-flex justify-space-around"> 
          <v-tooltip top class="ma-0 pa-0" v-for="(fabButtonItem, index) in fabButtonItems" :key="index">
            <template v-slot:activator="{ on, attrs }">
              <v-btn fab small outlined :color="fabButtonColor" :v-bind="attrs" v-on="on" @click="fabButtonItem.clickEvent" :to="fabButtonItem.link">
                <v-icon >{{fabButtonItem.icon}}</v-icon>
              </v-btn>
            </template>
            <span>{{fabButtonItem.tip}}</span>
          </v-tooltip>
      </v-layout>

      <!--Botões de nomeação-->
      <v-layout v-if="cardType=='responsability'" class="px-3 mt-0 d-flex "> 
          <v-tooltip top class="ma-0 pa-0"
            v-for="(fabButtonItem, index) in fabButtonResponsabilityItems" :key="index">
            <template v-slot:activator="{ on, attrs }">
              <v-btn :color="fabButtonItem.color" :v-bind="attrs" v-on="on" @click="fabButtonItem.clickEvent"
                fab dark small outlined class="mx-2">
                <v-icon dark>{{fabButtonItem.icon}}</v-icon>
              </v-btn>
            </template>
            <span>{{fabButtonItem.tip}}</span>
          </v-tooltip>
      </v-layout>
    </v-card>

    <!-- 
      Dialog do Aceite de Responsabilidade
    -->
    <v-dialog v-model="acceptDialog" width="500">
      <v-card>
        <v-card-title class="grey lighten-5">
          <v-icon>mdi-alarm</v-icon><span class="ml-3">{{this.$t('attention')}}</span>
        </v-card-title>
        <v-card-text>
          <h3 class="pa-5">{{this.$t('VoyageKanban.confirmAcceptance')}}</h3>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
           <v-btn color="primary" text @click="acceptDialog=false">{{this.$t('cancel')}}</v-btn>
          <v-btn color="success" text @click="confirmAcceptance">{{this.$t('VoyageKanban.buttonAccept')}}</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog> 

    <!-- 
      Refuse Dialog 
      -->
    <v-dialog v-model="refuseDialog" width="500">
      <v-card>
        <v-card-title class="grey lighten-5">
          <v-icon>mdi-alarm</v-icon><span class="ml-3">{{this.$t('attention')}}</span>
        </v-card-title>
        <v-card-text>
          <h3 class="pa-5">{{this.$t('VoyageKanban.confirmRefuse')}}</h3>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
           <v-btn color="primary" text @click="refuseDialog=false">{{this.$t('cancel')}}</v-btn>
          <v-btn color="success" text @click="refuseAcceptance">{{this.$t('refuse')}}</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog> 
    <!-- 
      Dialog de Notificações
    -->
    <v-dialog v-model="notificationDialog" width="500">
      <v-card>
        <v-card-title class="grey lighten-5">
          <v-icon>mdi-bell</v-icon><span class="ml-3">{{this.$t('VoyageKanban.Notifications')}}</span>
        </v-card-title>
        <v-virtual-scroll :bench="benched" :items="notificationList"  height="200" item-height="42">
        <template v-slot:default="{ item }">
          <v-list-item :key="item">
            <v-list-item-content>
              <v-list-item-title>
                <v-icon small>mdi-square-small</v-icon>
                {{ item.description }}
              </v-list-item-title>
            </v-list-item-content>
            <v-list-item-action>
            <router-link v-if="item.link != null" :to="item.link">
              <v-icon small >mdi-open-in-new</v-icon>
            </router-link>
            </v-list-item-action>
          </v-list-item>
          <v-divider></v-divider>
        </template>
      </v-virtual-scroll>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click="notificationDialog=false">{{this.$t('VoyageKanban.buttonClose')}}</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog> 

    <!-- 
      Not Work Dialog 
      -->
    <v-dialog v-model="notWorkDialog" width="500">
      <v-card>
        <v-card-title class="grey lighten-5">
          <span class="ml-3">{{notWorkTitle}}</span>
        </v-card-title>
        <v-card-text>
          <h3 class="pa-5">{{this.$t('VoyageKanban.NoInformation')}}</h3>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click="notWorkDialog=false">{{this.$t('VoyageKanban.buttonClose')}}</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog> 
    <!-- 
      Transport Call Dialog 
      -->
    <v-dialog v-model="transportCallDialog" width="500">
      <v-card class="mx-auto">
        <v-card-title class="grey lighten-4">
            <span class="ml-2">{{this.$t('VoyageKanban.TransportCalls')}} </span>
        </v-card-title>
        <v-card-text>
          <v-list >
            <v-list-item   class="px-1 ">
              <v-list-item-content>
                <v-list-item-title class="body-2">{{transportCall.transportCallID}}</v-list-item-title>
                <v-list-item-subtitle class="caption">{{this.$t('VoyageKanban.TransportCallID')}}</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
            <v-divider class="mx-5"></v-divider>
            <v-list-item   class="px-1 ">
              <v-list-item-content>
                <v-list-item-title class="body-2">{{transportCall.portFacilityTypeDcsaCode}}</v-list-item-title>
                <v-list-item-subtitle class="caption">{{this.$t('VoyageKanban.DCSACodeforPortFacilities')}}</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
            <v-divider class="mx-5"></v-divider>
            <v-list-item   class="px-1 ">
              <v-list-item-content>
                <v-list-item-title class="body-2">{{transportCall.portFacilityCnpj}}</v-list-item-title>
                <v-list-item-subtitle class="caption">{{this.$t('VoyageKanban.PortFacilityCNPJ')}}</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
            <v-divider class="mx-5"></v-divider>
            <v-list-item   class="px-1 ">
              <v-list-item-content>
                <v-list-item-title class="body-2">{{transportCall.mooringOperatorCnpj}}</v-list-item-title>
                <v-list-item-subtitle class="caption">{{this.$t('VoyageKanban.MooringOperatorCNPJ')}}</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
            <v-divider class="mx-5"></v-divider>
            <v-list-item   class="px-1 ">
              <v-list-item-content>
                <v-list-item-title class="body-2">{{transportCall.tugboatCompanyCnpj}}</v-list-item-title>
                <v-list-item-subtitle class="caption">{{this.$t('VoyageKanban.TugboatCompanyCNPJ')}}</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click="transportCallDialog=false">{{this.$t('VoyageKanban.buttonClose')}}</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <!-- 
      Maritime Agency Dialog 
      -->
    <v-dialog v-model="maritimeAgencyDialog" width="500">
      <v-card class="mx-auto">
        <v-card-title class="grey lighten-4">
            <span class="ml-2">{{this.$t('VoyageKanban.MaritimeAgencies')}}</span>
        </v-card-title>
        <v-card-text>
          <v-list >
            <v-list-item   class="px-1 ">
              <v-list-item-content>
                <v-list-item-title class="body-2">{{maritimeAgent}}</v-list-item-title>
                <v-list-item-subtitle class="caption">{{this.$t('VoyageKanban.MainMaritimeAgency')}}</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
            <v-divider class="mx-5"></v-divider>
            <v-list-item   class="px-1 ">
              <v-list-item-content>
                <v-list-item-title class="body-2">{{otherMaritimeAgency.maritimeAgencyCnpj}}</v-list-item-title>
                <v-list-item-subtitle class="caption">{{this.$t('VoyageKanban.SecondaryMaritimeAgencyCNPJ')}}</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
            <v-divider class="mx-5"></v-divider>
            <v-list-item   class="px-1 ">
              <v-list-item-content>
                <v-list-item-title class="body-2">{{otherMaritimeAgency.responsabilityCode}}</v-list-item-title>
                <v-list-item-subtitle class="caption">{{this.$t('VoyageKanban.ResponsabilityCode')}}</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click="maritimeAgencyDialog=false">{{this.$t('VoyageKanban.buttonClose')}}</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import VoyageCardInfo from '@/components/Voyage/Kanban/VoyageCardInfo';
import TransportCallDialog from './TransportCallDialog.vue';
import i18n from '@/plugins/i18n'
  export default {
    name: 'VoyageCard',
    props: {
      voyage: null,
      transportCallID: null,
      /* Tipo do cartão (responsability ou eventplanning)*/
      cardType: {type: String, default:"responsability"},
      /*Total de notificações*/
      notificationCount: {type: String, default:"0"},
      notificationList: {type: Array, default: () => {return [{description: "Nenhuma notificação" ,link: null}]}}, 
      /* Cores para cada evento da parada */
      eventColors:{type:Array, default:["grey", "grey", "grey", "grey", "grey"]} ,
      /* status da parada conforme posição no Kanban */
      voyageStatus:{type: String, default: i18n.t('VoyageKanban.NominationStatus')} ,
    },
    created(){
      this.parseVoyage()
    },
    data (){
      return{
        /* Status da viagem */ 
        iconSize: 20,
        acceptDialog: null,
        refuseDialog: null,
        notificationDialog: null,
        transportCallDialog: null,
        maritimeAgencyDialog: null,
        notWorkDialog: null,
        notWorkTitle: null,
        location: "BR SSZ",
        iconName: "mdi-map-marker-circle",
        /* Notifications */
        benched:0,
        /*Botões de informações específicas da viagem*/ 
        fabButtonColor: "blue",
        fabButtonItems: [
          {icon: "mdi-anchor", tip:this.$t('VoyageKanban.tipTransportCalls'), clickEvent: this.showTransportCalls, link:""},
          {icon: "mdi-domain", tip:this.$t('VoyageKanban.tipAgencies'), clickEvent: this.showMaritimeAgency, link:""},
          {icon: "mdi-dolly", tip:this.$t('VoyageKanban.tipCargo'), clickEvent: this.showCargo, link:""},
          {icon: "mdi-account-group", tip:this.$t('VoyageKanban.tipCrewList'), clickEvent: this.showCrewlist, link:""},
          {icon: "mdi-grain", tip:this.$t('VoyageKanban.tipSupplies'), clickEvent: this.showMaterials, link:""},
          {icon: "mdi-calendar-clock", tip:this.$t('VoyageKanban.tipEvents'), clickEvent: this.showEventPlanning, link: ""},
        ],
        /*Botões de nomeação (aceitar/rejeitar)*/
        fabButtonResponsabilityItems: [
          {icon:"mdi-check",tip:this.$t('VoyageKanban.tipAccept'), color:"green", clickEvent: this.showAcceptanceDialog, link:"/"},  
          {icon:"mdi-close",tip:this.$t('VoyageKanban.tipReject'), color:"red", clickEvent: this.showRefuseDialog, link:"/"},
        ],
        transportCall: {
          transportCallID: "não informado",
          portFacilityTypeDcsaCode: "não informado",
          portFacilityCnpj: "não informado",
          mooringOperatorCnpj: "não informado",
          tugboatCompanyCnpj: "não informado"
        },
        maritimeAgent: "não informado",
        otherMaritimeAgency: {
          maritimeAgencyCnpj: "não informado",
          responsabilityCode: "não informado"
        }
      }
    },
    methods:{
        /* Métodos para eventos do componente */
        showNotifications() {
          this.notificationDialog = true;
        },
        showNotWorkDialog(title) {
          this.notWorkTitle = this.$t(title);
          this.notWorkDialog = true;
        },
        showTransportCalls() {
          this.voyage.transportCall.forEach(tpCall => {
            if (tpCall.transportCallID == this.transportCallID){
              this.transportCall = tpCall;
            }
          })
          this.transportCallDialog = true;
        },
        showMaritimeAgency() {
          this.voyage.otherMaritimeAgency.forEach(agency => {
            this.otherMaritimeAgency.maritimeAgencyCnpj = agency.maritimeAgencyCnpj.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, "$1.$2.$3/$4-$5");
            this.otherMaritimeAgency.responsabilityCode = agency.responsabilityCode;
          })
          this.maritimeAgencyDialog = true;
        },
        showEventPlanning() {
          var voyageID = this.voyage.PCSVoyageID ? this.voyage.PCSVoyageID : this.voyage.receiptID;
          this.$router.push({path: `/EventPlanning/${voyageID}/${this.transportCallID}`})
        },
        showAcceptanceDialog() {
          this.acceptDialog = true;
        },
        showRefuseDialog() {
          this.refuseDialog = true;
        },
        showCargo() {
          this.showNotWorkDialog('cargo')
        },
        showCrewlist() {
          this.showNotWorkDialog('crewList')
        },
        showMaterials() {
          this.showNotWorkDialog('materials')
        },
        parseVoyage(){
          if (this.voyage.maritimeAgencyCnpj ){
            this.maritimeAgent = this.voyage.maritimeAgencyCnpj.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, "$1.$2.$3/$4-$5");
          }
        },
        /**
         * Emite o evento quando o usuário clica no botão de confirmar aceite.
         */
        confirmAcceptance(){
          this.acceptDialog = false;
          var requestData = {
            transportCallID: this.transportCallID,
            cnpj: this.$store.state.cnpj,
            statusCode: "T002",
            acceptance: "Accepted"
          }
          if (this.voyage.PCSVoyageID) {
            Object.assign(requestData, {PCSVoyageID: this.voyage.PCSVoyageID})
          }else{
            Object.assign(requestData, {receiptID: this.voyage.receiptID});
          }
          this.$emit("postAcceptance", requestData)
        },
        /**
         * Emite o evento quando o usuário clica no botão de rejeitar aceite.
         */
        refuseAcceptance(){
          this.refuseDialog = false;
          var requestData = {
            transportCallID: this.transportCallID,
            cnpj: this.$store.state.cnpj,
            statusCode: "T001",
            acceptance: "Refused"
          }
          if (this.voyage.PCSVoyageID) {
            Object.assign(requestData, {PCSVoyageID: this.voyage.PCSVoyageID})
          }else{
            Object.assign(requestData, {receiptID: this.voyage.receiptID});
          }
          this.$emit("postAcceptance", requestData)
        },
    },
    components: {
      VoyageCardInfo,
      TransportCallDialog
    },
    
  }
</script>

<style >
div.v-item-group.theme--light.v-slide-group.v-tabs-bar.primary--text 
div.v-item-group.theme--dark.v-slide-group.v-tabs-bar.primary--text {
  height: 35px;
}

</style>