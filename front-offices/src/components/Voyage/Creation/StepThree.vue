<template>
    <div class="mb-2">
        <v-form class="mx-auto">
            <v-row class="mb-n2">
                <v-col cols="12" lg="12">
                    <h3>{{this.$t('VoyageCreation.MaritimeAgenciesforSchedule')}}</h3>
                    <br>
                    <v-btn 
                     @click="show_dialog"
                     class="mb-4"                   
                    >
                    <v-icon left>mdi-plus-circle</v-icon>
                    {{this.$t('VoyageCreation.AddMaritimeAgency')}}
                    </v-btn>
                </v-col>
            </v-row>
            <v-row class="my-n2">
                <v-col cols="12" lg="4" sm="4" 
                 v-for="(ma, index) in this.$store.state.step3"
                 :key="ma.id">
                    <CardMaritimeAgency
                    :number= index+1
                    :id= index
                    :maritime_agency_id= "ma.maritime_agency_id"
                    :responsability_code= "ma.responsability_code"
                    >
                    </CardMaritimeAgency>
                </v-col>
            </v-row>
        </v-form>
         <DialogMaritimeAgency
         ref="dlgMaritimeAgency"
         >

        </DialogMaritimeAgency>   
    </div>
</template>

<script>
import DialogMaritimeAgency from './DialogMaritimeAgency.vue'
import CardMaritimeAgency from './CardMaritimeAgency.vue'

export default {

name: 'StepThree',
    components: {
        DialogMaritimeAgency,
        CardMaritimeAgency,
         
    },
    data(){
      return {
      }
    },
    methods:{
         show_dialog(){
            this.$refs.dlgMaritimeAgency.show_dialog()
        }
    }
     
}

</script>