<template>
    <div class="third-step">
        <transition name="fade">
            <thanks v-show="thanks"/>
        </transition>
        <div class="container" v-if="!success">
            <div class="alert alert-success mb-5" v-if="accepted">{{texts.success}}</div>
            <div class="alert alert-danger mb-5" v-else>{{texts.denied}}</div>
            <form @submit.prevent v-if="accepted" class="row">
                <phone class="col-lg-4"/>
                <city class="col-lg-4 col-md-6 col-sm-6 col-12">Город проведения сделки
                    <tooltip slot="tooltip" :title="texts.city_by_deal"/>
                </city>
                <div class="form-group col-lg-4 col-md-12 col-sm-12 col-12">
                    <brand></brand>
                </div>
                <dealership/>
                <datepicker v-model="dateDeal">Дата сделки</datepicker>
                <interval/>
                <div class="form-group col-lg-4 col-md-12 col-sm-12 col-12 d-flex align-items-end text-center justify-content-center">
                    <button class="button btn-yellow" @click.prevent="send">Записаться на сделку</button>
                </div>
                <dealerPhone/>
            </form>
        </div>
    </div>
</template>

<script>
    import Tooltip from './Tooltip.vue'
    import DealerPhone from './DealerPhone.vue'
    import Thanks from './Thanks.vue'

    import Phone from './form/Phone.vue'
    import City from './form/City.vue'
    import Brand from './form/Brand.vue'
    import Datepicker from './form/DatePicker.vue'
    import Dealership from './form/Dealership.vue'
    import Interval from './form/Interval.vue'

    import {mapState} from 'vuex'
    import helpers from '../helpers'

    export default {
        components: {
            Tooltip,
            Thanks,
            Phone,
            City,
            Brand,
            Datepicker,
            Dealership,
            Interval,
            DealerPhone,
        },
        data() {
            return {
                thanks: false
            }
        },
        computed: {
            ...mapState({
                success: state => state.statuses.success,
                accepted: state => state.statuses.accepted,
                texts: state => state.Data.texts
            }),
            dateDeal: {
                get() {
                    return this.$store.state.dateDeal
                },
                set(val) {
                    this.$store.commit('UPDATE_DATE_DEAL', val);
                }
            }
        },
        methods: {
            send(e) {
                let valid = true;
                valid = helpers.validateFields($('.second-step .input-validate'));
                helpers.scrollTop();
                if (valid) {
                    $(e.currentTarget).prop('disabled', true);
                    this.$store.dispatch('record').then((status) => {
                        if (status === 'ok') {
                            this.$bus.emit('circleDone', 3);
                            this.$bus.emit('circleActive', 0);
                            this.thanks = true;
                        }
                    })
                }
            }
        }
    }
</script>