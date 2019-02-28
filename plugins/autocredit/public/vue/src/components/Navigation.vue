<template>
    <div class="circle-container">
        <div class="container">
            <div class="title mb-4">расчёт автокредита</div>
            <div class="d-flex align-items-center justify-content-between mx-auto">
                <div class="circle-item first-circle" :class="{active:active===1,done:done>0}" @click="open">
                    <div class="circle">
                        <div class="number">1</div>
                        <div class="circle-inner-title">расчёт</div>
                    </div>
                    <div class="circle-title">Расчёт</div>
                </div>
                <div class="custom-arrow active">
                    <span></span><span></span><span></span><span></span><i class="fa fa-chevron-right"></i>
                </div>
                <div class="circle-item second-circle" :class="{active:active===2,done:done>1,error}">
                    <div class="circle">
                        <div class="number">2</div>
                        <div class="circle-inner-title">Заявка
                            <tooltip :title="Data.texts.order" :absolute="true"></tooltip>
                        </div>
                    </div>
                    <div class="circle-title">Заявка
                        <tooltip :title="Data.texts.order"></tooltip>
                    </div>
                </div>
                <div class="custom-arrow" :class="{active:active===3}">
                    <span></span><span></span><span></span><span></span><i class="fa fa-chevron-right"></i>
                </div>
                <div class="circle-item third-circle" :class="{active:active===3,done:done>2,error}">
                    <div class="circle">
                        <div class="number">3</div>
                        <div class="circle-inner-title">Запись <br>на сделку
                            <tooltip :title="Data.texts.deal" :absolute="true"></tooltip>
                        </div>
                    </div>
                    <div class="circle-title">Запись <br>на сделку
                        <tooltip :title="Data.texts.deal"></tooltip>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import tooltip from './Tooltip.vue';

    export default {
        components: {
            tooltip
        },
        data() {
            return {
                Data: Data,
                active: 1,
                done: 0,
                error: false
            }
        },
        methods: {
            open() {
                if (this.active !== 1) {
                    this.active = 0;
                    $('.second-step,.third-step').fadeOut(400, () => {
                        $('.first-step').fadeIn();
                        this.active = 1;
                    });
                }
            }
        },
        created() {
            this.$bus.on('circleActive', active => {
                this.active = active
            });
            this.$bus.on('circleDone', done => {
                this.done = done
            });
            this.$bus.on('circleError', () => {
                this.error = true
            });
        }
    }
</script>