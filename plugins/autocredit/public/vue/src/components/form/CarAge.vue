<template>
    <div class="ml-2">
        <label class="label">Год выпуска</label>
        <select class="custom-select control-form" v-model="carYear">
            <option v-for="year in years">{{year}}</option>
        </select>
    </div>
</template>

<script>
    export default {
        data() {
            const years = [];
            for (let year = 2012; year <= 2019; year++) years.push(year);
            return {
                years
            }
        },
        computed: {
            carYear: {
                get() {
                    return this.$store.state.carYear;
                },
                set(val) {
                    this.$store.commit('UPDATE_CAR_YEAR', val)
                }
            }
        }
    }
</script>