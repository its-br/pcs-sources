<template>
    <div>
    <v-card class="mx-auto" max-width="300" min-height="375">
        <v-card-title class="grey lighten-5">
          <v-icon>mdi-ferry</v-icon>
          <span class="ml-3">VIAGEM # {{voyage_number}}</span>
        </v-card-title>
        <v-card-subtitle>
          <span class="">PCSVoyageID: {{PCSVoyageID}}</span>
        </v-card-subtitle>
        <v-divider></v-divider>
        <VoyageCardInfo :voyage="voyage" :showTransportCall="false" :voyageStatus="voyage_status"/>
        <v-divider></v-divider>
         <v-list class="py-0 ml-3 mb-1 pl-2">
        <v-list-item class="px-1 info-item">
          <v-list-item-content class="">
            <v-list-item-title class="body-2 mr-2 text-truncate">{{responsability_code}}</v-list-item-title>
            <v-list-item-subtitle class="caption">Código da Responsabilidade</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
         </v-list>
         <v-divider></v-divider>
         <v-card-actions v-show="show_actions" >
          <v-spacer></v-spacer>
          <v-btn  color="success" text @click="showConfirmDialogAccept">Aceitar</v-btn>
          <v-btn  color="red" text @click="showConfirmDialogRefuse">Recusar</v-btn>
        </v-card-actions>
    </v-card>
    <!-- 
      Dialog do Aceite de Responsabilidade
    -->
    <v-dialog v-model="dialog" width="500">
      <v-card>
        <v-card-title class="grey lighten-5">
          <v-icon>mdi-help-circle</v-icon><span class="ml-3">{{dialog_title}}</span>
        </v-card-title>
        <v-card-text>
          <h3 class="pa-5">{{dialog_message}}</h3>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
           <v-btn color="primary" text @click="dialog=false">Cancelar</v-btn>
          <v-btn color="success" text @click="confirm">Confirmar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog> 
  </div>
</template>

<script>
import VoyageCardInfo from '@/components/Voyage/Kanban/VoyageCardInfo.vue'
export default {
    components: { VoyageCardInfo },
    name: "ResponsabilityCard",
    props: {
       voyage: null,
       voyage_status: {type: String, default:"AGUARDANDO ACEITAÇÃO"},
       voyage_number: {type: Number, default: 0},
       responsability_code: {type: String, default: "000"},
       show_actions: {type: Boolean, default: true},
    },
    data() {
        return{
          dialog: null,
          dialog_type: 1,
          dialog_title: "Atenção",
          dialog_message: "Confirma o Aceite de Responsabilidade?",
          PCSVoyageID: '#'
        }
    },
    beforeMount() {
      this.PCSVoyageID = this.getPCSVoyageID(this.voyage);
    },
    methods: {
        showConfirmDialogAccept(){
          this.dialog_type = 1 
          this.dialog_title = "Aceitar"
          this.dialog_message = "Confirma o aceite de responsabilidade?"
          this.dialog = true
        },
        showConfirmDialogRefuse(){
          this.dialog_type = 2 
          this.dialog_title = "Recusar"
          this.dialog_message = "Confirma a recusa de responsabilidade?"
          this.dialog = true
        },
        confirm(){
          if (this.dialog_type == 1)
          {
            this.btnConfirmAcceptance()
          }else{
            this.btnRejectAcceptance()
          }
        },
        /**
         * Emite o evento quando o usuário clica no botão de confirmar aceite.
         */
        btnConfirmAcceptance(){
          this.acceptDialog=false
          var data = {
            cnpj: this.$store.state.cnpj,
            statusCode: "A003",
            acceptance: "Accepted", 
            responsabilityCode: this.responsability_code
          }
          if (this.voyage.PCSVoyageID) {
            Object.assign(data, {PCSVoyageID: this.PCSVoyageID})
          }else{
            Object.assign(data, {receiptID: this.PCSVoyageID});
          }

          this.$emit("btnConfirmAcceptance",data)
        },
        /**
         * Emite o evento quando o usuário clica no botão de rejeitar aceite.
         */
        btnRejectAcceptance(){
          var data = {
            cnpj: this.$store.state.cnpj,
            statusCode: "A002",
            acceptance: "Refused",
            responsabilityCode: this.responsability_code
          }
          if (this.voyage.PCSVoyageID) {
            Object.assign(data, {PCSVoyageID: this.PCSVoyageID})
          }else{
            Object.assign(data, {receiptID: this.PCSVoyageID});
          }
          this.$emit("btnRejectAcceptance", data)
        },
        getPCSVoyageID(voyage){
          return voyage.PCSVoyageID ? voyage.PCSVoyageID: voyage.receiptID;
        },
    }
}
</script>