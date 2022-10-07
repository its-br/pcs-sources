<template>
<v-content class="mt-2 mb-4 ">
   <!--TERMINAL-->
        <v-card min-width="272" max-width="768" class="mt-4 mx-auto">
            <v-card-text class="text-center">
                {{this.portFacilityTypeDcsaName}}  
            </v-card-text>
        </v-card>
    <!--EVENTO SUBIDA DO PRÁTICO-->
    <card-event :event_card_type="1" :event_show_cards="show_cards" ref="PilotBoardingPlace" @update_event="send_event_info"></card-event>
    <!--EVENTO ATRACAÇÃO-->
    <card-event :event_card_type="2" :event_show_cards="show_cards" ref="BerthArrival" @update_event="send_event_info"></card-event>
    <!--EVENTO INÍCIO DE CARGA-->
    <card-event :event_card_type="3" :event_show_cards="show_cards" ref="StartCargoOperations" @update_event="send_event_info"></card-event>
    <!--EVENTO FIM DE CARGA-->
    <card-event :event_card_type="4" :event_show_cards="show_cards" ref="CargoCompletion" @update_event="send_event_info"></card-event>
    <!--DESATRACAÇÃO-->
    <card-event :event_card_type="5" :event_show_cards="show_cards" ref="BerthDeparture" @update_event="send_event_info"></card-event>
    <!--SWTICH--> 
    <v-timeline>
      <v-card  flat min-width="272" max-width="768" class="mt-4 mx-auto">
        <v-chip-group class="my-n2 py-n2">
          <v-switch v-model="show_cards" class="mx-auto"></v-switch>
        </v-chip-group>
      </v-card>
      <!--LEGENDA--> 
      <v-card flat min-width="272" max-width="768" class="mt-4 mx-auto">
        <v-card-subtitle class="caption font-weight-bold">
          {{this.$t('EventPlanning.Legend')}}:
        </v-card-subtitle>
        <v-card-text>
          <v-row>
            <v-col cols="12" lg="3" md="3" sm="12">
              <v-icon small color="red">mdi-circle</v-icon><span class="caption">{{this.$t('EventPlanning.legend_PendingTime')}}</span>
            </v-col>
            <v-col cols="12" lg="3" md="3" sm="12">
              <v-icon small color="yellow">mdi-circle</v-icon><span class="caption">{{this.$t('EventPlanning.legend_WaitingTime')}}</span>
            </v-col>
            <v-col cols="12" lg="3" md="3" sm="12">
              <v-icon small color="green">mdi-circle</v-icon><span class="caption">{{this.$t('EventPlanning.legend_ActiveEvent')}}</span>
            </v-col>
            <v-col cols="12" lg="3" md="3" sm="12">
              <v-icon small color="blue">mdi-circle</v-icon><span class="caption">{{this.$t('EventPlanning.legend_CompletedEvent')}}</span>
            </v-col>
          </v-row>
        </v-card-text> 
      </v-card>
    </v-timeline>
</v-content>
</template>

<script>
import axios from 'axios';
import {api} from '../../helpers/apis';
import CardEvent from './CardEvent.vue';

