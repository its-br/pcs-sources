<template>
  <v-app>
    <router-view/>
  </v-app>
</template>

<script>
import axios from "axios"
  export default {
    name: 'App',
    data () {
      return {
      }
    },
    created(){
      this.setAxiosDefaultHeaders();
    },
    methods:{
      setAxiosDefaultHeaders(){
        if ( this.$store.state.accessToken != null )
          axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.$store.state.accessToken
        if ( this.$store.state.PCSAuthorization != null )
          axios.defaults.headers.common['PCSAuthorization'] = this.$store.state.PCSAuthorization
        axios.defaults.headers.common['Accept'] = 'application/json'
      }
    }
  };
</script>
<style >
* a {
  text-decoration:none ;
}
/* * { outline: 2px dotted red }
* * { outline: 2px dotted green }
* * * { outline: 2px dotted orange }
* * * * { outline: 2px dotted blue }
* * * * * { outline: 1px solid red }
* * * * * * { outline: 1px solid green }
* * * * * * * { outline: 1px solid orange }
* * * * * * * * { outline: 1px solid blue } */

.opacity-90{
  filter: opacity(90%);
}
.opacity-80{
  filter: opacity(80%);
}
.opacity-70{
  filter: opacity(70%);
}
.opacity-60{
  filter: opacity(60%);
}
.opacity-50{
  filter: opacity(50%);
}
.opacity-40{
  filter: opacity(40%);
}
.opacity-30{
  filter: opacity(30%);
}
.opacity-20{
  filter: opacity(20%);
}
.opacity-10{
  filter: opacity(10%);
}
</style>