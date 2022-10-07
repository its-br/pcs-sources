<template>
<div>
    <!--TIMELINE-->
    <v-timeline>
      <v-timeline-item :color="event_color"  >
        <span class="caption font-weight-bold pt-2">{{event_title}}</span>
        <br>
        <v-icon small>mdi-alarm</v-icon><span class="caption ml-1">{{event_planned_time}}</span>
        <v-icon small class="ml-2" v-if="event_show_cards==false">mdi-calendar</v-icon><span class="caption ml-1" v-if="event_show_cards==false">{{event_planned_date}}</span>
        <v-icon color="primary"  class="ml-2"  v-if="event_show_cards==false && this.show_action_button==true"  @click="exec_action" >mdi-adjust</v-icon>
        <br>  
        <v-icon v-if="event_show_cards==false && this.show_actual_time==true" small >mdi-alarm-check</v-icon>
        <span v-if="event_show_cards==false && this.show_actual_time==true" class="caption ml-1">{{event_planned_time}}</span>
        <v-icon v-if="event_show_cards==false && this.show_actual_time==true"  small  class="ml-2">mdi-calendar</v-icon>
        <span v-if="event_show_cards==false && this.show_actual_time==true"  class="caption ml-1">{{event_planned_date}}</span>
      </v-timeline-item>
    </v-timeline>
    <!--CARD EVENTO-->
    <v-card min-width="272" max-width="768" min-height="150" class="mx-auto"  v-show="event_show_cards">
        <v-card-text>
            <span class="grey--text caption mr-3">{{this.$t('EventPlanning.Situation')}}:</span>
            <span class="text-black font-weight-medium mb-5">{{event_status}}</span>
            <p class="text-right mb-n2"><span class="text-black font-weight-medium mb-5">{{event_inner_title}}</span></p>
            <v-tooltip top>
            <template v-slot:activator="{ on, attrs }">
            <span class="grey--text caption mr-4" v-bind="attrs" v-on="on">{{event_estimated_label}}</span>
            </template>
            <span>{{this.get_event_label_description(event_estimated_label)}}</span>
            </v-tooltip>
            <v-icon small>mdi-alarm</v-icon><span class="ml-1">{{event_estimated_time}}</span>
            <v-icon small class="ml-2">mdi-calendar</v-icon><span class="ml-1">{{event_estimated_date}}</span>
            <br>
            <v-tooltip top>
            <template v-slot:activator="{ on, attrs }">
            <span class="grey--text caption mr-4" v-bind="attrs" v-on="on">{{event_required_label}}</span>
            </template>
            <span>{{this.get_event_label_description(event_required_label)}}</span>
            </v-tooltip>
            <v-icon small>mdi-alarm</v-icon><span class="ml-1">{{event_required_time}}</span>
            <v-icon small class="ml-2">mdi-calendar</v-icon><span class="ml-1">{{event_required_date}}</span>
            <br>
            <v-tooltip top>
            <template v-slot:activator="{ on, attrs }">
            <span class="grey--text caption mr-4" v-bind="attrs" v-on="on">{{event_planned_label}}</span>
             </template>
            <span>{{this.get_event_label_description(event_planned_label)}}</span>
            </v-tooltip>
            <v-icon small>mdi-alarm</v-icon><span class="ml-1">{{event_planned_time}}</span>
            <v-icon small class="ml-2">mdi-calendar</v-icon><span class="ml-1">{{event_planned_date}}</span>
            <br>
            <v-tooltip top>
            <template v-slot:activator="{ on, attrs }">
            <span class="grey--text caption mr-4" v-bind="attrs" v-on="on">{{event_actual_label}}</span>
             </template>
            <span>{{this.get_event_label_description(event_actual_label)}}</span>
            </v-tooltip>
            <v-icon small>mdi-alarm</v-icon><span class="ml-1">{{event_actual_time}}</span>
            <v-icon small class="ml-2">mdi-calendar</v-icon><span class="ml-1">{{event_actual_date}}</span>
            <br>
            <v-card-actions class="my-n4">
                <v-spacer></v-spacer>
                <v-btn  v-show="show_action_button" text color="primary" @click="exec_action">{{event_action_text}}</v-btn>
            </v-card-actions>    
        </v-card-text>
    </v-card>
    <!--DIALOG 1 INFORMAR HORÁRIO-->
    <v-dialog v-model="dialog1" min-width="272" max-width="768" persistent>
      <v-card>
        <!--Componentes principais-->
        <v-card-title class="text-h6 grey lighten-2">
          {{this.$t('EventPlanning.dialog1_title')}}
        </v-card-title>
        <v-card-text class="my-2" v-if="dialog_component==1">
            <v-form>
                <v-chip-group>
                    <v-text-field outlined :label="this.$t('EventPlanning.dialogTime')" type="text" name="dialog_picked_time" v-model="dialog_picked_time" 
                    v-mask="'##:##'" :error-messages="this.validation_errors['dialog_picked_time']" 
                    @input="validate_field_on_change($event)">
                    </v-text-field>
                    <v-btn class="mx-2 my-2" fab dark small color="primary" @click="dialog_component=2">
                    <v-icon dark>mdi-alarm</v-icon>
                    </v-btn>
                </v-chip-group>
                <v-chip-group>
                    <v-text-field outlined :label="this.$t('EventPlanning.dialogDate')" type="text" name="dialog_picked_date" v-model="dialog_picked_date" 
                    v-mask="'##-##-####'" :error-messages="this.validation_errors['dialog_picked_date']" 
                    @input="validate_field_on_change($event)">
                    </v-text-field>
                     <v-btn class="mx-2 my-2" fab dark small color="primary" @click="dialog_component=3">
                    <v-icon dark>mdi-calendar</v-icon>
                    </v-btn>
                </v-chip-group>
            </v-form>
            <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" text @click="confirm_dialog1">{{this.$t('EventPlanning.buttonConfirm')}}</v-btn>
            <v-btn text @click="hide_event_time_dialog">{{this.$t('EventPlanning.buttonCancel')}}</v-btn>
            </v-card-actions>
        </v-card-text>
        <!--Componente time picker -->
        <v-card-text class="my-2 text-center" v-if="dialog_component==2">
            <v-row >
                <v-col cols="12" md="6">
                    <v-time-picker format="24hr" v-model="time_picker"></v-time-picker>
                </v-col>
                <v-col cols="12" md="6">
                    <v-btn text color="primary" @click="set_picked_time">{{this.$t('EventPlanning.buttonSet')}}</v-btn>
                    <v-btn text color="primary" @click="dialog_component=1">{{this.$t('EventPlanning.buttonCancel')}}</v-btn>
                </v-col>
            </v-row>
        </v-card-text>
        <!--Componente date picker -->
        <v-card-text class="my-2 text-center" v-if="dialog_component==3">
            <v-row>
                <v-col cols="12" md="6">
                    <v-date-picker v-model="date_picker" :locale="this.$root.$i18n.locale" ></v-date-picker>
                </v-col>
                <v-col cols="12" md="6">
                    <v-btn text color="primary" @click="set_picked_date">{{this.$t('EventPlanning.buttonSet')}}</v-btn>
                    <v-btn text color="primary" @click="dialog_component=1">{{this.$t('EventPlanning.buttonCancel')}}</v-btn>
                </v-col>
            </v-row>
            
        </v-card-text>
        <v-spacer></v-spacer>
      </v-card>
    </v-dialog>
    <!--DIALOG 2 HORÁRIO PENDENTE-->
    <v-dialog v-model="dialog2" width="500">
      <v-card>
        <v-card-title class="text-h6 grey lighten-2">
          {{dialog2_title}}
        </v-card-title>
        <v-card-text class="my-2">
            {{dialog2_subtitle}}
            <br><br>
            <span class="caption">{{this.$t('EventPlanning.dialogEstimatedTime')}}:</span>
            <br>
            <v-icon small>mdi-alarm</v-icon><span class="ml-1">{{dialog2_est_time}}</span>
            <v-icon small class="ml-2">mdi-calendar</v-icon><span class="ml-1">{{dialog2_est_date}}</span>
            <br><br>
            <span class="caption">{{this.$t('EventPlanning.dialogRequestedTime')}}:</span>
            <br> 
            <v-icon small>mdi-alarm</v-icon><span class="ml-1">{{dialog2_req_time}}</span>
            <v-icon small class="ml-2">mdi-calendar</v-icon><span class="ml-1">{{dialog2_req_date}}</span>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="success" text @click="accept_suggested">{{this.$t('EventPlanning.buttonAccept')}}</v-btn>
          <v-btn color="primary" text @click="show_event_time_dialog">{{this.$t('EventPlanning.buttonSuggest')}}</v-btn>
          <v-btn color="primary" text @click="hide_event_pending_dialog">{{this.$t('EventPlanning.buttonCancel')}}</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>


