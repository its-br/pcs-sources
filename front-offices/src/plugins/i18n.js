// import Vue from 'vue'
// import VueI18n from 'vue-i18n'
// Vue.use(VueI18n)
// import store from '../store'
// import pt from '@/locale/pt.json'
// import en from '@/locale/en.json'
// const translation = {
//   pt: pt,
//   en: en,
// }
// const i18n = new VueI18n({
//   locale: pt, // set locale
//   messages: translation, // set locale messages
// })

// // store.commit('SET_TRANSLATION', translation)

// export default i18n



// =========================
import Vue from "vue";
import VueI18n from "vue-i18n";
import pt from '@/locale/pt.json'
import en from '@/locale/en.json'
Vue.use(VueI18n);

function loadLocaleMessages() {
  const locales = require.context(
    "../locale",
    true,
    /[A-Za-z0-9-_,\s]+\.json$/i
  );
  const messages = {};
  locales.keys().forEach((key) => {
    const matched = key.match(/([A-Za-z0-9-_]+)\./i);
    if (matched && matched.length > 1) {
      const locale = matched[1];
      messages[locale] = locales(key);
    }
  });
  return messages;
};
const translation = {
  en: en,
  pt: pt,
};
export default new VueI18n({
  locale: process.env.VUE_APP_I18N_LOCALE || navigator.language.substr(0, 2),
  fallbackLocale: process.env.VUE_APP_I18N_FALLBACK_LOCALE || "en",
  // messages: loadLocaleMessages(),
  messages: translation,
});