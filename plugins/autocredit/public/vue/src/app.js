import Vue from 'vue'
import App from './App.vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import Storage from 'vue-ls';
import VueBus from 'vue-bus';
import store from './store'

axios.interceptors.response.use(
    res => res,
    error => {
        return Promise.reject(error.response)
    }
);

let options = {
    namespace: 'vuejs__',
    name: 'ls',
    storage: 'local',
};

Vue.use(Storage, options);

const VueInputMask = require('vue-inputmask').default;

Vue.use(VueInputMask);
Vue.use(VueAxios, axios);
Vue.use(VueBus);

Vue.config.productionTip = false;
/*
Vue.config.devtools = false
Vue.config.debug = false
Vue.config.silent = true
*/
new Vue({
    el: '#app',
    store,
    render: h => h(App),
    beforeCreate() {
        this.$store.commit('UPDATE_NAME', this.$ls.get('name', ''));
        this.$store.commit('UPDATE_PHONE', this.$ls.get('phone'));
        this.$store.commit('UPDATE_EMAIL', this.$ls.get('email'));
        this.$store.commit('UPDATE_BRAND', this.$ls.get('brand', Object.keys(this.$store.state.Data.brands)[0]));
        this.$store.commit('UPDATE_CAR_YEAR', this.$ls.get('carYear', 2017));
        this.$store.commit('UPDATE_CITY', this.$ls.get('city', this.$store.state.Data.city));
        this.$store.commit('UPDATE_PASSPORT', this.$ls.get('passport'));
        this.$store.commit('UPDATE_DATE_BIRTH', this.$ls.get('dateBirth'));
        this.$store.commit('UPDATE_DATE_PASSPORT', this.$ls.get('datePassport'));

        let today = new Date(),
            tomorrow = new Date();
        tomorrow.setDate(today.getDate() + 1);
        tomorrow = tomorrow.toISOString().slice(0, 10).replace(/-/g, "-");
        this.$store.commit('UPDATE_DATE_DEAL', this.$ls.get('dateDeal', tomorrow));

        if (this.$ls.get('limit')) {
            this.$store.commit('LIMIT');
        }
        this.$store.commit('UPDATE_DEALERSHIP', this.$store.getters.dealerships[0].id);
        this.$store.commit('UPDATE_INTERVAL', this.$ls.get('interval', this.$store.state.Data.intervals[0]));
    }
});
