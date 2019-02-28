<template>
    <div>
        <label class="label">Марка машины</label>
        <select name="car-model" v-model="brand" class="custom-select control-form">
            <option v-for="(name, key) in brands" :value="key">{{name}}</option>
        </select>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                brands: this.$store.state.Data.brands
            }
        },
        computed: {
            brand: {
                get() {
                    return this.$store.state.brand;
                },
                set(val) {
                    this.$store.commit('UPDATE_BRAND', val)
                }
            }
        }
    }
</script>