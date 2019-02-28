<template>
    <main class="content" role="main">
        <navigation/>
        <div class="first-step container">
            <div class="check-calculator mx-auto">
                <button @click="formToggle" data-form="0" class="btn-check-calculator active">По стоимости <br>авто
                    <tooltip :title="texts.by_price" position="bottom"></tooltip>
                </button>
                <button @click="formToggle" data-form="1" class="btn-check-calculator">По ежемесячному платежу
                    <tooltip :title="texts.by_month" position="bottom"></tooltip>
                </button>
            </div>
            <div class="calc-cost-auto">
                <div class="row">
                    <div class="col-lg-8 col-xl-8">
                        <form class="row">
                            <city class="col-lg-4 col-xl-6 col-md-5">Город
                                <tooltip slot="tooltip" :title="texts.city"/>
                            </city>
                            <div class="form-group col-lg-8 col-xl-6 col-md-7">
                                <div class="d-flex car-select">
                                    <div class="w-100">
                                        <brand/>
                                    </div>
                                    <CarAge/>
                                </div>
                            </div>
                            <div class="form-group col-lg-4 col-xl-6 col-md-5">
                                <label class="label">Стоимость авто, руб </label>
                                <input type="text" class="control-form" v-model="byPrice.sum"
                                       :placeholder="`Не меньше ${formatLocale(byPrice.sumComputed)}`">
                            </div>
                            <div class="form-group col-lg-8 col-xl-6 col-md-7"
                                 :class="{error:byPrice.startComputed>parseLocale(byPrice.start)}">
                                <label class="label">Первоначальный взнос, руб / %
                                    <tooltip :title="texts.first_pay" :absolute="true"></tooltip>
                                </label>
                                <div class="d-flex align-items-end">
                                    <div class="w-100">
                                        <input type="text" class="control-form" v-model="byPrice.start"
                                               :placeholder="`Не меньше ${formatLocale(byPrice.startComputed)}`">
                                    </div>
                                    <div class="ml-2">
                                        <div class="field-output sm justify-content-center">
                                            {{(byPrice.startComputed/byPrice.sumComputed)*100|percent}} %
                                        </div>
                                    </div>
                                </div>
                                <div class="error-text error-calc">{{`Не меньше
                                    ${formatLocale(byPrice.startComputed)}`}}
                                </div>
                            </div>
                            <div class="form-group col-lg-4 col-xl-6 col-md-5">
                                <label class="label">Срок кредита
                                    <tooltip :title="texts.duration"></tooltip>
                                </label>
                                <select class="custom-select control-form" v-model="byPrice.duration">
                                    <option v-for="duration in [12,24,36,48,60]">{{duration}}</option>
                                </select>
                            </div>
                            <div class="form-group disabled col-lg-8 col-xl-6 col-md-7">
                                <div class="d-flex align-items-end">
                                    <div class="w-100">
                                        <label class="label">Последний платеж, руб
                                            <tooltip :title="texts.last_pay"></tooltip>
                                        </label>
                                        <input type="text" class="control-form" v-model="byPrice.last" disabled>
                                    </div>
                                    <div class="ml-2" style="visibility: hidden">
                                        <div class="field-output sm justify-content-center">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4 col-xl-4 calculator-output">
                        <div class="field-output flex-column justify-content-center align-items-start">
                            <div>
                                <label class="label">Ежемесячный платеж</label>
                                <div class="sub-title">{{creditByPrice|price}} руб</div>
                            </div>
                            <div class="mt-3">
                                <label class="label">Ставка, годовых</label>
                                <div class="sub-title">{{byPricePercent|percent}} %</div>
                            </div>
                        </div>
                        <div class="text-center text-lg-left">
                            <a :href="$store.state.Data.banks.vtb.link" class="text-muted">прочие условия по
                                автокредиту</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="calc-cost-pay">
                <div class="row">
                    <div class="col-lg-8 col-xl-8">
                        <form class="row">
                            <city class="col-lg-4 col-xl-6 col-md-5">Город
                                <tooltip slot="tooltip" :title="texts.city"/>
                            </city>
                            <div class="form-group col-lg-8 col-xl-6 col-md-7">
                                <div class="d-flex car-select">
                                    <div class="w-100">
                                        <brand/>
                                    </div>
                                    <CarAge></CarAge>
                                </div>
                            </div>
                            <div class="form-group col-lg-4 col-xl-6 col-md-5">
                                <label class="label">Ежемесячный платеж, руб </label>
                                <input type="text" class="control-form" v-model="byPayment.pay"
                                       :placeholder="byPayment.payMin|price">
                            </div>
                            <div class="form-group col-lg-8 col-xl-6 col-md-7">
                                <label class="label">Первоначальный взнос, руб / %
                                    <tooltip :title="texts.first_pay" :absolute="true"></tooltip>
                                </label>
                                <div class="d-flex align-items-end">
                                    <div class="w-100">
                                        <input type="text" class="control-form" v-model="byPayment.start"
                                               :placeholder="byPayment.startComputed|price">
                                    </div>
                                    <div class="ml-2">
                                        <div class="field-output sm justify-content-center">
                                            {{(byPayment.startComputed/creditByPayment)*100|startPercent}}
                                            %
                                        </div>
                                    </div>
                                </div>
                                <div class="error-text position-absolute">{{`Не меньше
                                    ${formatLocale(byPayment.startComputed)}`}}
                                </div>
                            </div>
                            <div class="form-group col-lg-4 col-xl-6 col-md-5">
                                <label class="label">Срок кредита
                                    <tooltip :title="texts.duration"></tooltip>
                                </label>
                                <select class="custom-select control-form" v-model="byPayment.duration">
                                    <option v-for="duration in [12,24,36,48,60]">{{duration}}</option>
                                </select>
                            </div>
                            <div class="form-group disabled col-lg-8 col-xl-6 col-md-7">
                                <div class="d-flex align-items-end">
                                    <div class="w-100">
                                        <label class="label">Последний платеж, руб
                                            <tooltip :title="texts.last_pay"></tooltip>
                                        </label>
                                        <input type="text" class="control-form" v-model="byPayment.last" disabled>
                                    </div>
                                    <div class="ml-2" style="visibility: hidden">
                                        <div class="field-output sm justify-content-center">
                                            20%
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4 col-xl-4 calculator-output">
                        <div class="field-output flex-column justify-content-center align-items-start">
                            <div>
                                <label class="label">Стоимость автомобиля</label>
                                <div class="sub-title">{{creditByPayment|price}} руб</div>
                            </div>
                            <div class="mt-3">
                                <label class="label">Ставка, годовых</label>
                                <div class="sub-title">{{byPayment.percent|percent}} %</div>
                            </div>
                        </div>
                        <a :href="$store.state.Data.banks.vtb.link" class="text-muted">прочие условия по автокредиту</a>
                    </div>
                </div>
            </div>
            <div class="col-12 text-center mt-4" v-if="!(denied||success)">
                <button class="button btn-yellow" @click.prevent="toRequest">перейти к заявке</button>
            </div>
            <dealerPhone/>
        </div>
        <request/>
        <record/>
    </main>
