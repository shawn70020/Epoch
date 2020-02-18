<template lang="pug">
.wrap
    .txt(v-for='item in user' :key='item.id')
        h1 {{ item.title }}
        h2 {{ item.body }}
</template>

<script>
import { mapState, mapActions } from "vuex";
export default {
    name: "Article",
    computed: mapState({
        user: state => state.user.user.data
    }),
    created() {
        this.getUser();
        console.log(this.$store.state);
    },
    methods: {
        // 映射 vuex 对象上的方法
        ...mapActions(["getUser"])
    }
};
</script>
<style lang="scss" scoped>
.wrap {
    width: 100%;
    height: 100%;
    background: #ffa;
    .txt {
        h1 {
            color: aqua;
        }
    }
}
</style>
