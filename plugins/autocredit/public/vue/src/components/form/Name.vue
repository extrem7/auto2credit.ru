<template>
    <div class="form-group col-lg-3 col-md-6 col-sm-6 col-12">
        <label class="label">Имя и фамилия</label>
        <input type="text" class="control-form name-input" placeholder="Иван Петров" v-model="name">
        <div class="error-text">Введите имя и фамилию</div>
    </div>
</template>

<script>
    export default {
        computed: {
            name: {
                get() {
                    return this.$store.state.name;
                },
                set(val) {
                    this.$store.commit('UPDATE_NAME', val)
                }
            }
        }
    }
</script>