<template>
  <div>
    <!--Situação da viagem/parada-->
    <v-card-title class="px-3 mt-0 pb-0 subtitle-2 text-uppercase">{{voyageStatus}}</v-card-title>
    <!--Informações gerais-->
     <div class="px-3 mt-1 d-flex">
      <!--Números de parada-->
      <v-alert outlined color="primary" v-show="showTransportCall" class="px-2 align-center my-auto">
        <div >
          <v-tooltip right class="ma-0 pa-0 ">
            <template v-slot:activator="{ on, attrs }">
              <div class="text-center " v-bind="attrs" v-on="on">
                <v-icon color="primary">mdi-ferry</v-icon>
                <div class="black--text body-2">{{transportCallCount}}</div>
              </div>
            </template>
            <span>{{this.$t('VoyageKanban.tipTotalTransportCalls')}}</span>
          </v-tooltip>
          <v-divider class="primary my-1"></v-divider>
          <v-tooltip right class="ma-0 pa-0 ">
            <template v-slot:activator="{ on, attrs }">
              <div class="text-center" v-bind="attrs" v-on="on">
                <v-icon color="primary">mdi-map-marker-radius</v-icon>
                <div class="black--text body-2">{{transportCallNumber}}</div>
              </div>
            </template>
            <span>{{this.$t('VoyageKanban.tipTransportCallNumber')}}</span>
          </v-tooltip>
        </div>
      </v-alert >
      <!--Corpo central do cartão-->
      <v-list class="py-0 mb-1 pl-2">
        <v-list-item class="px-1 info-item">
          <v-list-item-content class="">
            <v-list-item-title class="body-2">({{UNLocationCode}}) {{UNLocationName}}</v-list-item-title>
            <v-list-item-subtitle class="caption">{{this.$t('VoyageKanban.infoDestionation')}}</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
        <v-divider class="mx-5"></v-divider>
        <v-list-item class="px-1 info-item">
          <v-list-item-content class="">
            <v-list-item-title class="body-2">{{vesselName}} - {{carrierVoyageNumber}}</v-list-item-title>
            <v-list-item-subtitle class="caption ">{{this.$t('VoyageKanban.infoVesselVoyage')}}</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
        <v-divider class="mx-5"></v-divider>
        <v-list-item class="px-1 info-item">
          <v-list-item-content class="">
            <v-list-item-title class="body-2 mr-2 text-truncate">{{carrierCode}} / {{maritimeAgent}}</v-list-item-title>
            <v-list-item-subtitle class="caption">{{this.$t('VoyageKanban.infoCarrierMaritimeAgency')}}</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
        <v-divider class="mx-5"></v-divider>
        <v-list-item class="px-1 info-item">
          <v-list-item-content class="">
            <v-list-item-title class="body-2 mr-2 text-truncate">{{vesselIMO}} </v-list-item-title>
            <v-list-item-subtitle class="caption">{{this.$t('VoyageKanban.infoIMO')}}</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </div>
  </div>
</template>

<script>
import i18n from '@/plugins/i18n'
  export default {
    name: 'VoyageCardInfo',
    props: {
      voyage: null,
      showTransportCall: {type: Boolean, default: true},
      /* Status da viagem */
      voyageStatus: {type: String, default: i18n.t('VoyageKanban.defaultVoyageStatus') },
    },
    created(){
      this.parseVoyage()
    },
    beforeMount(){
      if (this.$store.state.profile == 'MaritimeAgent'){
        this.transportCallNumber = ' - ';
      }
    },
    data (){
      return{
        vesselName: "Não informado",
        vesselIMO: null,
        UNLocationCode: null,
        UNLocationName: "Santos",
        carrierVoyageNumber: null,
        carrierCode: null,
        transportCallCount: "1",
        transportCallNumber: "1",
        maritimeAgent: null
      }
    },
    methods:{
      parseVoyage(){
        if (this.voyage.carrierVoyageDetails ){
          if (this.voyage.carrierVoyageDetails.vesselIMO ){
            this.vesselIMO = this.voyage.carrierVoyageDetails.vesselIMO 
          }
          if (this.voyage.carrierVoyageDetails.UNLocationCode ){
            this.UNLocationCode = this.voyage.carrierVoyageDetails.UNLocationCode 
          }
          if (this.voyage.carrierVoyageDetails.carrierVoyageNumber ){
            this.carrierVoyageNumber = this.voyage.carrierVoyageDetails.carrierVoyageNumber 
          }
        }
        if (this.voyage.carrierDetails && this.voyage.carrierDetails.carrierCode ){
          this.carrierCode = this.voyage.carrierDetails.carrierCode;
        }
        if (this.voyage.vesselOperatorResponse && this.voyage.vesselOperatorResponse.voyageGeneralStatus && this.voyage.vesselOperatorResponse.voyageGeneralStatus.vesselName){
          this.vesselName = this.voyage.vesselOperatorResponse.voyageGeneralStatus.vesselName;
        }
        if (this.voyage.vesselOperatorResponse && this.voyage.vesselOperatorResponse.voyageGeneralStatus && this.voyage.vesselOperatorResponse.voyageGeneralStatus.UNLocationName){
          this.UNLocationName = this.voyage.vesselOperatorResponse.voyageGeneralStatus.UNLocationName;
        }
        if (this.voyage.maritimeAgencyCnpj ){
          this.maritimeAgent = this.voyage.maritimeAgencyCnpj.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, "$1.$2.$3/$4-$5");
        }
        if (this.voyage.transportCall && this.voyage.transportCall.length > 0) {
          this.transportCallCount = '' + this.voyage.transportCall.length;
          this.transportCallNumber = '1';
        }
      },
    },
    components: {
    },
  }
</script>

<style >
.info-item{
  min-height: 40px !important;
}
.info-item .v-list-item__content{
  padding-top: 0px;
  padding-bottom: 0px;
  margin-top: 0px;
  margin-bottom: 0px;
}

</style>