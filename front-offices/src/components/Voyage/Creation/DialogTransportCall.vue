<template>
    <div class="text-center">
    <v-dialog
      v-model="dialog"
      width="500"
    >
      <v-card>
        <v-card-title class="text-h6 grey lighten-2">
          <span v-if="dialog_type==1">{{this.$t('VoyageCreation.dialogAddTransportCall')}}</span>
          <span v-else>{{this.$t('VoyageCreation.dialogEditTransportCall')}}</span>
        </v-card-title>

        <v-card-text>
            <v-form>
                <br>
                
                <v-text-field
                outlined
                :label= "this.$t('VoyageCreation.dialogTransportCallIdentification')"
                v-model="transportcall.tcall_id"
                name="tcall_id"
                @input="onChange($event, 'tcall_id')"
                :error-messages="this.errors['tcall_id']"
                >
                </v-text-field>

                <v-text-field
                outlined
                :label="this.$t('VoyageCreation.dialogPortFacilityCNPJ')"
                v-model="transportcall.port_facility"
                name="port_facility"
                v-mask="'##.###.###/####-##'" 
                @input="onChange($event, 'port_facility')"
                :error-messages="this.errors['port_facility']"
                >
                </v-text-field>

                <v-text-field
                outlined
                :label="this.$t('VoyageCreation.dialogMooringOperatorCNPJ')"
                v-model="transportcall.mooring_operator"
                name="mooring_operator"
                v-mask="'##.###.###/####-##'" 
                @input="onChange($event, 'mooring_operator')"
                :error-messages="this.errors['mooring_operator']"
                >
                </v-text-field>

                <v-text-field
                outlined
                :label="this.$t('VoyageCreation.dialogTugboatCompanyCNPJ')"
                v-model="transportcall.tug_operator"
                name="tug_operator"
                v-mask="'##.###.###/####-##'" 
                @input="onChange($event, 'tug_operator')"
                :error-messages="this.errors['tug_operator']"
                >
                </v-text-field>
            </v-form>
        </v-card-text>

        

        <v-card-actions class="mt-n4">
          
          <!--
          <v-text-field 
              class="text-field text-center"
                id="order"
                outlined
                :label="this.$t('VoyageCreation.dialogOrder')"
                dense
                v-model="transportcall.order"
                name="order"
                @input="onChange($event, 'order')"
                :error-messages="this.errors['order']"
                >
                </v-text-field>
        <v-spacer></v-spacer>
        <v-icon @click="decrement" >mdi-minus</v-icon>
        <v-spacer></v-spacer>
        <v-icon @click="increment" >mdi-plus</v-icon>
                
        <v-spacer></v-spacer> -->
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
  name: 'DialogTransportCall',
  props: {
       dialog_type: {type: Number, default:1},
       dialog_title: {type: String, default:"Adicionar Parada"},
    },
    mounted() {
      
    },
 data (){
      return{
         errors:[],
          transportcall:{
            id: 0,
            order: 0,
            tcall_id:null,
            port_facility: null,
            mooring_operator: null,
            tug_operator: null
          },
          dialog: false,
      }
     },
  methods:{
      show_dialog(){
          this.transportcall.order = this.$store.state.step2.length + 1;
          this.transportcall.tcall_id = null
          this.transportcall.port_facility = null 
          this.transportcall.mooring_operator = null 
          this.transportcall.tug_operator = null
          this.dialog = true  
      },
      increment(){
        this.transportcall.order++;
        this.onChange(null, 'order')
      },
      decrement(){
        if (this.transportcall.order > 1){ 
          this.transportcall.order--;
          this.onChange(null, 'order')
        }
      },
      confirm(){
        const form = {
          order: parseInt(this.transportcall.order),
          tcall_id: this.transportcall.tcall_id,
          port_facility: this.transportcall.port_facility,
          mooring_operator: this.transportcall.mooring_operator,
          tug_operator: this.transportcall.tug_operator
        }
        this.errors = this.validateForm(form)
        if (this.errors.formIsValid){
          if (this.dialog_type == 1){
            this.add_transportcall()
          }else{
          this.update_transportcall()
          }
        }
      },
      add_transportcall(){
        const tc = {
            order: parseInt(this.transportcall.order),
            tcall_id: this.transportcall.tcall_id,
            port_facility: this.transportcall.port_facility,
            mooring_operator: this.transportcall.mooring_operator,
            tug_operator: this.transportcall.tug_operator
        }
        this.$store.commit('addTransportcall', tc )
        this.dialog = false
      },
      update_transportcall(){
        const tc = {
            order: parseInt(this.transportcall.order),
            tcall_id: this.transportcall.tcall_id,
            port_facility: this.transportcall.port_facility,
            mooring_operator: this.transportcall.mooring_operator,
            tug_operator: this.transportcall.tug_operator
        }
        this.$store.state.step2.splice(this.transportcall.id,1, tc)
        this.dialog = false
      },
      edit_transportcall(tc){
        this.transportcall = tc 
        this.dialog = true
      },
      onChange(e, inputName) {
        const inputValue = this.transportcall[inputName];
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

<style scoped>
.text-field{
  width: 50px !important;
  margin-top: 24px;
  margin-left: 8px;
  text-align: center!important;

}
</style>