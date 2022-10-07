<template>
    <div class="mb-2">
        <v-row>
            <v-col cols="12" lg="4" md="4">
                <v-card min-width="300">
                    <v-card-title class="grey lighten-4">
                        {{this.$t('VoyageCreation.Identification')}}
                    </v-card-title>
                    <v-card-subtitle>
                    </v-card-subtitle>
                    <v-card-text class="mt-4">
                        <v-list-item two-line  class="px-1 mt-n5" v-for="info in this.step1info" :key="info.id">
                        <v-list-item-content>
                        <v-list-item-title class="body-2">{{info.value}}</v-list-item-title>
                        <v-list-item-subtitle class="caption">{{info.label}}</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    </v-card-text>
                    <v-divider></v-divider>
                    <v-card-actions>
                        <v-btn 
                        text 
                        color="primary"
                        @click="click_step1"
                        >
                        {{this.$t('VoyageCreation.buttonEdit')}}
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
            <v-col cols="12" lg="4" md="4">
                <v-card min-width="300">
                    <v-card-title class="grey lighten-4">
                         {{this.$t('VoyageCreation.TransportCalls')}}
                    </v-card-title>
                    <v-card-subtitle>
                    </v-card-subtitle>
                    <v-card-text class="mt-4">
                        <v-row v-for="info in sorted(this.step2info)" :key="info.id">
                            <v-col>
                            <v-list-item two-line  class="px-1 mt-n5">
                            <v-list-item-content>
                            <v-list-item-title class="body-2">{{info.tcall_id.value}}</v-list-item-title>
                            <v-list-item-subtitle class="caption">{{info.tcall_id.label}}</v-list-item-subtitle>
                            </v-list-item-content>
                            </v-list-item>
                            <v-list-item two-line  class="px-1 mt-n5">
                            <v-list-item-content>
                            <v-list-item-title class="body-2">{{info.port_facility.value}}</v-list-item-title>
                            <v-list-item-subtitle class="caption">{{info.port_facility.label}}</v-list-item-subtitle>
                            </v-list-item-content>
                            </v-list-item>
                            <v-list-item two-line  class="px-1 mt-n5">
                            <v-list-item-content>
                            <v-list-item-title class="body-2">{{info.mooring_operator.value}}</v-list-item-title>
                            <v-list-item-subtitle class="caption">{{info.mooring_operator.label}}</v-list-item-subtitle>
                            </v-list-item-content>
                            </v-list-item>
                            <v-list-item two-line  class="px-1 mt-n5">
                            <v-list-item-content>
                            <v-list-item-title class="body-2">{{info.tug_operator.value}}</v-list-item-title>
                            <v-list-item-subtitle class="caption">{{info.tug_operator.label}}</v-list-item-subtitle>
                            </v-list-item-content>
                            </v-list-item>
                            <v-divider></v-divider>
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn 
                        text 
                        color="primary"
                        @click="click_step2"
                        >
                         {{this.$t('VoyageCreation.buttonEdit')}}
                        </v-btn>
                    </v-card-actions>                    
                </v-card>
            </v-col>
            <v-col cols="12" lg="4" md="4">
                <v-card min-width="300">
                    <v-card-title class="grey lighten-4">
                        {{this.$t('VoyageCreation.Agencies')}}
                    </v-card-title>
                    <v-card-subtitle>
                    </v-card-subtitle>
                    <v-card-text class="mt-4">
                        <v-row v-for="info in this.step3info" :key="info.id">
                            <v-col>
                            <v-list-item two-line  class="px-1 mt-n5">
                            <v-list-item-content>
                            <v-list-item-title class="body-2">{{info.maritime_agency_id.value}}</v-list-item-title>
                            <v-list-item-subtitle class="caption">{{info.maritime_agency_id.label}}</v-list-item-subtitle>
                            </v-list-item-content>
                            </v-list-item>
                            <v-list-item two-line  class="px-1 mt-n5">
                            <v-list-item-content>
                            <v-list-item-title class="body-2">{{info.responsability_code.value}}</v-list-item-title>
                            <v-list-item-subtitle class="caption">{{info.responsability_code.label}}</v-list-item-subtitle>
                            </v-list-item-content>
                            </v-list-item>
                            <v-divider></v-divider>
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn 
                        text 
                        color="primary"
                        @click="click_step3"
                        >
                         {{this.$t('VoyageCreation.buttonEdit')}}
                        </v-btn>
                    </v-card-actions>                    
                </v-card>
            </v-col>
        </v-row>

    </div>
</template>

<script>

export default {

name: 'StepFour',
    components: {
         
    },
    mounted() {
        this.print_update()
    },
    data(){
      return {
          step1info: [],
          step2info: [],
          step3info: []
      }
    },
    methods:{
        print_update(){
            this.print_step1_info()
            this.print_step2_info()
            this.print_step3_info()
        },
        print_step1_info(){
            this.step1info = []
            this.step1info = [
                {label: this.$t('VoyageCreation.MaritimeAgencyCNPJ'), value: this.$store.state.step1.maritime_agent_cnpj},
                {label: this.$t('VoyageCreation.CarrierCode'), value: this.$store.state.step1.carrier_code},
                {label: this.$t('VoyageCreation.ListProvider'), value: this.$store.state.step1.list_provier},
                {label: this.$t('VoyageCreation.VesselIMO'), value: this.$store.state.step1.vessel_imo},
                {label: this.$t('VoyageCreation.CarrierVoyageNumber'), value: this.$store.state.step1.carrier_voyage_number},
                {label: this.$t('VoyageCreation.UNLocationCode'), value: this.$store.state.step1.un_location_code},
            ]
        },
        print_step2_info(){
            this.step2info = []
            this.$store.state.step2.map((tc) => {
                this.step2info.push(
                    {
                    order: {label: '0', value: tc.order},
                    tcall_id: {label: this.$t('VoyageCreation.TransportCallID'), value: tc.tcall_id},
                    port_facility: {label: this.$t('VoyageCreation.PortFacility'), value: tc.port_facility},
                    mooring_operator: {label: this.$t('VoyageCreation.MooringOperator'), value: tc.mooring_operator},
                    tug_operator: {label: this.$t('VoyageCreation.TugboatCompany'), value: tc.tug_operator}
                    }
                );
            });
        },
        print_step3_info(){
            this.step3info = []
            this.$store.state.step3.map((ma) => {
                this.step3info.push(
                    {
                    maritime_agency_id: {label: this.$t('VoyageCreation.MaritimeAgencyCNPJ'), value: ma.maritime_agency_id },
                    responsability_code: {label: this.$t('VoyageCreation.MaritimeAgencyResponsabilityCode'), value: ma.responsability_code}
                    }
                );
            });
        },
        sorted: function(arr) {
            return arr.slice().sort(function(a, b) {
                return a.order - b.order;
            });
        },
        click_step1(){
            this.$emit("click_step1")
        },
        click_step2(){
            this.$emit("click_step2")
        },
        click_step3(){
            this.$emit("click_step3")
        },
    }
     
}

</script>