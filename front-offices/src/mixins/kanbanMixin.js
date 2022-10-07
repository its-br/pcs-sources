import i18n from '@/plugins/i18n'
import apisMixin from '@/mixins/apisMixin.js';

/**
 * 
 * @returns Array com todas as Viagens
 */
const kanbanMixin = {
  methods:{
    /**
     * Filtra as aceitações de agências secundárias e Terminal portuário (transporCalls) 
     * As aceitações são armazenadas em 2 arrays,
     *  transportCallAcceptances: armazena a aceitação do terminal portuário
     *  Para agências secundárias: armazena apenas o IDMethod da agência aceita
     * @param {} voyageAcceptances estrutura de dados das aceitações recebidas da api voyage-acceptances
     */
    parseAcceptances(voyageAcceptances){
      voyageAcceptances.forEach(acceptance => {
        var voyageID = acceptance.PCSVoyageID?acceptance.PCSVoyageID:acceptance.receiptID; 
        if ([ "T000", "T001", "T002" ].includes(acceptance.statusCode) ){ 
          this.transportCallAcceptances[voyageID]=[]
          this.transportCallAcceptances[voyageID][acceptance.transportCallID]=acceptance
        }else if ([ "A001", "A002", "A003" ].includes(acceptance.statusCode) ){
          this.otherMaritimeAgencyAcceptances[voyageID] = acceptance
        }
      });
    },
    /**
     * Percorre as viagens (api/voyages) e guarda todos os transportCalls em um array de transportCall  
     */
    parseTransportCalls(){
      this.transportCalls = []
      this.voyages.forEach(voyage => {
        voyage.transportCall.forEach(tpCall => {
          var transportCall = {
            voyage: voyage,
            voyageID: voyage.PCSVoyageID? voyage.PCSVoyageID:voyage.receiptID,
            transportCallID: tpCall.transportCallID, 
            events: {
              pilotBoardingPlace: 0,
              berthArrival: 0,
              startCargoOperations: 0,
              cargoCompletion: 0,
              berthDeparture:0
            }, 
            eventColors: ["grey", "grey", "grey", "grey", "grey"], 
            voyageStatus: i18n.t('mixinsKanban.statusNomination')
          }
          if (this.$store.state.profile == 'PortFacilities' && tpCall.portFacilityCnpj !== this.$store.state.cnpj){
            return;
          }
          this.transportCalls.push(transportCall)
        })
      });
    },
    updateEventPlanning(data, tpCallIndex){
      var events = {
        pilotBoardingPlace: 0,
        berthArrival: 0,
        startCargoOperations: 0,
        cargoCompletion: 0,
        berthDeparture:0
      }
      // pilotBoardingPlace
      var rules = this.getEventRules("PILOTTIME", "ARRI")
      events.pilotBoardingPlace = rules[this.filterEvents(data, "PILOTTIME", "ARRI").keycode]
      // berthArrival
      rules = this.getEventRules("TRANSPORT", "ARRI")
      events.berthArrival = rules[this.filterEvents(data, "TRANSPORT", "ARRI").keycode]
      // startCargoOperations
      rules = this.getEventRules("OPERATION", "ARRI")
      events.startCargoOperations = rules[this.filterEvents(data, "OPERATION", "ARRI").keycode]
      // cargoCompletion
      rules = this.getEventRules("OPERATION", "DEPA")
      events.cargoCompletion = rules[this.filterEvents(data, "OPERATION", "DEPA").keycode]
      // berthDeparture
      rules = this.getEventRules("TRANSPORT", "DEPA")
      events.berthDeparture = rules[this.filterEvents(data, "TRANSPORT", "DEPA").keycode]

      // Update TransportCalls
      this.transportCalls[tpCallIndex].events = events
      this.transportCalls[tpCallIndex].eventColors = this.getEventColors(events)
    },
    // Define as cores dos eventos para exibir no card
    getEventColors(events){
      var colors = []
      colors[0] = "yellow"
      colors[1] = "yellow"
      colors[2] = "red"
      colors[3] = "green"
      colors[4] = "blue"
      var eventColors = [
        colors[events.pilotBoardingPlace],
        colors[events.berthArrival],
        colors[events.startCargoOperations],
        colors[events.cargoCompletion],
        colors[events.berthDeparture]
      ]
      return eventColors
    },
    getEventRules(eventTypeCode, eventClassifierCode){
      // Retorna as regras para definir o estado do evento
      var rules = []
      if(eventTypeCode == "OPERATION" && eventClassifierCode == "ARRI")
      {
        rules["0000"] = 0 // grey
        rules["1000"] = 0 // grey
        rules["0000"] = 0 // grey
        rules["0001"] = 4 // blue
      }else{
        rules["0000"] = 0 // grey
        rules["1000"] = 1 // yellow
        rules["1100"] = 2 // red
        rules["1110"] = 3 // green
        rules["1111"] = 4 // blue
      }
      return rules 
    },
    filterEvents(data, eventTypeCode, eventClassifierCode){
      var nodes = {est: "0", req: "0", pln: "0", act: "0"}
      var filter = {est: null, req: null, pln: null, act: null}
      data.map((item) => {
          if (item.operationsEventTypeCode == eventTypeCode && item.eventClassifierCode == eventClassifierCode){
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
                    // if (isNewDatetime(filter.est.eventCreatedDateTime, item.eventCreatedDateTime)){
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
      const code = nodes.est + nodes.req + nodes.pln + nodes.act
      return {keycode: code, nodes: nodes, events: filter}
    },
    /**
     * chamado após o postAcceptance
     */
    refreshKanban(){
      this.getAcceptances()
    },
    updateKanban(){
      // Completa as informações dos objetos de `transportCalls`, acessando a API EVENTPLANNING.
      // Depois, chama a função para aplicação de regras para posicionar os cadas no Kanban. 
      let promises = []
      for (let index = 0; index < this.transportCalls.length; index++) {
        promises.push(
          // Consulta API eventPlanning
          this.getEventPlanning(this.transportCalls[index].voyageID)
          .then(response => {
            this.updateEventPlanning(response.data, index)
          }).catch(() => {})
        )
      }
      Promise.all(promises)
      .then(() => {
        this.setTransportCallPlacementState()
      })
      .catch(() => {
        this.setTransportCallPlacementState()
      })
    },
    setTransportCallPlacementState(){
      this.transportCallsInAcceptance = []
      this.transportCallsInPreparation = []
      this.transportCallsInOperation = []
      this.transportCallsInCompletion = []

      this.transportCalls.forEach(tpCall => {
        var tpCallAcceptance = this.getTranportCallAcceptanceById(tpCall)
        var otherAcceptance = this.getOtherMaritimeAgencyAcceptanceById(tpCall.voyageID)
        if (this.$store.state.profile == 'PortFacilities'){
          otherAcceptance = 'Accepted'
        }
        if (tpCallAcceptance == "Accepted" && otherAcceptance == 'Accepted' && tpCall.events.berthDeparture == this.ACTUAL && tpCall.events.berthDeparture == this.ACTUAL){
          // Finalizadas & berthDeparture events: 1=ETD 2=RTD 3=PTD 4=ATD
          tpCall.voyageStatus = i18n.t('mixinsKanban.statusCompleted')
          this.transportCallsInCompletion.push(tpCall)
        }else if (tpCallAcceptance == "Accepted" && otherAcceptance == 'Accepted' && tpCall.events.pilotBoardingPlace >= this.PLANNED){
          // Em Operação & pilotBoardingPlace events: 1=ETA 2=RTA 3=PTA 4=ATA 
          tpCall.voyageStatus = i18n.t('mixinsKanban.statusOperation')
          this.transportCallsInOperation.push(tpCall)
        }else if (otherAcceptance == 'Accepted' && tpCallAcceptance == "Accepted" ){
          // Em Planejamento
          tpCall.voyageStatus = i18n.t('mixinsKanban.statusPlanning')
          this.transportCallsInPreparation.push(tpCall)
        }else if (tpCallAcceptance != 'Refused'){
          // Em Nomeações
          tpCall.voyageStatus = i18n.t('mixinsKanban.statusNomination')
          this.transportCallsInAcceptance.push(tpCall)
        } 
      });
    },
    /**
     * 
     * @param {*} tpCall item do array this.transportCalls
     * @returns valor de acceptance
     */
    getTranportCallAcceptanceById(tpCall){
      if (this.transportCallAcceptances[tpCall.voyageID] && this.transportCallAcceptances[tpCall.voyageID][tpCall.transportCallID]){
        return this.transportCallAcceptances[tpCall.voyageID][tpCall.transportCallID].acceptance
      }
      return null;
    },
    /**
     * 
     * @param {*} voyageID 
     * @returns 
     */
    getOtherMaritimeAgencyAcceptanceById(voyageID){
      if (this.otherMaritimeAgencyAcceptances[voyageID]){
        return this.otherMaritimeAgencyAcceptances[voyageID].acceptance;
      }
      return null;
    }

  },
  mixins: [apisMixin],
  data (){
    return {
      voyages: null,
      voyageAcceptances: null,
      ESTIMATED: 1, // ETA, ETB, ETD
      REQUESTED: 2, // RTA, RTB, RTD
      PLANNED: 3,   // PTA, PTB, PTD
      ACTUAL: 4,    // ATA, ATB, ATD
    }
  }
}
export default kanbanMixin;