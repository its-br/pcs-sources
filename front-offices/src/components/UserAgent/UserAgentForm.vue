<template>
  <v-col cols="12" sm="10" lg="10">
    <v-card light>
      <v-progress-linear indeterminate v-show="loading"></v-progress-linear>
      <v-card-title class="text-h5">{{title}}</v-card-title>
      <v-card-subtitle class="text-h5">{{subtitle}}</v-card-subtitle>
      <v-card-text>
        <form>
          <v-row>
            <v-col cols="12" lg="6">
              <v-text-field outlined :label="$t('cnpj')" 
                v-model="$v.Cnpj.$model" v-mask="'##.###.###/####-##'" 
                :error-messages="cnpjErrors" :disabled="cnpjDisabled" @input="$v.Cnpj.$touch()" @blur="$v.Cnpj.$touch()" 
              ></v-text-field>
              <v-text-field outlined required :label="$t('name')" 
                v-model="$v.Name.$model" :error-messages="nameErrors"
                @input="$v.Name.$touch()" @blur="$v.Name.$touch()" 
              ></v-text-field>
              <v-text-field outlined required :label="$t('postalCode')" 
                :error-messages="postalCodeErrors" @input="$v.PostalCode.$touch()" @blur="$v.PostalCode.$touch()" 
                v-model="$v.PostalCode.$model" v-mask="'#####-###'" 
              ></v-text-field>
              <v-text-field outlined required :label="$t('address')" 
                :error-messages="addressErrors" @input="$v.Address.$touch()" @blur="$v.Address.$touch()" 
                v-model="$v.Address.$model" 
              ></v-text-field>
              <v-text-field outlined required :label="$t('state')" 
                :error-messages="stateErrors" @input="$v.State.$touch()" @blur="$v.State.$touch()" 
                v-model="$v.State.$model" 
              ></v-text-field>
              <v-text-field outlined required :label="$t('city')" 
                :error-messages="cityErrors" @input="$v.City.$touch()" @blur="$v.City.$touch()" 
                v-model="$v.City.$model" 
              ></v-text-field>
              <v-checkbox required :label="$t('text.form.confirmation')"
                :error-messages="confirmationErrors" @input="$v.Confirmation.$touch()" @blur="$v.Confirmation.$touch()" 
                v-model="$v.Confirmation.$model" 
              ></v-checkbox>
          </v-col>
          <v-col cols="12" lg="6">
            <h3>{{$t("text.form.updatePhoneEmail")}}</h3>
            <br>
            <div v-for="(v, i) in $v.Phones.$each.$iter" :key="i" class="text-fields-row">
              <v-text-field v-model="v.phone.$model" required outlined v-mask="'(##) #####-####'" :label="$t('phone')" 
                append-icon="mdi-close-circle" @click:append="deletePhone(i)"
                append-outer-icon="mdi-plus" @click:append-outer="addPhone"
                :error-messages="phoneErrors(v.phone)"  
              ></v-text-field>
            </div>
            <div v-for="(v, i) in $v.Emails.$each.$iter" :key="'A' + i" class="text-fields-row">
              <v-text-field v-model="v.email.$model" required outlined :label="$t('email')" 
                append-icon="mdi-close-circle" @click:append="deleteEmail(i)"
                append-outer-icon="mdi-plus" @click:append-outer="addEmail"
                :error-messages="emailErrors(v.email)"  
              ></v-text-field>
            </div>
          </v-col>
          <v-row class="justify-center">
            <v-btn class="ma-2 secondary" @click="clear">{{$t('clear')}}</v-btn>
            <v-btn class="ma-2 primary" @click="submit">{{btnSubmit}}</v-btn>
          </v-row>
        </v-row>
        </form>
      </v-card-text>
      <v-card-subtitle>
        {{$t('text.form.questions')}}
      </v-card-subtitle>
    </v-card>
  </v-col>
</template>

<script>
import axios from 'axios';
import Vue from 'vue';
import VueMask from 'v-mask';
import {validationMixin} from 'vuelidate'
import { required, email, sameAs } from 'vuelidate/lib/validators'

Vue.use(VueMask);

