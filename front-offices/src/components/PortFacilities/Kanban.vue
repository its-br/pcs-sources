<template>
  <v-container fluid  >
    <v-row class="flex-nowrap mx-3" >
      <v-col cols="3" class="k-cols">
        <v-layout column class="k-container rounded">
          <h3 class="">{{this.$t('KanbanCols.colNomination')}} </h3>
          <div><v-icon outlined>mdi-layers-triple-outline</v-icon> {{this.transportCallsInAcceptance.length}}  </div>
          <VoyageCard v-for="(tpCall, index) in transportCallsInAcceptance" :key="index" 
            cardType="responsability" 
            :voyage="tpCall.voyage" 
            :transportCallID="tpCall.transportCallID" 
            :eventColors="tpCall.eventColors" 
            :voyageStatus="tpCall.voyageStatus"
            v-on:postAcceptance="sendAcceptance"

          />
        </v-layout>
      </v-col>
      <v-col cols="3" class="k-cols">
        <v-layout column class="k-container rounded">
          <h3 class="">{{this.$t('KanbanCols.colPlanning')}}</h3>
          <div><v-icon outlined>mdi-layers-triple-outline</v-icon> {{this.transportCallsInPreparation.length}}  </div>
          <VoyageCard v-for="(tpCall, index) in transportCallsInPreparation" :key="index" 
            cardType="eventplanning" 
            :voyage="tpCall.voyage" 
            :transportCallID="tpCall.transportCallID" 
            :eventColors="tpCall.eventColors" 
            :voyageStatus="tpCall.voyageStatus"
          />
        </v-layout>
      </v-col>
      <v-col cols="3" class="k-cols">
        <v-layout column class="k-container rounded">
          <h3 class="">{{this.$t('KanbanCols.colOperation')}}</h3>
          <div><v-icon outlined>mdi-layers-triple-outline</v-icon> {{this.transportCallsInOperation.length}}  </div>
          <VoyageCard v-for="(tpCall, index) in transportCallsInOperation" :key="index" 
            cardType="eventplanning" 
            :voyage="tpCall.voyage" 
            :transportCallID="tpCall.transportCallID" 
            :eventColors="tpCall.eventColors" 
            :voyageStatus="tpCall.voyageStatus"
          />
        </v-layout>
      </v-col>
      <v-col cols="3" class="k-cols">
        <v-layout column class="k-container rounded">
          <h3 class="">{{this.$t('KanbanCols.colCompleted')}}</h3>
          <div><v-icon outlined>mdi-layers-triple-outline</v-icon> {{this.transportCallsInCompletion.length}}  </div>
          <VoyageCard v-for="(tpCall, index) in transportCallsInCompletion" :key="index" 
            cardType="eventplanning" 
            :voyage="tpCall.voyage" 
            :transportCallID="tpCall.transportCallID" 
            :eventColors="tpCall.eventColors" 
            :voyageStatus="tpCall.voyageStatus"
          />
        </v-layout>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>

import kanbanMixin from '@/mixins/kanbanMixin.js';
import VoyageCard from '../Voyage/Kanban/VoyageCard.vue';

export default {
    name: 'Kanban',
    mixins:[kanbanMixin], 
    data (){
      return{
        voyages: null,
        voyageAcceptances: null,
        transportCallAcceptances: [],
        otherMaritimeAgencyAcceptances: [],
        transportCalls: [],
        transportCallsInAcceptance: [],
        transportCallsInPreparation: [],
        transportCallsInOperation: [],
        transportCallsInCompletion: []
      }
    },
    watch:{
      voyages(){
        if (this.voyages && this.voyageAcceptances){
          this.startUpdate()
        }
      },
      voyageAcceptances(){
        if (this.voyageAcceptances){
          this.parseAcceptances(this.voyageAcceptances)
        }
        if (this.voyages && this.voyageAcceptances ){
          this.startUpdate()
        }
      }
    },
    beforeMount(){
      this.fillKanban()
    },
    components: {
        VoyageCard
    },
    methods: {
      /** 
       * Preenche o Kanban com todas as paradas das viagens, conforme o processo:
       - Acessa as APIs VOYAGES e VOYAGE ACCEPTANCE (em paralelo) e armazena as viagens e aceites para processamento;
       - Separa os aceites do terminal e das ag??ncias secund??rias nas vari??veis `transportCallAcceptances` e `otherMaritimeAgencyAcceptances`;
       - Re??ne todas as paradas das viagens no array `transportCalls`, que recebe objetos com informa????es para cria????o e posicionamento dos cards;
       - Verifica se cada viagem possui todos os aceites das ag??ncias secund??rias e armazena os resultados no objeto `transportCalls`;
       - Verifica o aceite do terminal para cada parada e armazena os resultados no objeto `transportCalls`;
       - Acessa a API EVENT_PLANNING para compilar os estados de cada evento em cada parada, armazenando os resultados no objeto `transportCalls`;
       - Acessa cada parada em `transportCalls` e aplica regras para determinar a coluna de posicionamento no Kanban (`placementState` 1 a 4);
       - Adiciona os objetos de `transportCalls` de cada parada nos arrays para popular as colunas do Kanban a partir da indica????o `placementState`;
        Os arrays transportCallsIn(acceptance, preparation etc.) s??o espec??ficos para popular cada coluna do Kanban. 
      */
      fillKanban(){
        this.clearVariables()        
        this.getVoyages()
        this.getAcceptances()
      },
      startUpdate()
      {
        this.parseTransportCalls()
        this.updateKanban()
      },
        /**
         * Limpa vari??veis para reiniciar 
         */ 
      clearVariables(){
        this.voyages = null
        this.voyageAcceptances = null
        this.transportCallAcceptances= []
        this.otherMaritimeAgencyAcceptances=[]
        this.transportCalls = []
        this.transportCallsInAcceptance = []
        this.transportCallsInPreparation = []
        this.transportCallsInOperation = []
        this.transportCallsInCompletion = []
      },
      sendAcceptance(requestData){
        this.postAcceptance(requestData)
      },
    }
  }
</script>

<style >
.k-container{
    background-color: var(--v-kanbancols-base);
    padding: 0.7em 0.7em 4em 0.7em;
}
.k-cols{
    padding: 8px;
    min-width: 290px;
    width: calc(100wh / 4);
    max-width: 450px;
}
</style>