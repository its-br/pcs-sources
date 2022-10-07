<template>
<div>
<v-card min-width="272" max-width="300" class="mx-auto">
    <v-card-title
     class="grey lighten-4"
    >
        <span class="ml-2">{{this.$t('VoyageCreation.Agency')}} # {{number}}</span>
    </v-card-title>
    <v-card-subtitle class="mt-1">
        <span class="font-weight-bold">{{this.$t('VoyageCreation.MaritimeAgencyInfo')}}</span>
    </v-card-subtitle>
    <v-card-text>
        <v-list-item two-line  class="px-1 mt-n5">
            <v-list-item-content>
              <v-list-item-title class="body-2">{{maritime_agency_id}}</v-list-item-title>
              <v-list-item-subtitle class="caption">{{this.$t('VoyageCreation.MaritimeAgencyCNPJ')}}</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
        <v-list-item two-line  class="px-1 mt-n4">
            <v-list-item-content>
              <v-list-item-title class="body-2">{{responsability_code}}</v-list-item-title>
              <v-list-item-subtitle class="caption">{{this.$t('VoyageCreation.MaritimeAgencyResponsabilityCode')}}</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
    </v-card-text>

    <v-divider></v-divider>

<v-chip-group class="mx-2">
   <v-btn 
   text 
   color="primary"
   @click="show_edit_dialog"
    >{{this.$t('VoyageCreation.buttonEdit')}}</v-btn>
   <v-btn 
   text
   @click="show_delete_dialog"
   >{{this.$t('VoyageCreation.buttonDelete')}}</v-btn>
</v-chip-group>

</v-card>

<!-- Diálogo Exluir-->
<dialog-delete-maritime-agency
ref="dlgDeleteMaritimeAgency"
>
</dialog-delete-maritime-agency>
<!-- Diálogo Editar Agência-->
<dialog-maritime-agency
dialog_type = 2
ref="dlgMaritimeAgency"
>
</dialog-maritime-agency>
</div>
</template>

<script>
import DialogDeleteMaritimeAgency from './DialogDeleteMaritimeAgency.vue'
import DialogMaritimeAgency from './DialogMaritimeAgency.vue';


export default {
  name: 'CardMaritimeAgency',
  props: {
      number: {type: Number, default: 1},
      id: {type: Number, default: 0},
       maritime_agency_id: {type: String, default: ''},
       responsability_code: {type: String, default: ''},
       },
       components: {
         DialogDeleteMaritimeAgency,
          DialogMaritimeAgency,
       },
 data (){
      return{
          
      }
     },
  methods:{
     show_delete_dialog(){
          this.$refs.dlgDeleteMaritimeAgency.show_dialog(this.id)
      },
      show_edit_dialog(){
        var ma = {
          id: this.id,
          maritime_agency_id: this.maritime_agency_id,
          responsability_code: this.responsability_code
        }
        this.$refs.dlgMaritimeAgency.edit_maritimeagency(ma)
        this.$refs.dlgMaritimeAgency.dialog = true
      }
  }
};
</script>