export default {
    name: "TimelineEvents.vue",
    props: {
    },
    components: {
      CardEvent,
    },
    data () {
        return{
          show_cards: true,
          PCSVoyageID: null,
          transportCallID: null,
          portFacilityTypeDcsaCode: "POTE",
          portFacilityTypeDcsaName: "",

        }
    },
    created () {
      try {
        this.PCSVoyageID = this.$route.params.PCSVoyageID;
        this.transportCallID = this.$route.params.TransportCallID;
      } catch (error) {
        console.error(error)
      }
      
    },
    mounted () {
      // * Por enquanto, está com valor fixo.
      // * É necessário alterar na integração  
      this.portFacilityTypeDcsaCode = "POTE"
      // Define a identificação da instalação portuária
      this.set_portFacilityTypeDcsaName()
      // Atualiza os cards no início
      this.update_cards()  
      // Apenas para teste: Atualiza a cada x segundos 
      this.test_function_update()
    },
    methods:{
      test_function_update(){
       // Apenas para teste 
        window.setInterval(() => {
              this.update_cards()
          }, 60000); // 60.000 = 1 min
      },
      set_portFacilityTypeDcsaName()
      {
        // Define a identificação da instalação portuária
        // na parte superior da linha do tempo
        // a partir de códigos da DCSA
        switch(this.portFacilityTypeDcsaCode)
        {
          case "BOCR":
            this.portFacilityTypeDcsaName = this.$t('EventPlanning.DCSA_BOCR')
            break;
          case "CLOC":
            this.portFacilityTypeDcsaName =  this.$t('EventPlanning.DCSA_CLOC')
            break;
          case "COFS":
            this.portFacilityTypeDcsaName = this.$t('EventPlanning.DCSA_COFS')
            break;
          case "COYA":
            this.portFacilityTypeDcsaName = this.$t('EventPlanning.DCSA_COYA')
            break;
          case "DEPO":
            this.portFacilityTypeDcsaName = this.$t('EventPlanning.DCSA_DEPO')
            break;
          case "INTE":
            this.portFacilityTypeDcsaName = this.$t('EventPlanning.DCSA_INTE')
            break;
          case "POTE":
            this.portFacilityTypeDcsaName = this.$t('EventPlanning.DCSA_POTE')
            break;
          case "PBST":
            this.portFacilityTypeDcsaName = this.$t('EventPlanning.DCSA_PBST')
            break;
          default:
            this.portFacilityTypeDcsaName = this.$t('EventPlanning.DCSA_POTE')
        }
      },
      // GET
      // Realiza a atualização dos eventos a partir do retorno de dados da API
      update_cards(){
        axios.get(api.EVENT_PLANNING + '/' + this.PCSVoyageID)
            .then(response => {
            if (response.status == 200){
                this.set_PilotBoardingPlace(response.data)
                this.set_BerthArrival(response.data)
                this.set_StartCargoOperations(response.data)
                this.set_CargoCompletion(response.data)
                this.set_BerthDeparture(response.data)
            }else{
                console.error(response.data);
            }
            })
            .catch(error => {
            console.error(error);
            })
      },
      get_current_datetime(){
        // Retorna a data e horário atual da atualização do evento
        // Coloca no formato para envio ao servidor (Ex.: 2022-04-10T21:04:00Z)
        // É preciso definir se esse tipo de dado será gerado aqui ou no servidor
        var current_date = new Date()
        var year = current_date.getUTCFullYear()
        var month = (current_date.getUTCMonth() + 1).toString()
        var day = current_date.getUTCDate().toString()
        var hours = current_date.getUTCHours().toString()
        var minutes = current_date.getUTCMinutes().toString()
        var seconds = current_date.getUTCSeconds().toString()
        if (month.length < 2){month = "0"+ month;}         
        if (day.length < 2){day = "0"+ day;}
        if (hours.length < 2){hours = "0"+ hours;}
        if (minutes.length < 2){minutes = "0"+ minutes;}
        if (seconds.length < 2){seconds = "0"+ seconds;} 
        var datetime = year + "-"        
        datetime+= month + "-"
        datetime+= day 
        datetime+=  " " 
        datetime+= hours + ":"
        datetime+= minutes + ":"
        datetime+= seconds + ""
        return datetime 
      },
      make_datetime(str_date,str_time){
        var date_parts = str_date.split('-')
        var datetime = date_parts[2] + "-" + date_parts[1] + "-" + date_parts[0] + "T"+ str_time + ":00"
        return datetime
      },
      parse_datetime(str_datetime){        
        var parts = str_datetime.replace('Z', '').slice(0, -1).split('T')
        var date_parts = parts[0].split('-')
        var time_parts = parts[1].split(':')
        var parsed_date = date_parts[2] + "-" +  date_parts[1] + "-" + date_parts[0] 
        var parsed_time = time_parts[0] + ":" + time_parts[1]
        var parsed_datetime = {str_date: parsed_date, str_time: parsed_time} 
        return parsed_datetime;       
      },
      /**
       * @deprecated
       */
      parse_datetime2date(str_datetime){
        str_datetime = str_datetime.replace("Z","")
        var parts = str_datetime.slice(0, -1).split(' ')
        var date_parts = parts[0].split('-')
        var time_parts = parts[1].split(':')
        var date = new Date(parseInt(date_parts[0]),parseInt(date_parts[1])-1, parseInt(date_parts[2]), parseInt(time_parts[0]),parseInt(time_parts[1]),parseInt(time_parts[2]))
        return date;
      },
      /**
       * @deprecated
       */
      is_new_datetime(str_d1,str_d2){
        var d1 = this.parse_datetime2date(str_d1)
        var d2 = this.parse_datetime2date(str_d2)
        return d1 < d2
      },
      filter_events(data,event_type_code,event_classifier_code){
        var nodes = {est: "0", req: "0", pln: "0", act: "0"}
        var filter = {est: null, req: null, pln: null, act: null}
        data.map((item) => {
            if (item.operationsEventTypeCode == event_type_code && item.eventClassifierCode == event_classifier_code){
              switch (item.transportEventTypeCode){
                case "EST":
                  if (filter.est == null){
                    filter.est = item
                    nodes.est = "1"
                  }else{
                    if (new Date(filter.est.eventCreatedDateTime) < new Date(item.eventCreatedDateTime)){
                      filter.est = item 
                      nodes.est = "1"
                    }
                  }
                break;
                case "REQ":
                  if (filter.req == null){
                    filter.req = item
                    nodes.req = "1"
                  }else{
                    if (new Date(filter.est.eventCreatedDateTime) < new Date(item.eventCreatedDateTime)){
                      filter.req = item
                      nodes.req = "1"
                    }
                  }
                break;
                case "PLN":
                  if (filter.pln == null){
                    filter.pln = item
                    nodes.pln = "1"
                  }else{
                    if (new Date(filter.est.eventCreatedDateTime) < new Date(item.eventCreatedDateTime)){
                      filter.pln = item
                      nodes.pln = "1"
                    }
                  }
                break;
                case "ACT":
                  if (filter.act == null){
                    filter.act = item
                    nodes.act = "1"
                  }else{
                    if (filter.est != null){
                      if (new Date(filter.est.eventCreatedDateTime) < new Date(item.eventCreatedDateTime)){
                        filter.act = item
                        nodes.act = "1"
                      }
                    }else{
                      filter.act = item
                      nodes.act = "1"
                    }
                  }
                break;
              }
          }
        });
        const code = nodes.est+nodes.req+nodes.pln+nodes.act
        return {keycode: code, nodes: nodes, events: filter}
      },
      set_PilotBoardingPlace(data){
        var rules = []
        rules["0000"] = 0
        rules["1000"] = 1
        rules["1100"] = 2
        rules["1110"] = 3
        rules["1111"] = 4
        const filter = this.filter_events(data,"PILOTTIME","ARRI")
        const code = rules[filter.keycode]
        this.$refs.PilotBoardingPlace.set_event_state_code(code)       
        if (filter.nodes.est == "1"){
          const ETA = this.parse_datetime(filter.events.est.eventTime)
          this.$refs.PilotBoardingPlace.set_estimated_datetime(ETA.str_date,ETA.str_time)
        }
        if (filter.nodes.req == "1"){
          const RTA = this.parse_datetime(filter.events.req.eventTime)
          this.$refs.PilotBoardingPlace.set_required_datetime(RTA.str_date,RTA.str_time)
        }
        if (filter.nodes.pln == "1"){
          const PTA = this.parse_datetime(filter.events.pln.eventTime)
          this.$refs.PilotBoardingPlace.set_planned_datetime(PTA.str_date,PTA.str_time)
        }
        if (filter.nodes.act == "1"){
          const ATA = this.parse_datetime(filter.events.act.eventTime)
          this.$refs.PilotBoardingPlace.set_actual_datetime(ATA.str_date,ATA.str_time)
        }
      },
      set_BerthArrival(data){
        var rules = []
        rules["0000"] = 0 
        rules["1000"] = 1 
        rules["1100"] = 2 
        rules["1110"] = 3 
        rules["1111"] = 4 
        const filter = this.filter_events(data,"TRANSPORT","ARRI")
        const code = rules[filter.keycode]
        this.$refs.BerthArrival.set_event_state_code(code)
        if (filter.nodes.est == "1"){
          const ETA = this.parse_datetime(filter.events.est.eventTime)
          this.$refs.BerthArrival.set_estimated_datetime(ETA.str_date,ETA.str_time)
        }
        if (filter.nodes.req == "1"){
          const RTA = this.parse_datetime(filter.events.req.eventTime)
          this.$refs.BerthArrival.set_required_datetime(RTA.str_date,RTA.str_time)
        }
        if (filter.nodes.pln == "1"){
          const PTA = this.parse_datetime(filter.events.pln.eventTime)
          this.$refs.BerthArrival.set_planned_datetime(PTA.str_date,PTA.str_time)
        }
        if (filter.nodes.act == "1"){
          const ATA = this.parse_datetime(filter.events.act.eventTime)
          this.$refs.BerthArrival.set_actual_datetime(ATA.str_date,ATA.str_time)
        }
      },
      set_StartCargoOperations(data){
        var rules = []
        rules["0000"] = 0
        rules["1000"] = 0
        rules["0000"] = 0
        rules["0001"] = 4
        const filter = this.filter_events(data,"OPERATION","ARRI")
        const code = rules[filter.keycode]
        this.$refs.StartCargoOperations.set_event_state_code(code)
        if (filter.nodes.est == "1"){
          const ETS = this.parse_datetime(filter.events.est.eventTime)
          this.$refs.StartCargoOperations.set_estimated_datetime(ETS.str_date,ETS.str_time)
        }
        if (filter.nodes.req == "1"){
          const RTS = this.parse_datetime(filter.events.req.eventTime)
          this.$refs.StartCargoOperations.set_required_datetime(RTS.str_date,RTS.str_time)
        }
        if (filter.nodes.pln == "1"){
          const PTS = this.parse_datetime(filter.events.pln.eventTime)
          this.$refs.StartCargoOperations.set_planned_datetime(PTS.str_date,PTS.str_time)
        }
        if (filter.nodes.act == "1"){
          const ATS = this.parse_datetime(filter.events.act.eventTime)
          this.$refs.StartCargoOperations.set_actual_datetime(ATS.str_date,ATS.str_time)
          this.$refs.StartCargoOperations.set_actual_datetime_for_StartCargoOperations(ATS.str_date,ATS.str_time)
        }
      },
      set_CargoCompletion(data){
        var rules = []
        rules["0000"] = 0
        rules["1000"] = 1
        rules["1100"] = 2
        rules["1110"] = 3
        rules["1111"] = 4
        const filter = this.filter_events(data,"OPERATION","DEPA")
        const code = rules[filter.keycode]
        this.$refs.CargoCompletion.set_event_state_code(code)
        if (filter.nodes.est == "1"){
          const ETC = this.parse_datetime(filter.events.est.eventTime)
          this.$refs.CargoCompletion.set_estimated_datetime(ETC.str_date,ETC.str_time)
        }
        if (filter.nodes.req == "1"){
          const RTC = this.parse_datetime(filter.events.req.eventTime)
          this.$refs.CargoCompletion.set_required_datetime(RTC.str_date,RTC.str_time)
        }
        if (filter.nodes.pln == "1"){
          const PTC = this.parse_datetime(filter.events.pln.eventTime)
          this.$refs.CargoCompletion.set_planned_datetime(PTC.str_date,PTC.str_time)
        }
        if (filter.nodes.act == "1"){
          const ATC = this.parse_datetime(filter.events.act.eventTime)
          this.$refs.CargoCompletion.set_actual_datetime(ATC.str_date,ATC.str_time)
        }
      },
      set_BerthDeparture(data){
        var rules = []
        rules["0000"] = 0
        rules["1000"] = 1
        rules["1100"] = 2
        rules["1110"] = 3
        rules["1111"] = 4
        const filter = this.filter_events(data,"TRANSPORT","DEPA")
        const code = rules[filter.keycode]       
        this.$refs.BerthDeparture.set_event_state_code(code)
        if (filter.nodes.est == "1"){
          const ETD = this.parse_datetime(filter.events.est.eventTime)
          this.$refs.BerthDeparture.set_estimated_datetime(ETD.str_date,ETD.str_time)
        }
        if (filter.nodes.req == "1"){
          const RTD = this.parse_datetime(filter.events.req.eventTime)
          this.$refs.BerthDeparture.set_required_datetime(RTD.str_date,RTD.str_time)
        }
        if (filter.nodes.pln == "1"){
          const PTD = this.parse_datetime(filter.events.pln.eventTime)
          this.$refs.BerthDeparture.set_planned_datetime(PTD.str_date,PTD.str_time)
        }
        if (filter.nodes.act == "1"){
          const ATD = this.parse_datetime(filter.events.act.eventTime)
          this.$refs.BerthDeparture.set_actual_datetime(ATD.str_date,ATD.str_time)
        }
      },
      // POST 
      // Envia atualizações de horários dos eventos para o servidor
      send_event_info(event_info){
        // Gera os dados para a API e faz o envio via post
        // A geração de dados é dada pelo perfil do ator e o estado atual do código do evento
        // O argumento 'event_info' é passado pelo componente filho CardEvent
        // A função é chamada pela instância do CardEvent no componente pai a partir do evento '@update_event'
        // PortAuthoriry
        if (event_info.profile == "PortAuthority")
        {
          if (event_info.event_card_type == 1 && event_info.event_state_code == 1){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventPCSCode: "P002",
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "STRT",
            transportEventTypeCode: "REQ",
            operationsEventTypeCode: "PILOTTIME",
            eventClassifierCode: "ARRI"
            }
            this.post_event(data)
          }
          if (event_info.event_card_type == 1 && event_info.event_state_code == 2){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventPCSCode: "P002",
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "STRT",
            transportEventTypeCode: "REQ",
            operationsEventTypeCode: "PILOTTIME",
            eventClassifierCode: "ARRI"
            }
            this.post_event(data)
          }
        }
        // PortFacilities
        if (event_info.profile == "PortFacilities")
        {
          if (event_info.event_card_type == 2 && event_info.event_state_code == 1){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "STRT",
            transportEventTypeCode: "REQ",
            operationsEventTypeCode: "TRANSPORT",
            eventClassifierCode: "ARRI"
            }
            this.post_event(data)
          }
          if (event_info.event_card_type == 2 && event_info.event_state_code == 2){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventPCSCode: "B004",
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "STRT",
            transportEventTypeCode: "REQ",
            operationsEventTypeCode: "TRANSPORT",
            eventClassifierCode: "ARRI"
            }
            this.post_event(data)
          }
          if (event_info.event_card_type == 3 && event_info.event_state_code == 0){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventPCSCode: "S001",
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "CMPL",
            transportEventTypeCode: "ACT",
            operationsEventTypeCode: "OPERATION",
            eventClassifierCode: "ARRI"
            }
            this.post_event(data)
          }
          if (event_info.event_card_type == 3 && event_info.event_state_code == 4){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "CMPL",
            transportEventTypeCode: "ACT",
            operationsEventTypeCode: "OPERATION",
            eventClassifierCode: "ARRI"
            }
            this.post_event(data)
          }
          if (event_info.event_card_type == 4 && event_info.event_state_code == 0){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventPCSCode: "C001",
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "CMPL",
            transportEventTypeCode: "EST",
            operationsEventTypeCode: "OPERATION",
            eventClassifierCode: "DEPA"
            }
            this.post_event(data)
          }
          if (event_info.event_card_type == 4 && event_info.event_state_code == 1){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventPCSCode: "C001",
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "CMPL",
            transportEventTypeCode: "EST",
            operationsEventTypeCode: "OPERATION",
            eventClassifierCode: "DEPA"
            }
            this.post_event(data)
          }
          if (event_info.event_card_type == 4 && event_info.event_state_code == 2){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventPCSCode: "C002",
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "CMPL",
            transportEventTypeCode: "EST",
            operationsEventTypeCode: "OPERATION",
            eventClassifierCode: "DEPA"
            }
            this.post_event(data)
          }
          if (event_info.event_card_type == 4 && event_info.event_state_code == 3){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventPCSCode: "C004",
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "CMPL",
            transportEventTypeCode: "ACT",
            operationsEventTypeCode: "OPERATION",
            eventClassifierCode: "DEPA"
            }
            this.post_event(data)
          }
          if (event_info.event_card_type == 4 && event_info.event_state_code == 4){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventPCSCode: "C004",
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "CMPL",
            transportEventTypeCode: "ACT",
            operationsEventTypeCode: "OPERATION",
            eventClassifierCode: "DEPA"
            }
            this.post_event(data)
          }
          if (event_info.event_card_type == 5 && event_info.event_state_code == 0){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventPCSCode: "D001",
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "CMPL",
            transportEventTypeCode: "EST",
            operationsEventTypeCode: "TRANSPORT",
            eventClassifierCode: "DEPA"
            }
            this.post_event(data)
          }
          if (event_info.event_card_type == 5 && event_info.event_state_code == 1){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventPCSCode: "D001",
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "CMPL",
            transportEventTypeCode: "EST",
            operationsEventTypeCode: "TRANSPORT",
            eventClassifierCode: "DEPA"
            }
            this.post_event(data)
          }
          if (event_info.event_card_type == 5 && event_info.event_state_code == 2){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventPCSCode: "D002",
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "CMPL",
            transportEventTypeCode: "EST",
            operationsEventTypeCode: "TRANSPORT",
            eventClassifierCode: "DEPA"
            }
            this.post_event(data)
          }
          if (event_info.event_card_type == 5 && event_info.event_state_code == 3){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventPCSCode: "D004",
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "CMPL",
            transportEventTypeCode: "ACT",
            operationsEventTypeCode: "TRANSPORT",
            eventClassifierCode: "DEPA"
            }
            this.post_event(data)
          }
          if (event_info.event_card_type == 5 && event_info.event_state_code == 4){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventPCSCode: "D004",
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "CMPL",
            transportEventTypeCode: "ACT",
            operationsEventTypeCode: "TRANSPORT",
            eventClassifierCode: "DEPA"
            }
            this.post_event(data)
          }
        }
        // MaritimeAgents
        if (event_info.profile == "MaritimeAgent")
        {
          if (event_info.event_card_type == 1 && event_info.event_state_code == 0){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "STRT",
            transportEventTypeCode: "EST",
            operationsEventTypeCode: "PILOTTIME",
            eventClassifierCode: "ARRI"
            }
            this.post_event(data)
          }
          if (event_info.event_card_type == 1 && event_info.event_state_code == 1){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "STRT",
            transportEventTypeCode: "EST",
            operationsEventTypeCode: "PILOTTIME",
            eventClassifierCode: "ARRI"
            }
            this.post_event(data)
          }
          if (event_info.event_card_type == 1 && event_info.event_state_code == 2){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "STRT",
            transportEventTypeCode: "EST",
            operationsEventTypeCode: "PILOTTIME",
            eventClassifierCode: "ARRI"
            }
            this.post_event(data)
          }
          if (event_info.event_card_type == 1 && event_info.event_state_code == 3){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "STRT",
            transportEventTypeCode: "ACT",
            operationsEventTypeCode: "PILOTTIME",
            eventClassifierCode: "ARRI"
            }
            this.post_event(data)
          }
          if (event_info.event_card_type == 1 && event_info.event_state_code == 4){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
              transportCallID: this.transportCallID,
              eventCreatedDateTime: this.get_current_datetime(),
              eventTime: event_time,
              eventType: "STRT",
              transportEventTypeCode: "ACT",
              operationsEventTypeCode: "PILOTTIME",
              eventClassifierCode: "ARRI"
            }
            this.post_event(data)
          }
          if (event_info.event_card_type == 2 && event_info.event_state_code == 0){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "STRT",
            transportEventTypeCode: "EST",
            operationsEventTypeCode: "TRANSPORT",
            eventClassifierCode: "ARRI"
            }
            this.post_event(data)
          }
          if (event_info.event_card_type == 2 && event_info.event_state_code == 1){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "STRT",
            transportEventTypeCode: "EST",
            operationsEventTypeCode: "TRANSPORT",
            eventClassifierCode: "ARRI"
            }
            this.post_event(data)
          }
          if (event_info.event_card_type == 2 && event_info.event_state_code == 2){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "STRT",
            transportEventTypeCode: "EST",
            operationsEventTypeCode: "TRANSPORT",
            eventClassifierCode: "ARRI"
            }
            this.post_event(data)
          }
          if (event_info.event_card_type == 2 &&  event_info.event_state_code == 3){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "STRT",
            transportEventTypeCode: "ACT",
            operationsEventTypeCode: "TRANSPORT",
            eventClassifierCode: "ARRI"
            }
            this.post_event(data)
          }
          if (event_info.event_card_type == 2 && event_info.event_state_code == 4){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "STRT",
            transportEventTypeCode: "ACT",
            operationsEventTypeCode: "TRANSPORT",
            eventClassifierCode: "ARRI"
            }
            this.post_event(data)
          }
          if (event_info.event_card_type == 2 && event_info.event_state_code == 4){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "STRT",
            transportEventTypeCode: "ACT",
            operationsEventTypeCode: "TRANSPORT",
            eventClassifierCode: "ARRI"
            }
            this.post_event(data)
          }
          if (event_info.event_card_type == 4 && event_info.event_state_code == 1){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "CMPL",
            transportEventTypeCode: "REQ",
            operationsEventTypeCode: "OPERATION",
            eventClassifierCode: "DEPA"
            }
            this.post_event(data)
          }
          if (event_info.event_card_type == 4 && event_info.event_state_code == 2){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "CMPL",
            transportEventTypeCode: "REQ",
            operationsEventTypeCode: "OPERATION",
            eventClassifierCode: "DEPA"
            }
            this.post_event(data)
          }
          if (event_info.event_card_type == 5 && event_info.event_state_code == 1){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "CMPL",
            transportEventTypeCode: "REQ",
            operationsEventTypeCode: "TRANSPORT",
            eventClassifierCode: "DEPA"
            }
            this.post_event(data)
          }
          if (event_info.event_card_type == 5 && event_info.event_state_code == 2){
            const event_time = this.make_datetime(event_info.event_date,event_info.event_time)
            const data = {
            transportCallID: this.transportCallID,
            eventCreatedDateTime: this.get_current_datetime(),
            eventTime: event_time,
            eventType: "CMPL",
            transportEventTypeCode: "REQ",
            operationsEventTypeCode: "TRANSPORT",
            eventClassifierCode: "DEPA"
            }
            this.post_event(data)
          }
        }

      },
      post_event(data){
        // Faz a requisição de envio dos dados para o servidor via post. 
        axios.post(api.EVENT_PLANNING + "/" + this.PCSVoyageID,data)
        .then(response => {
          // Se a requisição for bem sucedida, executa função de atualização. 
          if (response.status == 201){
               this.update_cards()
            }else{
                console.error(response.data);
            }
        })
        .catch(error => {
          console.error(error);
        })
      }, 
      

  } 

}
</script>