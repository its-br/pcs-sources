<template>
  <v-layout align-center justify-center>
    <v-col cols="12" sm="10" lg="8">
      <v-card light>
        <v-progress-linear indeterminate v-show="loading"></v-progress-linear>
        <v-card-title class="text-h5">{{title}}</v-card-title>
        <v-card-subtitle class="text-h5">{{subtitle}}</v-card-subtitle>
        <v-list two-line class="pa-0">
          <v-list-item href="#">
            <v-list-item-action>
              <v-icon>mdi-account</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>{{Name}}</v-list-item-title>
              <v-list-item-subtitle>{{$t('name')}}</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
          <v-divider inset></v-divider>
          <v-list-item href="#">
            <v-list-item-action>
              <v-icon>mdi-card-account-details-outline</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>{{Cnpj}}</v-list-item-title>
              <v-list-item-subtitle>{{$t('cnpj')}}</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
          <v-divider inset></v-divider>
          <v-list-item href="#">
            <v-list-item-action>
              <v-icon>mdi-phone</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>{{Phones}}</v-list-item-title>
              <v-list-item-subtitle>{{$t('phone')}}
              </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
          <v-divider inset></v-divider>
          <v-list-item href="#">
            <v-list-item-action>
              <v-icon>mdi-email-outline</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>{{Emails}}</v-list-item-title>
              <v-list-item-subtitle>{{$t('mail')}}
              </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
          <v-divider inset></v-divider>
          <v-list-item href="#">
            <v-list-item-action>
              <v-icon>mdi-home-city</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>{{Address}}</v-list-item-title>
              <v-list-item-subtitle>{{$t('address')}}
              </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
          <v-list-item href="#">
            <v-list-item-action>
              <v-icon></v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>{{PostalCode}}</v-list-item-title>
              <v-list-item-subtitle>{{$t('postalCode')}}
              </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
          <v-list-item href="#">
            <v-list-item-action>
              <v-icon></v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>{{City}}</v-list-item-title>
              <v-list-item-subtitle>{{$t('city')}}
              </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
          <v-list-item href="#">
            <v-list-item-action>
              <v-icon></v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>{{State}}</v-list-item-title>
              <v-list-item-subtitle>{{$t('state')}}
              </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
          <v-divider inset></v-divider>
          <v-list-item href="#">
            <v-list-item-content>
              <v-row class="justify-center">
                <v-btn class="ma-2 secondary" to="/MaritimeAgent/Update">{{$t('edit')}}
                </v-btn>
                <v-btn class="ma-2 error">{{$t('text.form.dataDeletion')}}
                </v-btn>
              </v-row>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-card>
    </v-col>
  </v-layout>
</template>

<script>
import axios from 'axios'
export default {
    name:"MaritimeAgentInfo",
    data : () => ({
      Name: null,
      Cnpj: null,
      Phones: null,
      Emails: null,
      PostalCode: null,
      Address: null,
      City: null,
      State: null,
      loading: true,
      title: 'Maritime Agent',
      subtitle: 'Informations',
    }),
    methods:{
     edit(){

     },
     delete(){

     }
    },
    mounted(){
      var cnpj = this.$store.state.cnpj;
      if (cnpj == null){ 
        this.$router.push('/'); 
      }
      cnpj = cnpj.replace(/[^0-9]/g, '')
      const defaultCnpj = cnpj;
      this.title = this.$t("maritimeAgent");
      this.subtitle = this.$t("informations");
      axios
        .get(`http://localhost:3000/maritime-agent?cnpj=${defaultCnpj}`)
        .then(response => {
          if (response.status != 200 || response.data.length == 0){
            this.$router.push('/MaritimeAgent/Create')
          }
          this.Cnpj = this.$store.state.cnpj;
          this.Name = response.data[0].name;
          this.Phones = response.data[0].phone.join(', ');
          this.Emails = response.data[0].email.join(', ');
          this.City = response.data[0].address.city;
          this.PostalCode = response.data[0].address.postalCode;
          this.State = response.data[0].address.state;
          this.Address = response.data[0].address.address;
        })
        .catch(
          error => {
            console.error(error);
            this.$router.push('/MaritimeAgent/Create')
          }
        )      
        .finally(() => this.loading = false);
    }
}
</script>

<style>

</style>