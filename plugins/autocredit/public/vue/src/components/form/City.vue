<template>
    <div class="form-group">
        <label class="label">
            <slot></slot>
            <slot name="tooltip"></slot>
        </label>
        <select :value="city" @change="update" class="custom-select control-form input-validate">
            <option v-for="(item, key) in cities" :value="key">{{item.name}}</option>
        </select>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                cities: this.$store.state.Data.cities,
            }
        },
        computed: {
            city() {
                return this.$store.state.city;
            }
        },
        methods: {
            update(e) {
                this.$store.commit('UPDATE_CITY', e.target.value)
            }
        }
    }
</script>