</template>

<script>
    import Navigation from './components/Navigation.vue';
    import Request from './components/Request.vue';
    import Record from './components/Record.vue';
    import Tooltip from './components/Tooltip.vue';

    import City from './components/form/City.vue';
    import Brand from './components/form/Brand.vue';
    import CarAge from './components/form/CarAge.vue';
    import DealerPhone from './components/DealerPhone.vue';

    import {mapState} from 'vuex'
    import helpers from './helpers'

    export default {
        components: {
            Navigation,
            Request,
            Record,
            City,
            Brand,
            DealerPhone,
            CarAge,
            Tooltip,
        },
        data() {
            return {
                banks: {
                    vtb: {
                        sumMin: 100000,
                        sumMax: 3000000,
                        startMin: 20,
                        terms: [12, 24, 36, 48, 60],
                        age: 9
                    }
                },
                byPrice: {
                    sumMin: 100000,
                    sum: null,
                    sumComputed: null,
                    startMin: 20,
                    start: null,
                    startComputed: null,
                    last: null,
                    lastComputed: null,
                    duration: 36
                },
                byPayment: {
                    payMin: 5000,
                    pay: null,
                    payComputed: null,
                    startMin: 20,
                    start: '',
                    startComputed: null,
                    last: null,
                    duration: 36,
                    percent: 10,
                    age: 2019
                },
                calculator: 0
            }
        },
        computed: {
            ...mapState({
                accepted: state => state.statuses.accepted,
                success: state => state.statuses.success,
                denied: state => state.statuses.denied,
                texts: state => state.Data.texts
            }),
            creditByPrice() {
                let sum = this.byPrice.sumComputed - this.byPrice.startComputed,
                    monthly = helpers.annuity(sum, this.byPrice.duration, this.byPricePercent);
                /* if (this.byPrice.last) {
                     let last = this.parseLocale(this.byPrice.last);
                     if (last > price) {
                         price -= (last - price) / this.byPrice.duration;
                     }
                 }*/
                return monthly;
            },
            creditByPayment() {
                // calculating false price for percent
                let fullPrice = this.byPayment.payComputed,
                    falseStart = this.byPaymentStart(fullPrice),
                    percent = null;
                fullPrice *= this.byPayment.duration;
                console.log(fullPrice + falseStart)
                if (fullPrice + falseStart < 800000) {
                    percent = 9.9;
                    if ((2019 - this.$store.state.carYear) <= 4) {
                        this.byPayment.startMin = this.banks.vtb.startMin;
                    } else {
                        this.byPayment.startMin = 30;
                    }
                } else {
                    this.byPayment.startMin = this.banks.vtb.startMin;
                    percent = 8.9;
                }

                this.byPayment.percent = percent;

                //start calculating real price
                let price = helpers.annuity(fullPrice / this.byPayment.duration, this.byPayment.duration, percent, true),
                    start = this.byPaymentStart(price);

                start = start > this.parseLocale(this.byPayment.start) ? start : this.parseLocale(this.byPayment.start);
                this.byPayment.startComputed = start;

                price += start;
                price = parseInt(price);
                return price;
            },
            byPricePercent() {
                if (this.byPrice.sumComputed - this.byPrice.startComputed < 800000) {
                    if ((2019 - this.$store.state.carYear) <= 4) {
                        this.byPrice.startMin = this.banks.vtb.startMin;
                        return 9.9;
                    } else {
                        this.byPrice.startMin = 30;
                        return 9.9;
                    }
                } else {
                    this.byPrice.startMin = this.banks.vtb.startMin;
                    return 8.9;
                }
            },
        },
        watch: {
            'byPrice.sum'(val) {
                val = this.parseLocale(val);
                let sum = val;
                if (val < this.byPrice.sumMin || isNaN(val)) {
                    sum = this.byPrice.sumMin;
                }
                this.byPrice.sumComputed = sum;
                let startMin = sum * (this.byPrice.startMin / 100);
                this.byPrice.start = this.formatLocale(startMin);
                this.byPrice.sum = val !== 0 ? this.formatLocale(val) : '';
            },
            'byPrice.start'(val) {
                val = this.parseLocale(val);
                let min = this.byPrice.sumComputed * (this.byPrice.startMin / 100);
                if (!(val < min || isNaN(val))) {
                    min = val;
                }
                this.byPrice.startComputed = min;
                this.byPrice.start = val !== 0 ? this.formatLocale(val) : '';
            },
            'byPrice.startMin'(val) {
                let startMin = this.byPrice.sumComputed * (val / 100);
                this.byPrice.start = this.formatLocale(startMin);
            },
            //
            'byPayment.pay'(val) {
                val = this.parseLocale(val);
                let pay = val;
                if (val < this.byPayment.payMin || isNaN(val)) {
                    pay = this.byPayment.payMin;
                }
                this.byPayment.payComputed = pay;
                //let startMin = pay * (this.byPrice.startMin / 100);
                // this.byPrice.start = this.formatLocale(startMin);
                this.byPayment.pay = val !== 0 ? this.formatLocale(val) : '';
            },
            'byPayment.start'(val) {
                val = this.parseLocale(val);
                /*   let min = this.byPrice.sumComputed * (this.byPrice.startMin / 100);
                   if (!(val < min || isNaN(val))) {
                       min = val;
                   }*/
                this.byPayment.startComputed = val ? val : 0;
                this.byPayment.start = val !== 0 ? this.formatLocale(val) : '';
            },
        },
        methods: {
            toRequest() {
                if (this.accepted) {
                    this.$bus.emit('circleDone', 2);
                    this.$bus.emit('circleActive', 3);
                    $('.first-step').fadeOut(400, () => {
                        $('.third-step').fadeIn();
                    });
                } else {
                    this.$bus.emit('circleDone', 1);
                    this.$bus.emit('circleActive', 2);
                    $('.first-step').fadeOut(400, () => {
                        $('.second-step').fadeIn();
                    });
                }
                helpers.scrollTop();
                this.$store.commit('UPDATE_PRICE', this.calculator === 0 ? this.byPrice.sumComputed : this.creditByPayment);
            },
            vtbPercent(price) {
                let percent = 8.9;
                if (price < 800000) {
                    if ((2019 - this.$store.state.carYear) <= 4) {
                        this.byPayment.startMin = this.banks.vtb.startMin;
                        percent = 9.9;
                    } else {
                        this.byPayment.startMin = 30;
                        percent = 9.9;
                    }
                } else {
                    this.byPayment.startMin = this.banks.vtb.startMin;
                    percent = 8.9;
                }
            },
            byPaymentStart(price) {
                return price * (this.byPayment.startMin / 100) / ((100 - this.byPayment.startMin) / 100)
            },
            // format methods
            formatLocale(value) {
                value += "";
                const val = value.replace(/ /g, '');
                return parseFloat(val).toLocaleString('en-US', {
                    style: 'decimal',
                    maximumFractionDigits: 0,
                    minimumFractionDigits: 0
                }).replace(/,/g, ' ');
            },
            parseLocale(value) {
                return value !== '' ? Math.abs(parseInt(value.replace(/ /g, ''))) : 0;
            },
            byPriceText() {
                return `Стоимость ${this.formatLocale(this.byPrice.sumComputed)} рублей<br>
                        Ежемесячный платеж ${this.formatLocale(this.creditByPrice)}<br>
                        Первоначальный взнос ${this.formatLocale(this.byPrice.startComputed)} рублей<br>
                        Срок кредита ${this.formatLocale(this.byPrice.duration)} месяцев.`
            },
            byPaymentText() {
                return `Стоимость ${this.formatLocale(this.creditByPayment)} рублей<br>
                        Ежемесячный платеж ${this.formatLocale(this.byPayment.payComputed)}<br>
                        Первоначальный взнос ${this.formatLocale(this.byPayment.startComputed)} рублей<br>
                        Срок кредита ${this.formatLocale(this.byPayment.duration)} месяцев.`
            },
            // additional methods
            formToggle(e) {
                let $this = $(e.currentTarget),
                    form = $this.data('form');
                $('.btn-check-calculator').removeClass('active');
                $($this).addClass('active');
                this.calculator = form;
                if (form === 0) {
                    this.$store.commit('UPDATE_PRICE', this.byPrice.sumComputed);
                    $('.calc-cost-pay').fadeOut(400, () => {
                        $('.calc-cost-auto').fadeIn();
                    });
                } else {
                    this.$store.commit('UPDATE_PRICE', this.creditByPayment);
                    $('.calc-cost-auto').fadeOut(400, () => {
                        $('.calc-cost-pay').fadeIn();
                    });
                }
            }
        },
        filters: {
            price(val) {
                val = parseInt(val / 100) * 100;
                let c = 0,
                    d = " ",
                    t = " ",
                    s = '',
                    i = String(parseInt(val = Math.abs(Number(val) || 0).toFixed(c))),
                    j = i.length;

                j = j > 3 ? j % 3 : 0;

                return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(val - i).toFixed(c).slice(2) : "");
            },
            percent(val) {
                val = Number(val) === val && val % 1 !== 0 ? val.toFixed(1) : val;
                return val.toString().replace(".", ",")
            },
            startPercent(val) {
                val = Number(val) === val && val % 1 !== 0 ? val.toFixed(0) : val;
                return val.toString().replace(".", ",")
            }
        },
        created() {
            // setup prices
            this.byPrice.sum = this.formatLocale(1000000);
            this.byPrice.sumComputed = this.byPrice.sumMin;
            this.byPrice.start = this.formatLocale(this.byPrice.sumMin * this.byPrice.startMin);
            this.byPrice.percent = this.vtbPercent;
            //
            this.byPayment.pay = this.formatLocale(25403);
            this.byPayment.payComputed = this.byPayment.payMin;
            // this.byPayment.start = this.formatLocale(this.byPayment.sumMin * this.byPayment.startMin);
        },
        mounted() {
            $('.first-step input').on('keydown', function (e) {
                if (e.which === 13) {
                    $(this).closest('.form-group').next().find('input, select').focus();
                }
            });
        }
    }
</script>