<template>
  <v-layout align-center justify-center>
    <v-col cols="12" sm="10" lg="8">
    <v-card light>
      <v-card-title class="text-h5">Add User Agent</v-card-title>
      <v-card-text>
        <v-form ref="form" v-model="valid" lazy-validation>
          <v-text-field v-model="Name" label="Name" required></v-text-field>
          <v-text-field v-model="Cnpj" label="Cnpj" required></v-text-field>
          <v-row class="justify-center">
            <v-btn class="ma-2 secondary">Clean</v-btn>
            <v-btn class="ma-2 primary">Add</v-btn>
          </v-row>
        </v-form>
      </v-card-text>
    </v-card>
    </v-col>
  </v-layout>
</template>

<script>
export default {
    name:"AddUserAgentForm"
}
</script>

<style>

</style>