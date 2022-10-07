<template>
  <div>
    <!--Card Prático-->
    <v-card class="mx-auto" max-width="300">
        <v-card-title class="grey lighten-5">
            <span class="ml-0">{{this.$t('HarborPilot.PilotBoardingPlace')}}</span>
        </v-card-title>
        <v-card-subtitle class="grey lighten-5">
            <span class="ml-1 mr-1">{{pilotEventLabel}}: </span>
             <v-icon>mdi-alarm</v-icon>
            <span class="ml-1">{{pilotEventTime}}</span>
            <v-icon class="ml-3">mdi-calendar</v-icon>
            <span class="ml-1">{{pilotEventDate}}</span>
            <br/>
            <span class="ml-1">PCSVoyageID: {{voyage.PCSVoyageID}}</span>
        </v-card-subtitle>
        <v-divider></v-divider>
        <VoyageCardInfo :voyage="voyage" :showTransportCall="false"/>
        <v-divider></v-divider>
        <v-card-actions>
            <v-btn text color="primary" class="mx-auto" @click="showEventPlanning">
                {{this.$t('HarborPilot.FollowEvents')}}
            </v-btn>
        </v-card-actions>
    </v-card>
  </div>
</template>

<script>
import VoyageCardInfo from '@/components/Voyage/Kanban/VoyageCardInfo.vue'

export default {
  components: { VoyageCardInfo },
    name: "PilotCard",
    props: {
        voyage: null,
        pilotEventLabel: {type:String, default: "ETA"},
        pilotEventTime: {type:String, default: ""},
        pilotEventDate: {type:String, default: ""},
    },
    data() {
        return{
        }
    },
    methods: {
        showEventPlanning(){
            this.$router.push({path: `/EventPlanning/${this.voyage.PCSVoyageID}/${this.voyage.transportCall[0].transportCallID}`})
        },
    }
}
</script>