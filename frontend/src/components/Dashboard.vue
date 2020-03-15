<template>
<div class="wrap">
    <h2>Welcome Back {{user}}!</h2>
</div>
</template>
<script>
export default {
    name:'Dashboard',
     data() {
        return {
            user: this.$store.state.info.name
        };
    },
}
</script>
<style lang="scss" scoped>
.wrap{
    position: relative;
    background: linear-gradient(90deg, #bdc3c7, #2c3e50);
    h2{
        color: #fff;
        line-height: 100vh;
        font-family: 'Roboto Mono';
        position: absolute;
        right: 10%;
    }
}
</style>