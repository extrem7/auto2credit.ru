<template>
    <div class="form-group col-lg-3 col-md-6 col-sm-6 col-12">
        <label class="label">E-mail</label>
        <input type="email" class="control-form" v-model="email" placeholder="E-mail@domen.ru">
    </div>
</template>

<script>
    export default {
        computed: {
            email: {
                get() {
                    return this.$store.state.email;
                },
                set(val) {
                    this.$store.commit('UPDATE_EMAIL', val)
                }
            }
        }
    }
</script>