<template>
  <v-container flex>
    <AddUserAgentForm />
  </v-container>
</template>

<script>
  import AddUserAgentForm from '@/components/UserAgent/AddUserAgentForm'
  export default {
    name: 'AddUserAgent',
    components :{
      AddUserAgentForm
    }
  }
</script>

<style>

</style>