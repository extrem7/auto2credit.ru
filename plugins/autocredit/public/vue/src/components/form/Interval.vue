<template>
    <div class="form-group col-lg-4 col-md-6 col-sm-6 col-12">
        <label class="label">Время сделки</label>
        <select v-model="interval" class="custom-select control-form">
            <option v-for="time in intervals" v-model="interval">{{time}}</option>
        </select>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                intervals: this.$store.state.Data.intervals
            }
        },
        computed: {
            interval: {
                get() {
                    return this.$store.state.interval;
                },
                set(val) {
                    this.$store.commit('UPDATE_INTERVAL', val)
                }
            }
        }
    }
</script>