<template>
    <div class="timer" style="display: none">
        <div class="container text-center">
            <div class="second-title big-size">Уважаемый(ая) {{name}}, ваш запрос в обработке</div>
            <div class="spinner-grow text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <div class="second-title big-size">Ожидайте {{timer}} сек.</div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['timer'],
        computed: {
            name() {
                return this.$store.getters.firstName
            }
        }
    }
</script>