import Vue from 'vue'
import * as types from '../mutation-types'

export default {
    state: {
        exbico: false,
        accepted: false,
        denied: false,
        validation: false,
        limit: false,
        success: false,
    },
    mutations: {
        [types.EXBICO](state) {
            state.exbico = true;
        },
        [types.ACCEPTED](state) {
            state.accepted = true;
        },
        [types.DENIED](state) {
            state.denied = true;
        },
        [types.VALIDATION](state) {
            state.validation = true;
        },
        [types.LIMIT](state) {
            state.limit = true;
            Vue.ls.set('limit', true);
        },
        [types.SUCCESS](state) {
            state.success = true;
        }
    }
}