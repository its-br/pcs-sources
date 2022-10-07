<template>
<div class="my-4 mx-2">
  <v-row>
    <v-col cols="12" lg="4" md="4" sm="12" v-for="(item, index) in confirmedVoyages" :key="index" >
      <pilot-card 
        :voyage="item.voyage"  
        :pilotEventLabel="item.label" 
        :pilotEventTime="item.time" 
        :pilotEventDate="item.date"  />
   </v-col>
  </v-row>
</div> 
</template>

<script>
import axios from 'axios';
import {api} from '@/helpers/apis';
import apisMixin from '@/mixins/apisMixin.js';
import PilotCard from './PilotCard.vue';


export default {
    name: "PilotDashboard",
    mixins:[apisMixin], 
    data (){
      return {
        voyages: null,
        createdVoyages: [],
        confirmedVoyages: [],
        operationVoyages: [],
        endedVoyages: [],
      }
    },
    watch: {
      voyages(){
        if (this.voyages){
          this.startUpdate()
        }
      },
    },
    components: {
      PilotCard
    },
    beforeMount(){
      this.getVoyages()
    },
    methods: {
      startUpdate(){
        if (this.voyages && Array.isArray(this.voyages))
          this.voyages.forEach(voyage => {
            if (voyage.PCSVoyageID ){
              this.setCardInfo(voyage)
            }else {
              this.createdVoyages.push(voyage)
            }
          });
        // if (this.voyages && Array.isArray(this.voyages)){
        //   for (let index = 0; index < this.voyages.length; index++) {
        //     if (this.voyages[index] && this.voyages[index].PCSVoyageID ){
        //       this.setCardInfo(this.voyages, index)
        //     }else {
        //       this.created_voyages.push(this.voyages[index])
        //     }
        //   }
        // }
      },
      /**
       * Faz a requisição à api Event Planning para retornar o horário
       * de subida do prático (PTA ou ATA)
       * e acrescenta as informações a confirmed_voyages para popular os cards
       */
      setCardInfo(voyage){
        var transportCallID = (voyage.transportCall[0])?voyage.transportCall[0].transportCallID:null; 
        if (voyage.PCSVoyageID && transportCallID){
          axios
            .get(api.EVENT_PLANNING + "/" + voyage.PCSVoyageID )
            .then(response => {
              if (response.status == 200){
                var eventTime = this.filterEventTime(response.data)
                var item = {
                  voyage: voyage,
                  label: eventTime.label,
                  time: eventTime.datetime.strTime,
                  date: eventTime.datetime.strDate
                }
                this.confirmedVoyages.push(item)
              }else{
                  console.error(response.data);
              }
            })
            .catch(error => {
              console.error(error);
            })
        }
      },
      filterEventTime(data){
        // Retorna o horário planejado ou real de subida do prático no formato:       
        var pta = null 
        var ata = null
        data.map((item) => {
            if (item.operationsEventTypeCode == 'PILOTTIME' && item.eventClassifierCode == 'ARRI'){
              if (item.transportEventTypeCode=="PLN"){
                if (pta == null){
                    pta = item
                  }else{
                    if (new Date(pta.eventCreatedDateTime) < new Date(item.eventCreatedDateTime)){
                      pta = item
                    }
                }
              }
              if (item.transportEventTypeCode=="ACT"){
                if (ata == null){
                    ata = item
                  }else{
                    if (new Date(ata.eventCreatedDateTime) < new Date(item.eventCreatedDateTime)){
                      ata = item
                    }
                }
              }
          }
        });
        if (ata != null){
          return {
            label: "ATA", 
            datetime: this.parseDatetime(ata.eventTime)
          }
        }else{
          if (pta != null){
            return {
              label: "PTA", 
              datetime: this.parseDatetime(pta.eventTime)
            }
          }else{
            return {
              label: "ETA", 
              datetime: {
                strDate: "-", 
                strTime: "-"
              }
            }  
          }
        }

      },
      /**
       * Converte o horário no formato 2022-04-10T07:00:00Z e retorna o objeto:
       * { 
       *    str_date: '10-04-2022',
       *    str_time: '07:00' 
       * }       
       */
      parseDatetime(strDatetime){ 
        var parts = strDatetime.replace('Z', '').split('T')
        var dateParts = parts[0].split('-')
        var timeParts = parts[1].split(':')
        return {
          strDate: dateParts[2] + "-" +  dateParts[1] + "-" + dateParts[0], 
          strTime: timeParts[0] + ":" + timeParts[1]
        }
      },

    }
};
</script>