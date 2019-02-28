<template>
    <div class="form-group col-lg-4 col-md-6 col-sm-6 col-12">
        <label class="label">Серия и номер паспорта</label>
        <input type="tel" class="control-form passport input-validate"
               v-mask="{mask: '99 99 999999', clearIncomplete: true, showMaskOnHover: false}"
               required v-model="passport" placeholder="40 02 555999">
        <div class="error-text">Введите серию и номер паспорта</div>
    </div>
</template>

<script>
    export default {
        computed: {
            passport: {
                get() {
                    return this.$store.state.passport;
                },
                set(val) {
                    this.$store.commit('UPDATE_PASSPORT', val)
                }
            }
        }
    }
</script>