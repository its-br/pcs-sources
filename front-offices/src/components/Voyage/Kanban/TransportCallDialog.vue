<template>
    <v-dialog v-model="show" width="500">
      <v-card min-width="272" max-width="300" class="mx-auto">
        <v-card-title class="grey lighten-4">
            <span class="ml-2">{{this.$t('VoyageKanban.TransportCall')}} </span>
        </v-card-title>
        <v-card-subtitle class="mt-1">
            <span class="font-weight-bold">{{this.$t('VoyageKanban.TransportCalls')}}</span>
        </v-card-subtitle>
        <v-card-text>
            <v-list-item two-line  class="px-1 mt-n5">
                <v-list-item-content>
                  <v-list-item-title class="body-2"></v-list-item-title>
                  <v-list-item-subtitle class="caption">{{this.$t('VoyageKanban.PortFacilityCNPJ')}}</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
            <v-list-item two-line  class="px-1 mt-n4">
                <v-list-item-content>
                  <v-list-item-title class="body-2"></v-list-item-title>
                  <v-list-item-subtitle class="caption">{{this.$t('VoyageKanban.MooringOperatorCNPJ')}}</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
            <v-list-item two-line  class="px-1 mt-n4">
                <v-list-item-content>
                  <v-list-item-title class="body-2"></v-list-item-title>
                  <v-list-item-subtitle class="caption">{{this.$t('VoyageKanban.TugboatCompanyCNPJ')}}</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-btn color="primary" flat @click.stop="show=false">{{this.$t('VoyageKanban.buttonClose')}}</v-btn>
        </v-card-actions>

      </v-card>
    </v-dialog>
</template>
<script>
  export default {
    name: 'TransportCallDialog',
    props: {
      /* Informações da viagem, retorno da api voyage/PCSVoyageID  */
      voyage: null,
      value: Boolean
    },
    created(){
      // this.parseVoyage()
    },
    beforeMount(){
      if (this.$store.state.profile == 'MaritimeAgent'){
        this.transportCallNumber = ' - ';
      }
    },
    computed: {
      show:{
        get () {
          return this.value
        },
        set (value) {
          this.$emit('input', value)
        }
      }
    },
    data (){
      return{
        vesselName: "EVERGREEN",
        vesselIMO: "1234567",
        UNLocationCode: "BR SSZ",
        UNLocationName: "Santos ",
        carrierVoyageNumber: "201S",
        carrierCode: "1234567",
        maritimeAgent: null,
        dialog: false
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
        if (this.voyage.cnpj ){
          this.maritimeAgent = this.voyage.cnpj.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, "$1.$2.$3/$4-$5");
        }
        if (this.voyage.transportCall && this.voyage.transportCall.length > 0) {
          this.transportCallCount = this.voyage.transportCall.length;
          this.transportCallNumber = 1;
        }
        if (this.voyage.cnpj ){
          this.maritimeAgent = this.voyage.cnpj.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, "$1.$2.$3/$4-$5");
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