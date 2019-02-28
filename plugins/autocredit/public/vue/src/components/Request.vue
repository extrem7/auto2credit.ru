<template>
    <div class="second-step">
        <transition name="fade">
            <timer :timer="timer" v-show="showTimer"></timer>
        </transition>
        <div class="container">
            <div class="alert alert-warning mb-5" v-if="validation">{{texts.warning}}</div>
            <div class="alert alert-warning mb-5" v-if="limit">{{texts.ip_limit}}</div>
            <form @submit.prevent v-if="!limit&&!exbico" class="row">
                <city class="col-lg-3 col-md-6 col-sm-6 col-12">Город проведения сделки
                    <tooltip slot="tooltip" :title="texts.city_by_deal"/>
                </city>
                <name/>
                <phone class="col-lg-3"/>
                <email/>
                <datepicker v-model="dateBirth" :max="minAge">Дата рождения</datepicker>
                <passport/>
                <datepicker v-model="datePassport">Дата выдачи паспорта</datepicker>
                <confirm/>
                <div class="col-12 text-center mt-4">
                    <button class="button btn-yellow" @click.prevent="api">отправить заявку</button>
                </div>
            </form>
            <dealerPhone/>
        </div>
    </div>
</template>

<script>
    import Name from './form/Name.vue';
    import Phone from './form/Phone.vue';
    import Email from './form/Email.vue';
    import City from './form/City.vue';
    import Passport from './form/Passport.vue';
    import DealerPhone from './DealerPhone.vue';
    import Timer from './Timer.vue';
    import Tooltip from './Tooltip.vue';
    import Datepicker from './form/DatePicker.vue';
    import Confirm from './form/Confirm.vue';

    import {mapState} from 'vuex';
    import helpers from '../helpers.js'

    export default {
        components: {
            Name,
            Phone,
            Email,
            City,
            Passport,
            DealerPhone,
            Timer,
            Tooltip,
            Datepicker,
            Confirm
        },
        data() {
            const minAge = new Date(new Date().setFullYear(new Date().getFullYear() - 18)).toISOString().split('T')[0];
            return {
                timer: 5,
                minAge,
                showTimer: false,
            }
        },
        computed: {
            ...mapState({
                exbico: state => state.statuses.exbico,
                validation: state => state.statuses.validation,
                limit: state => state.statuses.limit,
                texts: state => state.Data.texts
            }),
            dateBirth: {
                get() {
                    return this.$store.state.dateBirth
                },
                set(val) {
                    this.$store.commit('UPDATE_DATE_BIRTH', val);
                }
            },
            datePassport: {
                get() {
                    return this.$store.state.datePassport
                },
                set(val) {
                    this.$store.commit('UPDATE_DATE_PASSPORT', val);
                }
            },
        },
        methods: {
            api() {
                let valid = true;

                if (this.$store.getters.nameValid) {
                    $('.second-step .name-input').parent().removeClass('error');
                } else {
                    $('.second-step .name-input').parent().addClass('error');
                    valid = false;
                }

                let required = helpers.validateFields($('.second-step .input-validate'));

                valid = valid ? required : false;

                if (!document.querySelector('.second-step .accept').reportValidity()) valid = false;

                if (valid) {
                    helpers.scrollTop();
                    this.showTimer = true;
                    const timer = setInterval(() => {
                        this.timer = this.timer > 0 ? this.timer - 1 : 5;
                    }, 1000);
                    this.$store.dispatch('exbico').then(status => {
                        clearInterval(timer);
                        this.showTimer = false;
                        this.$bus.emit('circleDone', 2);
                        this.$bus.emit('circleActive', 3);
                        $('.second-step').fadeOut(() => {
                            $('.third-step').fadeIn();
                        });
                    }, err => {
                        this.showTimer = false;
                        this.$bus.emit('circleError');
                        if (err === 401 || err === 405) {
                            this.toggleForms();
                        }
                    })
                } else {
                    let el = document.querySelector('.second-step .error').getBoundingClientRect();
                    helpers.scrollTop(el.top + window.scrollY - 60);
                }
            },
            toggleForms() {
                this.$bus.emit('circleActive', 3);
                $('.second-step').fadeOut(() => {
                    $('.third-step').fadeIn();
                });
            }
        }
    }
</script>

<style>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }

    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
</style>