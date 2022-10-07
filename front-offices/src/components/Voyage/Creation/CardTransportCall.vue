<template>
<div>
<v-card min-width="272" max-width="300" class="mx-auto">
    <v-card-title
     class="grey lighten-4"
    >
        <span class="ml-2">{{this.$t('VoyageCreation.TransportCall')}} # {{number}}</span>
    </v-card-title>
    <v-card-subtitle class="mt-1">
        <span class="font-weight-bold">{{this.$t('VoyageCreation.TransportCallInfo')}}</span>
    </v-card-subtitle>
    <v-card-text>
      <v-list-item two-line  class="px-1 mt-n5">
            <v-list-item-content>
              <v-list-item-title class="body-2">{{tcall_id}}</v-list-item-title>
              <v-list-item-subtitle class="caption">{{this.$t('VoyageCreation.TransportCallID')}}</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
        <v-list-item two-line  class="px-1 mt-n5">
            <v-list-item-content>
              <v-list-item-title class="body-2">{{port_facility}}</v-list-item-title>
              <v-list-item-subtitle class="caption">{{this.$t('VoyageCreation.PortFacility')}}</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
        <v-list-item two-line  class="px-1 mt-n4">
            <v-list-item-content>
              <v-list-item-title class="body-2">{{mooring_operator}}</v-list-item-title>
              <v-list-item-subtitle class="caption">{{this.$t('VoyageCreation.MooringOperator')}}</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
        <v-list-item two-line  class="px-1 mt-n4">
            <v-list-item-content>
              <v-list-item-title class="body-2">{{tug_operator}}</v-list-item-title>
              <v-list-item-subtitle class="caption">{{this.$t('VoyageCreation.TugboatCompany')}}</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>
    </v-card-text>

    <v-divider></v-divider>

<v-chip-group class="mx-2">
   <v-btn text color="primary" @click="show_edit_dialog" >{{this.$t('VoyageCreation.buttonEdit')}}</v-btn>
   <v-btn 
   text
    @click="show_delete_dialog"   
   >{{this.$t('VoyageCreation.buttonDelete')}}</v-btn>
</v-chip-group>

</v-card>

<!-- Diálogo Exluir-->
<dialog-delete-transport-call
ref="dlgDeleteTransportCall"
>
</dialog-delete-transport-call>
<!-- Diálogo Editar Parada-->
<dialog-transport-call
dialog_type = 2
ref="dlgTransportcall"
>
</dialog-transport-call>
</div>
</template>

<script>
import DialogDeleteTransportCall from './DialogDeleteTransportCall.vue'
import DialogTransportCall from './DialogTransportCall.vue'


export default {
  name: 'CardTransportCall',
  props: {
    number: {type: Number, default: 1},
    id: {type: Number, default: 0},
    order: {type: Number, default: 1},
    tcall_id: {type: String, default: ''},
    port_facility: {type: String, default: ''},
    mooring_operator: {type: String, default: ''},
    tug_operator: {type: String, default: ''}
    },
    components: { 
      DialogDeleteTransportCall,
        DialogTransportCall
       
    },
 data (){
      return{
          
      }
     },
  methods:{
     show_delete_dialog(){
          this.$refs.dlgDeleteTransportCall.show_dialog(this.id)
      },
      show_edit_dialog(){
        var tc = {
          id: this.id,
          order: this.order,
          tcall_id: this.tcall_id,
          port_facility: this.port_facility,
          mooring_operator: this.mooring_operator,
          tug_operator: this.tug_operator
        }
        this.$refs.dlgTransportcall.edit_transportcall(tc)
        this.$refs.dlgTransportcall.dialog = true
      }
  }
};
</script>