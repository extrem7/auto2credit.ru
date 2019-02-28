<template>
    <div class="form-group col-md-6 col-sm-6 col-12">
        <label class="label">Номер телефона</label>
        <input type="tel" class="control-form phone input-validate" @change="updatePhone" :value="phone"
               v-mask="{mask: '+7 (999) 999-99-99', clearIncomplete: true, showMaskOnHover: false}"
               placeholder="+7 (111) 222-33-44" required>
        <div class="error-text">Введите телефон</div>
    </div>
</template>

<script>
    export default {
        computed: {
            phone() {
                return this.$store.state.phone
            }
        },
        methods: {
            updatePhone(e) {
                this.$store.commit('UPDATE_PHONE', e.target.value)
            }
        }
    }
</script>