</div>
</template>

<script>
import Vue from 'vue';
import VueMask from 'v-mask';
Vue.use(VueMask);
import validationCardEvent from '@/mixins/validationCardEvent'
import {getPortFacilitiesEventStates} from '@/helpers/PortFacilitiesEventStates'
import {getMaritimeAgentEventStates} from '@/helpers/MaritimeAgentEventStates'
import {getPortAuthorityEventStates} from '@/helpers/PortAuthorityEventStates'
import {getHarborPilot} from '@/helpers/HarborPilot'

export default {
    name: "CardEvent",
    props: {
        event_card_type: {type: Number, default: 1},
        event_show_cards: {type: Boolean, default: true},
    },
    data () {
        return{
            event_state_code: 0, 
            event_title: "",
            event_inner_title: "",
            event_color: "yellow",
            event_status: this.$t('EventPlanning.title_WaitingforData'),
            event_estimated_label: "ET",
            event_estimated_time: "-",
            event_estimated_date: "-",
            event_required_label: "RT",
            event_required_time: "-",
            event_required_date: "-",
            event_planned_label: "PT",
            event_planned_time: "-",
            event_planned_date: "-",
            event_actual_label: "AT",        
            event_actual_time: "-",
            event_actual_date: "-",        
            event_action_text: "-",
            dialog_type: 1,
            dialog1: false,
            dialog1_title: this.$t('EventPlanning.title_InformTime') ,
            dialog1_main_button: "CONFIRMAR",
            dialog_picked_time:null,
            dialog_picked_date: null,
            dialog2: false,
            dialog2_title: this.$t('EventPlanning.title_PendingTime'),
            dialog2_subtitle: "",
            dialog2_est_date:"",
            dialog2_est_time:"",
            dialog2_req_date:"",
            dialog2_req_time:"",
            dialog_component: 1,
            time_picker: null,
            date_picker: null,
            show_action_button: false,
            show_estimated_time: true,
            show_required_time: true,
            show_planned_time: true,            
            show_actual_time: false,
            profile_config: null,
            card_state_config: null,
            validation_errors: []
        }
    },
    mounted () {
        this.load_profile_config()
        this.set_card_state_config()
        this.set_event_title()
        this.set_event_datetime_labels()
        this.update_event_card()
    },
    methods: {
        getMaritimeAgentEventStates,
        getPortFacilitiesEventStates,
        getPortAuthorityEventStates,
        getHarborPilot,
        load_profile_config(){
            // Carrega as configurações para a montagem dos cards/eventos
            // de acordo com o perfil do ator (executada uma vez no evento mounted)
            // as configurações estão salvas em um arquivo para cada perfil
            switch(this.$store.state.profile)
            {
                case "MaritimeAgent":
                    this.profile_config = this.getMaritimeAgentEventStates()
                    break;
                case "PortFacilities":
                    this.profile_config = this.getPortFacilitiesEventStates()
                    break;
                case "PortAuthority":
                    this.profile_config = this.getPortAuthorityEventStates()
                    break;
                case "HarborPilot":
                    this.profile_config = this.getHarborPilot()
                    break;
                default:
                    this.profile_config = this.getMaritimeAgentEventStates()
            }
        },
        set_card_state_config(){
            // Define o conjunto de configuração de acordo com o tipo de card
            // No objeto retornado, há a definição de propriedades para o card
            // de acordo com as possíveis situações (0,1,2,3,4)
            switch(this.event_card_type) {
                case 1:
                    this.card_state_config = this.profile_config.card1
                    break;
                case 2:
                    this.card_state_config = this.profile_config.card2
                    break;
                case 3:
                    this.card_state_config = this.profile_config.card3
                    break;
                case 4:
                    this.card_state_config = this.profile_config.card4
                    break;
                case 5:
                    this.card_state_config = this.profile_config.card5
                    break;
                default:
                    this.card_state_config = this.profile_config.card1
            }

           
        },
        set_event_title(){
            // Define os títulos do card e da linha do tempo
            // de acordo com o tipo do card 
            switch(this.event_card_type) {
            case 1:
                this.event_title = this.$t('EventPlanning.event_title_PilotBoardingPlace')
                this.event_inner_title = "PILOT BOARDING PLACE"
                break;
            case 2:
                this.event_title = this.$t('EventPlanning.event_title_BerthArrival')
                this.event_inner_title = "BERTH ARRIVAL"
                break;
            case 3:
                this.event_title = this.$t('EventPlanning.event_title_StartCargoOperations')
                this.event_inner_title = "START CARGO OPERATIONS"
                break;
            case 4:
                this.event_title = this.$t('EventPlanning.event_title_CargoCompletion')
                this.event_inner_title = "CARGO COMPLETION"
                break;
            case 5:
                this.event_title = this.$t('EventPlanning.event_title_BerthDeparture')
                this.event_inner_title = "BERTH DEPARTURE"
                break;
            default:
                this.event_title = ""
            }
        },
        set_event_datetime_labels(){
            // Define os rótulos de horários no card
            // de acordo com o tipo de card
            switch(this.event_card_type) {
            case 1:
                this.event_estimated_label = "ETA"
                this.event_required_label = "RTA"
                this.event_planned_label = "PTA"
                this.event_actual_label = "ATA"
                break;
            case 2:
                this.event_estimated_label = "ETA"
                this.event_required_label = "RTA"
                this.event_planned_label = "PTA"
                this.event_actual_label = "ATA"
                break;
            case 3:
                this.event_estimated_label = "ETS"
                this.event_required_label = "RTS"
                this.event_planned_label = "PTS"
                this.event_actual_label = "ATS"
                break;
            case 4:
                this.event_estimated_label = "ETC"
                this.event_required_label = "RTC"
                this.event_planned_label = "PTC"
                this.event_actual_label = "ATC"
                break;
            case 5:
                this.event_estimated_label = "ETD"
                this.event_required_label = "RTD"
                this.event_planned_label = "PTD"
                this.event_actual_label = "ATD"
                break;
            default:
                this.event_estimated_label = "ETA"
                this.event_required_label = "RTA"
                this.event_planned_label = "PTA"
                this.event_actual_label = "ATA"
            }
        },
        update_event_card(){
            // Atualiza o card de acordo com a situação corrente
            // As propriedades são definidas a partir do conjunto de configurações do card
            // carregado do arquivo de configurações do perfil
            // A função é executada quando há alteração dos horários para o card
            this.event_color = this.card_state_config[this.event_state_code].event_color
            this.event_status = this.card_state_config[this.event_state_code].event_status
            this.event_action_text = this.card_state_config[this.event_state_code].event_action_text
            this.show_action_button = this.card_state_config[this.event_state_code].show_action_button
            this.dialog_type = this.card_state_config[this.event_state_code].dialog_type
            this.dialog_change = this.card_state_config[this.event_state_code].dialog_change
            this.dialog2_title = this.card_state_config[this.event_state_code].dialog2_title
            this.dialog2_subtitle = this.card_state_config[this.event_state_code].dialog2_subtitle
        },
        exec_action(){
            // Dispara ação para exibir um dos diálogos:
            // edição de horário (dialog 1) ou horário pendente (dialog 2)
            if (this.dialog_type === 1){
            this.show_event_time_dialog()
            }else{
            this.show_event_pending_dialog()
            }
            this.update_event_card()
        },
        show_event_time_dialog(){
            // Exibe o diálogo de edição de horário conforme o estado do evento.
            // Permite também que os campos do diálogo iniciem com o horário relacionado para edição.
            // De acordo com o perfil do ator:
            // Define regras para preencher a data e horário quando o dialog 1 for inicialmente exibido.
            // São considerados apenas os códigos que indicam botão de ação para o dialog 1.
            // A constante card_state é a concatenação do número do card e o código atual do estado do evento
            // Exemplo: card 1 (Pilot Boarding Place) + estado 0 = '10'
            //
            // Combina o tipo do card com a situação corrente
            const card_state = this.event_card_type.toString() + this.event_state_code.toString()
            // Inicializa as regras para cada ator
            var CUR_rules = null // p/ iniciar com o horário corrente
            var EST_rules = null // p/ inicial com o horário estimado
            var REQ_rules = null // p/ iniciar com o horário requisitado
            var ACT_rules = null // p/ inicial com o horário real
            // PortAuthority
             if (this.$store.state.profile == "PortAuthority")
            {
                CUR_rules = ["11"]
                EST_rules = []
                REQ_rules = ["12"]
                ACT_rules = []
            }
            // MaritimeAgent
            if (this.$store.state.profile == "MaritimeAgent")
            {
                CUR_rules = ["10","20","41","51"]
                EST_rules = ["11","12","13","21","22","23"]
                REQ_rules = ["42","52"]
                ACT_rules = ["14","24"]
            }
            // PortFacilities
            if (this.$store.state.profile == "PortFacilities")
            {
                CUR_rules = ["21","30","40","50"]
                EST_rules = ["41","42","43","51","52","53"]
                REQ_rules = ["22"]
                ACT_rules = ["34","44","54"]
            }
            // HarborPilot
            if (this.$store.state.profile =="HarborPilot")
            {
                CUR_rules = []
                EST_rules = []
                REQ_rules = []
                ACT_rules = []
            }
            // Aplica regras de acordo com o ator e a situação do evento.
            // Se a situação é encontrada no array, define o horário de acordo para o componente.
            if (CUR_rules.includes(card_state))
            {
                this.set_dialog_initial_current_datetime()
            }
            if (EST_rules.includes(card_state))
            {
                this.set_dialog_initial_datetime_as_est()
            }
            if (REQ_rules.includes(card_state))
            {
                this.set_dialog_initial_datetime_as_req()
            }
            if (ACT_rules.includes(card_state))
            {
                this.set_dialog_initial_datetime_as_act()
            }
            // Faz a alteração no componente dialog 1
            this.dialog1 = true // Exibe o diálogo de edição
            this.dialog2 = false // Esconde o diálogo de horário pendente, se exibido 
        },
        set_dialog_initial_datetime_as_est(date,time){
            // Define a data e horário estimado na inicialização do componente dialog 1
            this.dialog_picked_time = this.event_estimated_time
            this.dialog_picked_date = this.event_estimated_date 
        },
        set_dialog_initial_datetime_as_req(date,time){
            // Define a data e horário requisitado na inicialização do componente dialog 1
            this.dialog_picked_time = this.event_required_time
            this.dialog_picked_date = this.event_required_date 
        },
        set_dialog_initial_datetime_as_act(date,time){
            // Define a data e horário real na inicialização do componente dialog 1
            this.dialog_picked_time = this.event_actual_time
            this.dialog_picked_date = this.event_actual_date 
        },
        set_dialog_initial_current_datetime(){
        // Define a data e horário atual na inicialização do componente dialog 1
        // Usado quando nenhum horário foi informado
            var d = new Date()
            var current_date = new Date(d.getTime() - (180*60000))
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
            this.dialog_picked_time = hours + ":" + minutes
            this.dialog_picked_date = day + "-" + month + "-" + year 
      },
        hide_event_time_dialog(){
            this.dialog1 = false
        },
        show_event_pending_dialog(){
            // Exibe o diálogo de horário pendente
            // Preenche o horário informado e sugerido para o diálogo
            // Usa o horário estimado e requerido
            this.dialog2_est_time = this.event_estimated_time
            this.dialog2_est_date = this.event_estimated_date
            this.dialog2_req_time = this.event_required_time
            this.dialog2_req_date = this.event_required_date
            // exibe o diálogo
            this.dialog2 = true
        },
        hide_event_pending_dialog(){
            this.dialog2 = false
        },
        set_picked_time(){
            // Define o horário selecionado no componente
            if (this.time_picker != null)
            {
                this.dialog_picked_time = this.time_picker
                this.dialog_component = 1
            }else{
                // Nenhum horário selecionado
                this.dialog_picked_time = "00:00"
                this.dialog_component = 1
            }
        },
        set_picked_date(){
            // Define a data selecionada no componente
            // Também converte a data selecionada para exibição '00-00-0000'
            if (this.date_picker != null)
            {
                this.dialog_picked_date = this.ymd2dmy(this.date_picker)
                this.dialog_component = 1
            }else{
                // Nenhuma data selecionada:
                // define a data atual
                var d = new Date()
                var current_date = new Date(d.getTime() - (180*60000))
                var year = current_date.getUTCFullYear()
                var month = (current_date.getUTCMonth() + 1).toString()
                var day = current_date.getUTCDate().toString()
                if (month.length < 2){month = "0"+ month;}         
                if (day.length < 2){day = "0"+ day;}
                this.dialog_picked_date = day + "-" + month + "-" + year
                this.dialog_component = 1
            }
        },
        ymd2dmy(str_date){
            // Converte o formato de data de '0000-00-00' para '00-00-0000'
            // Utilizada para converter a saída do componente e exibir a data escolhida nos diálogos
            var date_parts = str_date.split('-')
            const date = date_parts[2] + "-" + date_parts[1] + "-" + date_parts[0] 
            return date
        },
        confirm_dialog1(){
            // Confirma a alteração de data e horário do evento a partir do diálogo 1.
            // Função executada quando o botão do diálogo é pressionado para definir o horário.
            //
            // As regras de validação dos campos ficam em um arquivo na pasta mixins
            this.validate_dialog1_datetime_fields()
            if (this.validation_errors.IsValid == true)
            {
                // Reúne os argumentos necessários para a geração dos dados do post 
                // no componente TimelineEvents
                const event_info = {
                    event_card_type: this.event_card_type,
                    event_state_code: this.event_state_code, 
                    event_date: this.dialog_picked_date,
                    event_time: this.dialog_picked_time,
                    profile: this.$store.state.profile,
                }
                // esconde o diálogo
                this.hide_event_time_dialog()
                // emite o evento para a função do componente TimelineEvents de envio da alteração 
                // com os argumentos requeridos 
                this.$emit("update_event",event_info)
            }
        },
        accept_suggested(){
            // Confirma a alteração de data e horário do evento a partir do diálogo 2,
            // aceitando o horário sugerido (botão aceitar)
            var date = null 
            var time = null 
            // Define qual horário aceitar de acordo com o ator e o evento
            if (this.$store.state.profile == "PortAuthority")
            {
                switch (this.event_card_type)
                {
                    case 1:
                    date = this.event_estimated_date
                    time = this.event_estimated_time 
                    break;
                }
            }
            if (this.$store.state.profile == "MaritimeAgent")
            {
                switch (this.event_card_type)
                {
                    case 1:
                    date = this.event_required_date
                    time = this.event_required_time 
                    break;
                    case 2:
                    date = this.event_required_date
                    time = this.event_required_time 
                    break; 
                    case 4:
                    date = this.event_estimated_date
                    time = this.event_estimated_time 
                    break;
                    case 5:
                    date = this.event_estimated_date
                    time = this.event_estimated_time 
                    break;
                }
            }
            if (this.$store.state.profile == "PortFacilities")
            {
                switch (this.event_card_type)
                {
                    case 2:
                    date = this.event_estimated_date
                    time = this.event_estimated_time 
                    break
                    case 4:
                    date = this.event_required_date
                    time = this.event_required_time 
                    break;
                    case 5:
                    date = this.event_required_date
                    time = this.event_required_time 
                    break; 
                }
            }
            // Reúne os argumentos necessários para a geração dos dados do post no componente TimelineEvents
            const event_info = {
                event_card_type: this.event_card_type,
                event_state_code: this.event_state_code, 
                event_date: date,
                event_time: time,
                profile: this.$store.state.profile,
            }
             // esconde o diálogo
            this.hide_event_pending_dialog()
            // emite o evento para a função do componente pai de envio da alteração com os argumentos requeridos 
            this.$emit("update_event",event_info)
        },
        clear_date_time(){
            // Limpa todos os valores de data e horário.
            this.event_estimated_time = "-"
            this.event_required_time = "-"
            this.event_planned_time = "-"
            this.event_actual_time = "-"
            this.event_estimated_date = "-"
            this.event_required_date = "-"
            this.event_planned_date = "-"
            this.event_actual_date = "-"
        },
        set_event_state_code(code){
            // Define o código atual do evento (Ex.: P004)
            // É chamada pelo componente pai para atualizar a exibição do card
            // conforme a definição do código pelo filtro dos eventos do get  
            this.event_state_code = code
            this.update_event_card()
        },
        set_estimated_datetime(str_date,str_time){
            // Define o horário e data no card (EST)
            // É chamada pelo componente pai após filtro dos eventos
            this.event_estimated_date = str_date 
            this.event_estimated_time = str_time 
        },
        set_required_datetime(str_date,str_time){
            // Define o horário e data no card (REQ)
            // É chamada pelo componente pai após filtro dos eventos
            this.event_required_date = str_date 
            this.event_required_time = str_time 
        }, 
        set_planned_datetime(str_date,str_time){
            // Define o horário e data no card (PLN)
            // É chamada pelo componente pai após filtro dos eventos
            this.event_planned_date = str_date 
            this.event_planned_time = str_time 
        },
        set_actual_datetime(str_date,str_time){
            // Define o horário e data no card (ACT)
            // É chamada pelo componente pai após filtro dos eventos
            this.event_actual_date = str_date 
            this.event_actual_time = str_time 
        },
        set_actual_datetime_for_StartCargoOperations(str_date,str_time){
            // Define o horário e data no card (EST)
            // É chamada pelo componente pai após filtro dos eventos
            // Específica para o evento de Início de carga/descarga
            this.event_actual_date = str_date 
            this.event_actual_time = str_time 
            this.event_planned_time = str_time
            this.event_planned_date = str_date 
        },
        validate_field_on_change(e) {
            // Realiza a validação quando o campo é alterado
            this.validate_dialog1_datetime_fields()
        },
        validate_dialog1_datetime_fields(){
            // Realiza a validação dos campos de horário e data
            // no componente dialog1 
            // As regras de validação estão em arquivo na pasta mixins
            const fields = {
                dialog_picked_date: this.dialog_picked_date,
                dialog_picked_time: this.dialog_picked_time
            }
            this.validation_errors = this.validateFields(fields)
        },
        get_event_label_description(event_label){
            var description = ""
            switch(event_label)
            {
                case "ETA":
                description = "Estimated Time of Arrival"
                break;
                case "RTA":
                description = "Requested Time of Arrival"
                break;
                case "PTA":
                description = "Planned Time of Arrival"
                break;
                case "ATA":
                description = "Actual Time of Arrival"
                break;
                case "ETD":
                description = "Estimated Time of Departure"
                break;
                case "RTD":
                description = "Requested Time of Departure"
                break;
                case "PTD":
                description = "Planned Time of Departure"
                break;
                case "ATD":
                description = "Actual Time of Departure"
                break;
                case "ETS":
                description = "Estimated Time of Start"
                break;
                case "RTS":
                description = "Requested Time of Start"
                break;
                case "PTS":
                description = "Planned Time of Start"
                break;
                case "ATS":
                description = "Actual Tie of Start"
                break;
                case "ETC":
                description = "Estimated Time of Completion"
                break;
                case "RTC":
                description = "Requested Time of Completion"
                break;
                case "PTC":
                description = "Planned Time of Completion"
                break;
                case "ATC":
                description = "Actual Time of Completion"
                break;
            }
            return description
        }
    },
    mixins: [validationCardEvent] 
}
</script>

<style>
.datetime-picker  {
  width: 150px;
  height: 38px;
}
</style>