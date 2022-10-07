<template>
  <v-layout align-center justify-center>
    <v-col cols="9" sm="9" lg="9">
      <v-card light>
        <v-card-title class="text-h5">{{$t('voyageCreation')}}</v-card-title>
        <v-stepper v-model="e1">
          <v-stepper-header>
            <v-stepper-step :complete="e1 > 1" :editable="e1 > 1" step="1">{{$t('step')}} 1</v-stepper-step>
            <v-divider></v-divider>
            <v-stepper-step :complete="e1 > 2" :editable="e1 > 2" step="2">{{$t('step')}} 2</v-stepper-step>
            <v-divider></v-divider>
            <v-stepper-step :complete="e1 > 3" :editable="e1 > 3" step="3">{{$t('step')}} 3</v-stepper-step>
            <v-divider></v-divider>
            <v-stepper-step step="4">{{$t('step')}} 4</v-stepper-step>
          </v-stepper-header>

          <v-stepper-items>
            <v-stepper-content step="1">
              <StepOne ref="stepOne">
              </StepOne>
              <v-chip-group>
              <v-btn color="primary" @click="next1" class="mr-1">{{$t('continue')}}</v-btn>
              <v-btn text class="ml-2">{{$t('cancel')}}</v-btn>
              </v-chip-group>
            </v-stepper-content>

            <v-stepper-content step="2">
              <StepTwo ref="steptwo"
              ></StepTwo>
              <v-btn  color="primary" @click="next2" >{{$t('continue')}}</v-btn>
              <v-btn text class="ml-2">{{$t('cancel')}}</v-btn>
            </v-stepper-content>

            <v-stepper-content step="3">
              <StepThree></StepThree>
              <v-btn  color="primary" @click="next3" >{{$t('continue')}}</v-btn>
              <v-btn text class="ml-2">{{$t('cancel')}}</v-btn>
            </v-stepper-content>

            <v-stepper-content step="4">
              <StepFour ref="stepfour"
              @click_step1="e1=1"
              @click_step2="e1=2"
              @click_step3="e1=3"
              >
              </StepFour>
              <v-card class="mb-12" color="grey lighten-1"></v-card>
              <div class="mb-4">
              <span class="body-2">{{this.$t('VoyageCreation.Confirm')}}</span>
              </div>
              <v-btn color="primary" @click="confirm">{{this.$t('VoyageCreation.buttonConfirm')}}</v-btn>
              <v-btn text class="ml-2">{{$t('cancel')}}</v-btn>
            </v-stepper-content>
          </v-stepper-items>
        </v-stepper>
      </v-card>
      <v-dialog
      v-model="dialog"
      persistent
      max-width="290"
    >
      <v-card>
        <v-card-title class="text-h5">
          {{dialog_title}}
        </v-card-title>
        <v-card-text>{{dialog_text}}</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            text
            @click="close_dialog"
          >
            {{$t('VoyageCreation.buttonClose')}}
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    </v-col>


    
    
    

  </v-layout>
</template>

<script>
import axios from 'axios';
import {api} from '@/helpers/apis';
import AppFooter from '@/components/AppFooter.vue'
import AppNavbar from '@/components/AppNavbar.vue'
import StepOne from './StepOne.vue'
import StepTwo from './StepTwo.vue'
import StepThree from './StepThree.vue'
import StepFour from './StepFour.vue'
  
  export default {
    name: 'VoyageCreation',
    data () {
      return {
        e1: 1,
        dialog: false,
        dialog_title: "Informação",
        dialog_text: "A viagem foi criada com sucesso!",
        dialog_type: 1
      }
    },
    components :{
      StepOne,
      StepTwo,
      StepThree,
      StepFour,
      AppFooter,
      AppNavbar
    },
    methods : {
      next1(){
        if (this.$refs.stepOne.save_state()){ 
          this.e1 = 2
        }
      },
      next2(){
        if (this.$store.state.step2.length >=1){
            this.e1 = 3
        }
      },
      next3(){
        if (this.$store.state.step3.length >=1){
          this.$refs.stepfour.print_update()
          this.e1 = 4
        }
      },
      unmask_cnpj(cnpj){
        return parseInt(cnpj.replace(/[^0-9]/g,''))
      },
      confirm(){
        var transportcalls = []
        this.$store.state.step2.map((tc) => {
          transportcalls.push(
            {
              transportCallID: tc.tcall_id,
              portFacilityTypeDcsaCode: "POTE",
              portFacilityCnpj: this.unmask_cnpj(tc.port_facility) + "",
              mooringOperatorCnpj: this.unmask_cnpj(tc.mooring_operator) + "",
              tugboatCompanyCnpj: this.unmask_cnpj(tc.tug_operator) + ""
            }
          );
        });

        var maritimeagencies = []
        this.$store.state.step3.map((ma) => {
            maritimeagencies.push(
                {
                maritimeAgencyCnpj: this.unmask_cnpj(ma.maritime_agency_id) + "",
                responsabilityCode: ma.responsability_code,
                }
            );
        });

        const voyage ={
          // cnpj: this.unmask_cnpj(this.$store.state.step1.maritime_agent_cnpj)+"",
          carrierDetails: {
            listProvider: this.$store.state.step1.list_provier,
            carrierCode:  this.$store.state.step1.carrier_code
          },
          carrierVoyageDetails: {
            carrierVoyageNumber: this.$store.state.step1.carrier_voyage_number,
            vesselIMO: this.$store.state.step1.vessel_imo,
            UNLocationCode: this.$store.state.step1.un_location_code
          },
          // transportCallQty: this.$store.state.step2.length,
          transportCall: transportcalls,
          otherMaritimeAgency: maritimeagencies,
          maritimeAgencyCallBack: {
            callBackURL: 'https://localhost',
            startDate: '2022-01-01',
            rangeDate: 'P4W'
          }
        }
        axios.post(api.VOYAGE_CREATION, voyage)
        .then(response => {
          if (response.status == 200 || response.status == 201){
            this.show_success_dialog()
          }else{
            console.error(response.data);
          }
        })
        .catch(error => {
          console.error(error);
          this.show_error_dialog()
        })
      },
      show_success_dialog(){
        this.dialog_title = this.$t('VoyageCreation.dialog_title_success')
        this.dialog_text = this.$t('VoyageCreation.dialog_text_success')
        this.dialog_type = 1
        this.dialog = true
      },
      close_dialog(){
        this.dialog = false 
        if (this.dialog_type === 1)
        {
          this.$router.push("/")
        }
      },
      show_error_dialog(){
        this.dialog_title = this.$t('VoyageCreation.dialog_title_error')
        this.dialog_text = this.$t('VoyageCreation.dialog_text_error')
        this.dialog_type = 2
        this.dialog = true
      },


    }
  }
</script>

<style>

</style>