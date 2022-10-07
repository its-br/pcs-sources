<template>
    <div class="text-center">
    <v-dialog
      v-model="dialog"
      width="500"
    >
      <v-card>
        <v-card-title class="text-h6 grey lighten-2">
          <span v-if="dialog_type==1">{{this.$t('VoyageCreation.dialogAddAgency')}}</span>
          <span v-else>{{this.$t('VoyageCreation.dialogEditAgency')}}</span>
        </v-card-title>

        <v-card-text>
            <v-form>
                <br>

                <v-text-field
                outlined
                :label="this.$t('VoyageCreation.dialogMaritimeAgencyCNPJ')"
                v-model="maritimeagency.maritime_agency_id"
                name="maritime_agency_id"
                type="text"
                v-mask="'##.###.###/####-##'" 
                @input="onChange($event, 'maritime_agency_id')"
                :error-messages="this.errors['maritime_agency_id']"
                >
                </v-text-field>

                <v-select
                :items="items"
                :label="this.$t('VoyageCreation.dialogMaritimeAgencyResponsabilityCode')"
                outlined
                v-model="maritimeagency.responsability_code"
                name="responsability_code"
                type="text"
                @input="onChange($event, 'responsability_code')"
                :error-messages="this.errors['responsability_code']"
                ></v-select>

            </v-form>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            text
            @click="confirm"
          >
            <span v-if="dialog_type==1" >{{this.$t('VoyageCreation.buttonAdd')}}</span>
            <span v-else>{{this.$t('VoyageCreation.buttonUpdate')}}</span>
          </v-btn>
          <v-btn
            text
            @click="dialog = false"
          >
            {{this.$t('VoyageCreation.buttonCancel')}}
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import validationMixin from '@/mixins/validationMixin';
import Vue from 'vue';
import VueMask from 'v-mask';

Vue.use(VueMask);

export default {
  name: 'DialogMaritimeAgency',
  props: {
       dialog_type: {type: Number, default:1},
    },
 data (){
      return{
        errors:[],
        maritimeagency:{
          id: 0,
          maritime_agency_id: '',
          responsability_code: '',
        },
        dialog: false,
        items: [
        {text:this.$t('VoyageCreation.responsability100'), value: '100'},
        {text:this.$t('VoyageCreation.responsability200'), value: '200'},
        {text:this.$t('VoyageCreation.responsability300'), value: '300'},
        ],

      }
     },
  methods:{
      show_dialog(){
          this.dialog = true
      },
      confirm(){
        const form = {
          maritime_agency_id: this.maritimeagency.maritime_agency_id,
          responsability_code: this.maritimeagency.responsability_code
        }
        this.errors = this.validateForm(form)
        if(this.errors.formIsValid) {
          if (this.dialog_type == 1){
              this.add_maritimeagency()
            }else{
            this.update_maritimeagency()  
          }
        }
      },
      add_maritimeagency(){
        const ma = {
            maritime_agency_id: this.maritimeagency.maritime_agency_id,
            responsability_code: this.maritimeagency.responsability_code
        }
        this.$store.commit('addMaritimeAgency', ma )
        this.dialog = false
      },
      update_maritimeagency(){
        const ma = {
         maritime_agency_id: this.maritimeagency.maritime_agency_id,
        responsability_code: this.maritimeagency.responsability_code
        }
        this.$store.state.step3.splice(parseInt(this.maritimeagency.id),1, ma)
        this.dialog = false
      },
      edit_maritimeagency(ma){
        this.maritimeagency = ma 
        this.dialog = true
      },
      onChange(e, inputName) {
        const inputValue = this.maritimeagency[inputName];
        const inputErrors = this.validateField(inputName, inputValue);
        if(inputErrors && inputErrors.length) {
        this.errors[inputName] = inputErrors;
        } else {
        this.errors[inputName] = null;
        }
    },
  },
  mixins: [validationMixin]
};
</script>