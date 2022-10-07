<template>
  <v-container fluid  >
    <v-row class="flex-nowrap mx-3" >
      <v-col cols="3" class="k-cols">
        <v-layout column class="k-container rounded">
          <h3 class="">{{this.$t('KanbanCols.colCreation')}}</h3>
          <div><v-icon outlined>mdi-layers-triple-outline</v-icon> {{this.transportCalls_in_acceptance.length}}  </div>
          <VoyageCard v-for="(transportcall, index) in transportCalls_in_acceptance" :key="index" card_type="eventplanning" 
            :voyage="voyages[transportcall.voyage]" 
            :transportCallID="transportcall.transportCallID" 
            :event_colors="transportcall.event_colors" 
            :voyage_status="transportcall.voyage_status"
            v-on:click_confirm_acceptance="confirm_acceptance"
            v-on:click_reject_acceptance="reject_acceptance"
          />
        </v-layout>
      </v-col>
      <v-col cols="3" class="k-cols">
        <v-layout column class="k-container rounded">
          <h3 class="">{{this.$t('KanbanCols.colPlanning')}}</h3>
          <div><v-icon outlined>mdi-layers-triple-outline</v-icon> {{this.transportCalls_in_preparation.length}}  </div>
          <!-- <card-events card_type="eventplanning"/> -->
          <VoyageCard v-for="(transportcall, index) in transportCalls_in_preparation" :key="index" 
          card_type="eventplanning" :voyage="voyages[transportcall.voyage]" :transportCallID="transportcall.transportCallID" 
          :event_colors="transportcall.event_colors" :voyage_status="transportcall.voyage_status"
          
           />
        </v-layout>
      </v-col>
      <v-col cols="3" class="k-cols">
        <v-layout column class="k-container rounded">
          <h3 class="">{{this.$t('KanbanCols.colOperation')}}</h3>
          <div><v-icon outlined>mdi-layers-triple-outline</v-icon> {{this.transportCalls_in_operation.length}}  </div>
          <!-- <VoyageCard card_type="eventplanning"/> -->
          <VoyageCard v-for="(transportcall, index) in transportCalls_in_operation" :key="index" 
          card_type="eventplanning" :voyage="voyages[transportcall.voyage]" :transportCallID="transportcall.transportCallID" 
          :event_colors="transportcall.event_colors" :voyage_status="transportcall.voyage_status"
         />
        </v-layout>
      </v-col>
      <v-col cols="3" class="k-cols">
        <v-layout column class="k-container rounded">
          <h3 class="">{{this.$t('KanbanCols.colCompleted')}}</h3>
          <div><v-icon outlined>mdi-layers-triple-outline</v-icon> {{this.transportCalls_in_completion.length}}  </div>
          <!-- <card-events card_type="eventplanning"/> -->
          <VoyageCard v-for="(transportcall, index) in transportCalls_in_completion" :key="index" 
          card_type="eventplanning" :voyage="voyages[transportcall.voyage]" :transportCallID="transportcall.transportCallID" 
          :event_colors="transportcall.event_colors" :voyage_status="transportcall.voyage_status"
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
        acceptances: null,
        transportCall_acceptances: [],
        otherMaritimeAgency_acceptances: [],
        transportCalls: [],
        transportCalls_in_acceptance: [],
        transportCalls_in_preparation: [],
        transportCalls_in_operation: [],
        transportCalls_in_completion: []
      }
    },
    watch:{
      voyages(){
        if (this.voyages && this.acceptances){
          this.startUpdate()
        }
      },
      acceptances(){
        if (this.acceptances){
          this.parseAcceptances(this.acceptances)
        }
        if (this.voyages && this.acceptances ){
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
       - Separa os aceites do terminal e das agências secundárias nas variáveis `transportCall_acceptances` e `otherMaritimeAgency_acceptances`;
       - Reúne todas as paradas das viagens no array `transportCalls`, que recebe objetos com informações para criação e posicionamento dos cards;
       - Verifica se cada viagem possui todos os aceites das agências secundárias e armazena os resultados no objeto `transportCalls`;
       - Verifica o aceite do terminal para cada parada e armazena os resultados no objeto `transportCalls`;
       - Acessa a API EVENT_PLANNING para compilar os estados de cada evento em cada parada, armazenando os resultados no objeto `transportCalls`;
       - Acessa cada parada em `transportCalls` e aplica regras para determinar a coluna de posicionamento no Kanban (`placement_state` 1 a 4);
       - Adiciona os objetos de `transportCalls` de cada parada nos arrays para popular as colunas do Kanban a partir da indicação `placement_state`;
        Os arrays transportCalls_in_*(acceptance, preparation etc.) são específicos para popular cada coluna do Kanban. 
      */
      fillKanban(){
        this.clearVariables()        
        this.getVoyages()
        this.getAcceptances()

      },
      startUpdate()
      {
        this.get_transportCalls()
        this.get_agencies_acceptance()
        this.get_terminal_acceptance()
        this.updateKanban()
      },
        /**
         * Limpa variáveis para reiniciar 
         */ 
      clearVariables(){
        this.voyages = null
        this.acceptances = null
        this.transportCall_acceptances= []
        this.otherMaritimeAgency_acceptances=[]
        this.transportCalls = []
        this.transportCalls_in_acceptance = []
        this.transportCalls_in_preparation = []
        this.transportCalls_in_operation = []
        this.transportCalls_in_completion = []
      },
      /**
       * Envia confirmação de aceite
       */
     confirm_acceptance(data){
       this.postAcceptance(data)
     },
     /** 
      * Envia recusa
      */
     reject_acceptance(data){
       this.postAcceptance(data)
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