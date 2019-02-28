<template>
    <div class="form-group col-lg-4 col-md-6 col-sm-6 col-12 input-date">
        <label class="label">
            <slot></slot>
        </label>
        <div class="date-wrapper">
            <input type="date" class="control-form input-validate" required :value="value" @input="change"
                   placeholder="ДД.ММ.ГГ" :max="max" v-if="!safari">
            <datepicker input-class="control-form input-validate" :value="value" @input="changePicker"
                        :language="ru" v-if="safari" placeholder="ДД.ММ.ГГ"
                        :monday-first="true" format="dd MMMM yyyy"></datepicker>
        </div>
        <div class="error-text">Введите дату</div>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import {ru} from 'vuejs-datepicker/dist/locale/';

    export default {
        components: {
            Datepicker
        },
        props: ['value', 'max'],
        data() {
            return {
                ru: ru,
                safari: false
            }
        },
        methods: {
            change(e) {
                this.$emit('input', e.target.value);
            },
            changePicker(date) {
                this.$emit('input', date);
            }
        },
        mount() {
            if ($(this.$el).find('input[type=date]').prop('type') !== 'date') {
                this.safari = true;
            }
        }
    }
</script>
