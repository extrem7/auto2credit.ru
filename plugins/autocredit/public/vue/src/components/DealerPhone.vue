<template>
    <div class="mt-4 callback-message text-center">Вы также можете назначить сделку, позвонив по телефону<br>
        <a v-for="phone in phones" :href="phone|replace">{{phone}}</a></div>
</template>

<script>
    export default {
        name: "DealerPhone",
        computed: {
            phones() {
                return this.$store.getters.phones
            }
        },
        filters: {
            replace(phone) {
                return `tel:${phone.replace(/[^\d]/g, '')}`
            }
        }
    }
</script>