export default {
  name:"UserAgentForm",
  mixins:[validationMixin],
  // setup (){
  //   return { v$: useVuelidate() }
  // },
  data () {
    return {
      Name: null,
      Cnpj: null,
      Phones: [],
      Emails: [],
      PostalCode: null,
      Address: null,
      State: null,
      City: null,
      Confirmation: null,
      btnSubmit: "Create",
      title: null,
      subtitle: null,
      cnpjDisabled: false,
      loading: false
    }
  },
  validations () {
    return {
      Cnpj: {required},
      Name: {required},
      Phones: {required,
        $each: {
          phone: {
            required
          }
        }
      },
      Emails: {required,
        $each: {
          email: {
            required,
              email
          }
        }
      },
      PostalCode: {required},
      Address: {required},
      State: {required},
      City: {required},
      Confirmation: {required, 
         sameAs: sameAs( () => true ) 
      },
    }
  },
  components:{
  },
  computed: {
    cnpjErrors () {
      const errors = []
      if (!this.$v.Cnpj.$dirty) return errors
      var cnpj = '';
      if (this.$v.Cnpj.$model != null)
        cnpj = this.$v.Cnpj.$model.replace(/[^0-9]/g, '')
      !this.$v.Cnpj.required && errors.push(this.$t('text.form.errors.cnpjRequired'))
      cnpj.length != 14 && errors.push(this.$t('text.form.errors.cnpjLenght'))
      return errors
    },
    nameErrors () {
      const errors = []
      if (!this.$v.Name.$dirty) return errors
      !this.$v.Name.required && errors.push(this.$t('text.form.errors.nameRequired'))
      return errors
    },
    postalCodeErrors () {
      const errors = []
      if (!this.$v.PostalCode.$dirty) return errors
      !this.$v.PostalCode.required && errors.push(this.$t('text.form.errors.postalCodeRequired'))
      return errors
    },
    addressErrors () {
      const errors = []
      if (!this.$v.Address.$dirty) return errors
      !this.$v.Address.required && errors.push(this.$t('text.form.errors.addressRequired'))
      return errors
    },
    stateErrors () {
      const errors = []
      if (!this.$v.State.$dirty) return errors
      !this.$v.State.required && errors.push(this.$t('text.form.errors.stateRequired'))
      return errors
    },
    cityErrors () {
      const errors = []
      if (!this.$v.City.$dirty) return errors
      !this.$v.City.required && errors.push(this.$t('text.form.errors.cityRequired'))
      return errors
    },
    confirmationErrors () {
      const errors = []
      if (!this.$v.Confirmation.$dirty) return errors
      !this.$v.Confirmation.required && errors.push(this.$t('text.form.errors.confirmationRequired'))
      !this.$v.Confirmation.sameAs && errors.push(this.$t('text.form.errors.confirmationRequired'))
      return errors
    }
  },
  methods: {
    clear () {
      this.$v.$reset()
      this.Cnpj = ''
      this.Name = ''
      this.PostalCode = ''
      this.Address = ''
      this.State = ''
      this.City = ''
      this.Confirmation = null
      this.Phones = []
      this.Emails = []
      this.addPhone()
      this.addEmail()

    },
    phoneErrors (model) {
      const errors = []
      if (!model.$dirty) return errors
      var phone = '';
      if (model != null)
        phone = model.$model.replace(/[^0-9]/g, '')
      !model.required && errors.push(this.$t('text.form.errors.phoneRequired'))
      phone.length < 9 && errors.push(this.$t('text.form.errors.phoneRequired'))
      return errors
    },
    emailErrors (model) {
      const errors = []
      if (!model.$dirty) return errors
      !model.required && errors.push(this.$t('text.form.errors.emailRequired'))
      !model.email && errors.push(this.$t('text.form.errors.emailInvalid'))
      return errors
    },
    addPhone () {
      if (this.Phones.length > 9) return;
      this.Phones.push({ phone: "" })
    },
    addEmail () {
      if (this.Emails.length > 9) return;
      this.Emails.push({ email: "" })
    },
    deletePhone (index) {
      if (this.Phones.length > 1){
        this.Phones.splice(index, 1);
      }
    },
    deleteEmail (index) {
      if (this.Emails.length > 1){
        this.Emails.splice(index, 1);
      }
    },
    submit(e){
      e.preventDefault();
      // format phone and emails for json 
      var phones = this.Phones.reduce((cback, value)=>{return cback.concat(value.phone)},[]);
      var emails = this.Emails.reduce((cback, value)=>{return cback.concat(value.email)},[]);
      this.$v.$touch();
      if (this.$v.$invalid){
        return;
      }
      this.loading = true;
      const data = {
        'name': this.Name,
        'cnpj': this.Cnpj,
        'email': emails,
        'phone': phones,
        'address': {
          'address': this.Address,
          'state': this.State,
          'city': this.City,
          'postalCode': this.PostalCode,
        },
      };
      axios
        .post('http://localhost:3000/user-agent', data)
        .then(response => {
          if (response.status == 201 ){
            alert('Solicita????o de cadastro realizada com sucesso. Por favor, siga as instru????es fornecidadas no email e bem-vindo ao PCS!');
            this.$store.state.perfil = "UserAgent";
            this.$router.push('/');
          }
        })
        .catch(error => {
          console.error(error);
          alert('Erro ao realizar a solicita????o de cadastro.');
        })
        .finally(() => this.loading = false);
    },
    // Load informations for update
    loadInfo(){
      var cnpj = this.$store.state.cnpj;
      if (cnpj == null){ 
        this.$router.push('/'); 
      }
      cnpj = cnpj.replace(/[^0-9]/g, '')
      const defaultCnpj = cnpj;
      this.Cnpj = this.$store.state.cnpj;
      this.title = this.$t("userAgent");
      this.subtitle = this.$t("informations");
      axios
        .get(`http://localhost:3000/user-agent?cnpj=${defaultCnpj}`)
        .then(response => {
          if (response.status != 200 && this.isUpdating()){
            this.$router.push("/");
          }else if ((response.status == 200 && response.data.length > 0) && !this.isUpdating()){
            this.$router.push("/");
          }
          this.cnpjDisabled = true;
          this.Name = response.data[0].name;
          this.City = response.data[0].address.city;
          this.PostalCode = response.data[0].address.postalCode;
          this.State = response.data[0].address.state;
          this.Address = response.data[0].address.address;
          this.Phones = []
          response.data[0].phone.forEach(element => {this.Phones.push( {phone : element});})
          this.Emails = []
          response.data[0].email.forEach(element => {this.Emails.push( {email : element});})
        })
        .catch(
          error => {
            if (this.isUpdating()){
              this.$router.push("/");
            }
            this.cnpjDisabled = true;
          }
        );
    },
    isUpdating(){
      if (this.$route.path.toLowerCase() == '/useragent/update'){
        return true;
      }
      return false;
    }
  },
  mounted(){
    this.addEmail();
    this.addPhone();
    this.title = this.$t('userAgent');
    this.loadInfo()
    if (this.isUpdating()){
      this.subtitle = this.$t('update');
      this.btnSubmit = this.$t('update');
    }else{
      this.subtitle = this.$t('registration');
      this.btnSubmit = this.$t('create');
    }
  }
}
</script>

<style>

</style>