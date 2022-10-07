<template>
    <div class="mb-2">
        <v-form class="mx-auto">
            <v-row class="mb-n2">
                <v-col cols="12" lg="12">
                    <h3>{{this.$t('VoyageCreation.TransportCalls')}}</h3>
                    <br>
                    
                    <v-btn
                    @click="show_dialog"        
                    >
                    <v-icon left>mdi-plus-circle</v-icon>
                    {{this.$t('VoyageCreation.AddTransportCall')}}
                    </v-btn>
                    
                </v-col>
            </v-row>
            <v-row class="my-n2">
                <v-col cols="12" lg="4" sm="4"
                 v-for="(tc, index) in sorted(this.$store.state.step2)"
                 :key="tc.id"
                >
                    <CardTransportCall
                    :number= index+1
                    :id= index 
                    :order = tc.order
                    :tcall_id = "tc.tcall_id"
                    :port_facility = "tc.port_facility"
                    :mooring_operator = "tc.mooring_operator"
                    :tug_operator = "tc.tug_operator"
                    ></CardTransportCall>
                    
                </v-col>
            </v-row>

            <!--
              <v-row class="my-n2">
                <v-col cols="12" lg="12">
                    <v-checkbox
                    :label="this.$t('VoyageCreation.TransportCallOrder')"
                    class="ml-2"
                    v-model="correct_order"
                    ></v-checkbox>
                </v-col>
            </v-row>
            -->
            
        </v-form>
         
         <DialogTransportCall
         ref="dlgTransportCall"
         >
        </DialogTransportCall>   
         
    </div>
</template>

<script>
 import CardTransportCall from './CardTransportCall.vue'
 import DialogTransportCall from './DialogTransportCall.vue'

export default {

name: 'StepTwo',
    components: {
         CardTransportCall,
         DialogTransportCall,
    },
    data(){
      return {
          step2:[],
          show_DialogTransporCall: false,
          correct_order: false,
        
      }
    },
    methods:{
        show_dialog(){
            this.$refs.dlgTransportCall.show_dialog()
        },
        sorted: function(arr) {
            return arr.slice().sort(function(a, b) {
                return a.order - b.order;
            });
            }
        },
        check_correct_order(){
            alert(this.correct_order)
            return this.correct_order
        }

     
}

</script>