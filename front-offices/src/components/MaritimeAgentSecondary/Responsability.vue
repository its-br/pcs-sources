<template>
<v-container fluid>
    <v-row>
        <v-col cols="12" lg="4" md="4" sm="12" v-for="(item, index) in filteredVoyages" :key="index">
          <responsability-card
            :voyage_number="index+1"
            :voyage="item.voyage"
            :voyage_status="item.voyage_status"
            :responsability_code="item.responsability_code"
            :show_actions="item.show_actions" 
            v-on:btnConfirmAcceptance="sendAcceptance"
            v-on:btnRejectAcceptance="sendAcceptance"
          >
          </responsability-card>
        </v-col>
    </v-row>
</v-container>
</template>
<script>


import ResponsabilityCard from './ResponsabilityCard.vue'
import axios from 'axios'
import {api} from '@/helpers/apis';

export default {

    name: "Responsability",
    components: { ResponsabilityCard },
    data() {
        return{
            filteredVoyages: [],
        }
    },
    beforeMount(){
      this.updateResponsabilityCards()
    },
    methods: {
      updateResponsabilityCards(){
        this.filteredVoyages = []
        const requestVoyages = axios.get(api.VOYAGES)
        const requestAcceptances = axios.get(api.VOYAGES_ACCEPTANCE)
        axios
        .all([requestVoyages, requestAcceptances])
        .then(axios.spread((...responses) => {
          const voyages = this.filterVoyages(responses[0].data)
          const acceptances = responses[1].data
          // Verifica a situação de aceitação para adicionar os cards

          for (let i = 0; i < voyages.length; i++) 
          {

            var acceptance = this.getAcceptance(this.getPCSVoyageID(voyages[i]),acceptances)
            switch (acceptance)
            {
              case 'Accepted':
                this.filteredVoyages.push({
                  voyage: voyages[i],
                  voyage_status: "VIAGEM ACEITA",
                  responsability_code: this.getResponsabilityCode(voyages[i]),
                  show_actions: false
                })
                break;
              case null:
                this.filteredVoyages.push({
                  voyage: voyages[i],
                  voyage_status: "AGUARDANDO ACEITAÇÃO",
                  responsability_code: this.getResponsabilityCode(voyages[i]),
                  show_actions: true
                })
                break;
              case 'Refused':
              case 'NotFound':
                // Não exibe card
                break;
            }
          }
        })).catch(errors => {
          console.error(errors);
        })

      },
      filterVoyages(voyages){
        var filteredVoyages = []
        for (let i = 0; i < voyages.length; i++) {
          for (let j = 0; j < voyages[i].otherMaritimeAgency.length; j++){
            if (voyages[i].otherMaritimeAgency[j].maritimeAgencyCnpj === this.$store.state.cnpj){
              filteredVoyages.push(voyages[i])
            }
          } 
        }
        return filteredVoyages
      },
      /**
       * @deprecated Filtro realizado no servidor
       */
      filterAcceptances(acceptances){
        var filteredAcceptances = []
        for (let i = 0; i < acceptances.length; i++){
          if (acceptances[i].cnpj == this.$store.state.cnpj){
            filteredAcceptances.push(acceptances[i])
          }
        }
        return filteredAcceptances
      },
      getPCSVoyageID(voyage){
        return voyage.PCSVoyageID ? voyage.PCSVoyageID: voyage.receiptID;
      },
      /**
       * Verifica a situação de aceitação da viagem
       * 
       * @return 
       * ```null``` = não há registro de aceitação ou recusa
       * 
       * ```NotFound``` = aceitação não encontrada
       * 
       * ```Refused``` = a viagem já foi recusada
       * 
       * ```Accepted``` = a viagem já foi aceita
       */
      getAcceptance(PCSVoyageID, acceptances){
        for (let i = 0; i < acceptances.length; i++) {
          if (PCSVoyageID == this.getPCSVoyageID(acceptances[i])){
            return acceptances[i].acceptance;
          }
        }
        return 'NotFound'
      },
      /**
       * recupera o ResponsabilityCode
       * 
       * @return 
       * ```NotFound``` = ResponsabilityCode não encontrado
       */
      getResponsabilityCode(voyage){
         for (let i = 0; i < voyage.otherMaritimeAgency.length; i++){
          if (voyage.otherMaritimeAgency[i].maritimeAgencyCnpj == this.$store.state.cnpj){
            return voyage.otherMaritimeAgency[i].responsabilityCode
          }
         }
         return 'NotFound'
      },
      sendAcceptance(data){
        axios.post(api.VOYAGE_ACCEPTANCE, data)
        .then(response => {
          if (response.status == 200|201){
            this.updateResponsabilityCards()
          }else{
            console.error(response);
          }
        })
        .catch(error => {
          console.error(error);
        })
      },
    }
}
</script>
