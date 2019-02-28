import Vue from "vue";
import * as types from './mutation-types';

export default {
    exbico({state, commit, getters}) {
        return new Promise((resolve, reject) => {
            Vue.axios.post(state.apiUrl, $.param({
                action: 'exbico',
                ...getters.personalData,
                //   byPrice: this.byPriceText(),
                //  byPayment: this.byPaymentText()
            })).then(res => {
                let status = res.data.status;
                if (status === 'ok') {
                    commit(types.EXBICO);
                    if (status === 'ok') {
                        commit(types.ACCEPTED);
                    }
                } else if (status === 'validation_error') {
                    commit(types.VALIDATION);
                }
                resolve(status);
            }, err => {
                let status = err.status;
                if (status === 405) {
                    commit(types.EXBICO);
                    commit(types.DENIED)
                }
                else if (status === 429) commit(types.LIMIT);
                else if (status === 401) commit(types.DENIED);
                reject(status);
            })
        })
    },
    record({state, commit, getters}) {
        return new Promise((resolve) => {
            Vue.axios.post(state.apiUrl, $.param({
                action: 'order',
                ...getters.personalData,
                dealership: {
                    id: state.dealership,
                    title: getters.dealerships.find((el) => {
                        return el.id === state.dealership
                    }).title
                },
                dateDeal: state.dateDeal,
                time: state.interval,
                // byPrice: this.byPriceText(),
                // byPayment: this.byPaymentText()
            })).then((res) => {
                let status = res.data.status;
                if (status === 'ok') {
                    commit(types.SUCCESS);
                }
                resolve(status);
            });
        });
    }
}