import Vue from 'vue';
import VueI18n from 'vue-i18n';
import messages from './Locales';

Vue.use(VueI18n);

console.log(process.env.VUE_APP_I18N_FALLBACK_LOCALE);
const i18n = new VueI18n({
    locale: process.env.VUE_APP_I18N_FALLBACK_LOCALE || 'en',
    messages
});

export default i18n;