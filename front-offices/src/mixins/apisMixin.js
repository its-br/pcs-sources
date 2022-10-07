import axios from 'axios'
import {api} from '@/helpers/apis';
import i18n from '@/plugins/i18n'

/**
 * 
 * @returns Array com todas as Viagens
 */
const apisMixin = {
  methods:{
    getVoyages(){    
      axios.get(api.VOYAGES)
      .then(response => {
        if (response.status == 200){
          this.voyages = response.data
        }else{
          console.error(response.data);
        }
      })
      .catch(error => {
        console.error(error);
      })
    },
    /**
     * Consulta todas as aceitações na API /voyage-acceptance 
     * As aceitações são gravadas na variável acceptances 
     */
    getAcceptances(){
      axios.get(api.VOYAGES_ACCEPTANCE)
      .then(response => {
        if (response.status == 200){
          this.voyageAcceptances = response.data
        }else{
          console.error(response.data);
        }
      })
      .catch(error => {
        console.error(error);
      })
    },
    /**
     * Consulta o EventPlanning
     * @param {*} PCSVoyageID Campo PCSVoyageID ou receiptID
     * @return Promise: callback then return the response of API event-planning
     */
    getEventPlanning(PCSVoyageID){
      return new Promise(((resolve, reject) => {
        axios
        .get(api.EVENT_PLANNING + "/" + PCSVoyageID )
        .then(response => {
          if (response.status == 200){
            resolve(response)
          }else{
            console.error(response.data);
          }
        })
        .catch(error => {
          console.error(error);
          reject('')
        })
      }));
    },
    /**
     * Realiza o post para VOYAGE_ACCEPTANCE, caso de sucesso chama a função updateKanban
     * @param {*} requestData: {
     *    PCSVoyageID|receiptID: string
     *    cnpj* :	string
     *    acceptance: [ Accepted, Refused ]
     *    transportCallID: $uuid
     *    statusCode* : [ T001, T002, A000, A001, A002, A003 ]
     *    responsabilityCode: [ 000, 100, 200, 300 ]
     * }
     */
    postAcceptance(requestData){
       axios.post(api.VOYAGE_ACCEPTANCE, requestData)
       .then(response => {
         if (response.status == 200 || response.status == 201){
           this.refreshKanban();
         }else{
           console.error(response);
         }
       })
       .catch(error => {
         console.error(error);
       })
    },
  },
  data (){
    return {
      voyages: null,
      voyageAcceptances: null,
    }
  }
}
export default apisMixin;