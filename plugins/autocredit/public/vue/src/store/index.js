import Vue from 'vue'
import Vuex from 'vuex'
import mutations from './mutations'
import getters from './getters'
import actions from './actions'
import statuses from './modules/statuses'
import helpers from '../helpers'

Vue.use(Vuex);

const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    state: {
        Data,
        apiUrl: AdminAjax,// plugin ajax api url
        name: '',
        phone: '',
        email: '',
        brand: null,
        carYear: null,
        city: null,
        passport: '',
        dateBirth: null,
        datePassport: null,
        dateDeal: null,
        price: 0,
        dealership: null,
        interval: null
    },
    mutations,
    getters,
    actions,
    modules: {
        statuses
    },
    strict: debug
})