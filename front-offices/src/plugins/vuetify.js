import Vue from 'vue';
import Vuetify from 'vuetify/lib';
import colors from 'vuetify/lib/util/colors'
import en from "vuetify/es5/locale/en";
import pt from "vuetify/es5/locale/pt";

Vue.use(Vuetify);


export default new Vuetify({
  lang: {
    locales: {en, pt},
    current: 'pt',
    // current: process.env.VUE_APP_I18N_LOCALE || navigator.language.substr(0, 2),
  },
  theme: {
    options: { customProperties: true },
    dark: null,
      themes: {
        dark: {
          primary: colors.blueGrey.lighten1, 
          // primary: colors.blue.darken1, 
          // secondary: colors.orange.base, 
          // accent: colors.indigo.base, 
          
          // Custom colors
          bgmain: colors.blueGrey.lighten4, 
          bgfooter: colors.blueGrey.lighten2, 
          kanbancols: colors.blueGrey.darken1, 
        },
        light: {
          primary: colors.blue.darken1, 
          secondary: colors.amber.base, 
          accent: colors.indigo.base, 
          
          // Custom colors
          bgmain: colors.blueGrey.lighten5, 
          bgfooter: colors.blueGrey.lighten4, 
          kanbancols: colors.blue.lighten4, 
        },
      },
    },    
});
