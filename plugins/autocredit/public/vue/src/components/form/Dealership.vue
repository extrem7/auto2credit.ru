<template>
    <div class="form-group col-12">
        <label class="label">Название и адрес дилерского центра
            <tooltip :title="$store.state.Data.texts.dealer_center"></tooltip>
        </label>
        <select name="car-model" v-model="dealership" class="custom-select control-form"
                :disabled="!dealership">
            <option v-for="dealership in dealerships" :value="dealership.id">{{dealership.title}}
            </option>
        </select>
    </div>
</template>

<script>
    import Tooltip from '../Tooltip.vue';

    export default {
        components: {
            Tooltip,
        },
        computed: {
            dealership: {
                get() {
                    return this.$store.state.dealership
                },
                set(val) {
                    this.$store.commit('UPDATE_DEALERSHIP', val);
                }
            },
            dealerships() {
                return this.$store.getters.dealerships
            }
        },
        watch: {
            dealerships(array) {
                if (array.length !== 0) {
                    this.$store.commit('UPDATE_DEALERSHIP', array[0].id);
                } else {
                    this.$store.commit('UPDATE_DEALERSHIP', null);
                }
            }
        }
    }
</script>