<template>
    <div class="text-center">
    <v-dialog
      v-model="dialog"
      width="500"
    >
      <v-card>
        <v-card-title class="text-h6 grey lighten-2">
         {{this.$t('VoyageCreation.dialogDeleteAgency')}}
        </v-card-title>

        <v-card-text class="my-3">
            <span > {{this.$t('VoyageCreation.dialogDeleteAgencyM')}}</span>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            text
            @click="confirm_delete"
          >
             {{this.$t('VoyageCreation.buttonYes')}}
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

export default {
  name: 'DialogDeleteMaritimeAgency',
  props: {
       item_id:{String,default:"selecionada"},
       maritimeagency_id:0,
    },
 data (){
      return{
          dialog: false,
         
      }
     },
  methods:{
      show_dialog(id){
          this.maritimeagency_id = id 
          this.dialog = true
      },
      confirm_delete(){
        this.$store.commit('DeleteMaritimeAgency', this.maritimeagency_id)
        this.dialog = false
      }
  }
};
</script>