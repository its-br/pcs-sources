import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'

Vue.use(Vuex);
function initialState () {
  return { 
    frontOfficeName: null,
    cnpj: null,
    razaoSocial: null,
    profile: null,
    step1: null,
    step2: new Array(), 
    step2_index: 0,
    step3: new Array(),
  }
}

const store = new Vuex.Store({
  state: initialState,
  mutations: {
    clearAll (state) {
      state.cnpj = null;
      state.razaoSocial = null;
      state.profile = null;
      state.PCSAuthorization = null
      state.accessToken = null
      state.refreshToken = null
      state.idToken = null      
    },
    setCnpj (state, cnpj) {
      state.cnpj = cnpj;
    },
    setRazaoSocial (state, razaoSocial) {
      state.razaoSocial = razaoSocial;
    },
    setProfile (state, profile) {
      state.profile = profile;
    },
    setAccessToken (state, accessToken) {
      state.accessToken = accessToken;
    },
    setRefreshToken (state, refreshToken) {
      state.refreshToken = refreshToken;
    },
    setIDToken (state, idToken) {
      state.idToken = idToken;
    },
    setPCSAuthorization (state, jwt) {
      state.PCSAuthorization = jwt;
    },
     /* Voyage Create */
    addTransportcall (state, transportcall) {
      state.step2.push(transportcall)
    },
    DeleteTransportcall (state, index) {
      state.step2.splice(index,1)
    },
    addMaritimeAgency (state, maritimeagency) {
      state.step3.push(maritimeagency)
    },
    DeleteMaritimeAgency (state, index) {
      state.step3.splice(index,1)
    }
  },
  plugins: [
    createPersistedState({
      storage: window.localStorage
    })
  ]
});

export default store;