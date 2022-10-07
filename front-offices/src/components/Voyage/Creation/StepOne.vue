<template>
    <div>
        <v-form class="mx-auto">
            <v-row class="mb-n2">
                <v-col cols="12" lg="6">
                    <h3>{{this.$t('VoyageCreation.Identification')}}</h3>
                    <v-checkbox
                    :label = "this.$t('VoyageCreation.CreateAsAgent')" 
                    class="ml-2"
                    v-model="step1.checkbox"
                    name="checkbox"
                    @change="check_has_user_agent"
                    >
                    </v-checkbox>
                </v-col>
            </v-row>
            <v-row class="my-n2">
                <v-col cols="12" lg="6">
                    <v-text-field class="mb-2"
                    outlined
                    :readonly="has_user_agent"
                    :label="this.$t('VoyageCreation.MaritimeAgencyCNPJ')"
                    v-model="step1.maritime_agent_cnpj"
                    name="maritime_agent_cnpj"
                    v-mask="'##.###.###/####-##'" 
                    @input="onChange($event, 'maritime_agent_cnpj')"
                    :error-messages="this.errors['maritime_agent_cnpj']"
                    >
                    </v-text-field>
                    <v-text-field class="mb-2"
                    outlined
                    :label="this.$t('VoyageCreation.CarrierCode')"
                    v-model="step1.carrier_code"
                    v-mask="'XXXX'" 
                    name="carrier_code"
                    hint="Ex: MSCU, SUDU, MAEU, 11DX"
                    persistent-hint
                    @input="onChange($event, 'carrier_code')"
                    :error-messages="this.errors['carrier_code']"
                    >
                    </v-text-field>
                    <v-radio-group
                    row
                    :label="this.$t('VoyageCreation.ListProvider') + ':'"
                    class="ml-2 mt-n2"
                    v-model="step1.list_provier"
                    name="list_provier"
                    required
                    >
                        <v-radio value="SMDG" label="SMDG"></v-radio>
                        <v-radio value="NMFTA" label="NMFTA"></v-radio>
                    </v-radio-group>
                    <v-text-field class="mb-2"
                    outlined
                    :label="this.$t('VoyageCreation.VesselIMO')"
                    v-model="step1.vessel_imo"
                    name="vessel_imo"
                    v-mask="'#######'" 
                    @input="onChange($event, 'vessel_imo')"
                    :error-messages="this.errors['vessel_imo']"
                    >
                    </v-text-field>
                </v-col>
                <v-col cols="12" lg="6" >
                    <v-text-field
                    outlined
                    :label="this.$t('VoyageCreation.CarrierVoyageNumber')"
                    v-model="step1.carrier_voyage_number"
                    name="carrier_voyage_number"
                    hint="Ex: 101N, 782S, 211E, 999W"
                    persistent-hint
                    @input="onChange($event, 'carrier_voyage_number')"
                    :error-messages="this.errors['carrier_voyage_number']"
                    >
                    </v-text-field>
                    <v-text-field
                    outlined
                    :label="this.$t('VoyageCreation.UNLocationCode')"
                    v-model="step1.un_location_code"
                    name="un_location_code"
                    v-mask="'XXXXX'" 
                    hint="Ex: BRSSZ (Santos), BRPNG (Paranagua), BRITJ (Itajai)"
                    persistent-hint
                    @input="onChange($event, 'un_location_code')"
                    :error-messages="this.errors['un_location_code']"
                    >
                    </v-text-field>
                    </v-col>
            </v-row>

        </v-form>
    </div>
</template>

<script>
import validationMixin from '@/mixins/validationMixin';
import Vue from 'vue';
import VueMask from 'v-mask';

Vue.use(VueMask);

export default {

name: 'StepOne',
    components: {
         
    },
    data(){
      return {
        errors: [],
        has_user_agent: false,
        step1:{  
            checkbox: false,
            maritime_agent_cnpj: this.$store.state.cnpj,
            user_agent_cnpj: this.$store.state.cnpj,
            list_provier: 'SMDG',
            carrier_code: '',
            vessel_imo: '',
            carrier_voyage_number: '',
            un_location_code: ''
        }
      }
    },
    methods: {
        check_has_user_agent(){
            if(this.step1.checkbox === true){
                this.step1.maritime_agent_cnpj = ''
                this.has_user_agent = false
            }else{
                this.step1.maritime_agent_cnpj = this.$store.state.cnpj
                this.has_user_agent = true
                
            }
        },
        save_state(){
            const form = {
                maritime_agent_cnpj: this.step1.maritime_agent_cnpj,
                user_agent_cnpj: this.step1.user_agent_cnpj,
                list_provier: this.step1.list_provier,
                carrier_code: this.step1.carrier_code,
                vessel_imo: this.step1.vessel_imo,
                carrier_voyage_number: this.step1.carrier_voyage_number,
                un_location_code: this.step1.un_location_code
            }
            this.errors = this.validateForm(form)
            if (this.errors.formIsValid) {
                this.$store.state.step1 = this.step1
                return true 
            }else{
                return false 
            }
        },
    onChange(e, inputName) {
        const inputValue = this.step1[inputName];
        const inputErrors = this.validateField(inputName, inputValue);
        if(inputErrors && inputErrors.length) {
        this.errors[inputName] = inputErrors;
        } else {
        this.errors[inputName] = null;
        }
    },

    test(){
        alert('test')
    },

    },
mixins: [validationMixin]   
}

</script>