<template>
    <div>
        <div class="wrap">
            <div class="test">
                <div class="navbar">
                    <h4 @click="pop = !pop">第一個</h4>
                </div>
                <div class="box" v-if="pop == true">
                     <div class="main">
                    <h3 @click="ww()">購買</h3>
                    <h3 @click="ww()">賣出</h3>
                </div>
                <div class="content">
                    <img :src="empty[index].src" alt="" />
                    <h5>{{empty[index].title}}</h5>
                    <h5 @click="change(-1)">左</h5>
                    <h5 @click="change(1)">右</h5>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "Saved",
    data() {
        return {
            index:0,
            pop:false,
            empty:[],
            products: [
                {src:require('../assets/image/1.jpg'),title:'你好啊'},
                {src:require('../assets/image/2.jpg'),title:'你好啊'},
                {src:require('../assets/image/3.jpg'),title:'你好啊'},
                {src:require('../assets/image/4.jpg'),title:'你好啊'},
                {src:require('../assets/image/me.png'),title:'你好啊'},
                {src:require('../assets/image/men.jpg'),title:'你好啊'}
            ],
            products2: [
                {src:require('../assets/image/4.jpg'),title:'你好啊'},
                {src:require('../assets/image/4.jpg'),title:'你好啊'},
                {src:require('../assets/image/4.jpg'),title:'你好啊'},
                {src:require('../assets/image/4.jpg'),title:'你好啊'},
                {src:require('../assets/image/me.png'),title:'你好啊'},
            ]
        };
    },
    created() {
        this.empty = this.products;
    },
    methods: {
        change(item){
            this.index = this.index + item;
            if(this.index < 0)this.index = 0;
            if(this.index > this.empty.length - 1)this.index = this.empty.length -1;
        },
        ww(){
            if(this.empty == this.products){
                this.empty = this.products2;
                this.index = 0;
            }else if(this.empty == this.products2){
                this.empty = this.products;
                this.index = 0;
            }
        }
    }
};
</script>

<style lang="scss" scoped>
$color: #232323;
.wrap {
    width: 600px;
    height: 1000px;
    background: #ffa;
    margin: auto;
.test{
    width: 80%;
    background: #faf;
    margin: auto;
    .navbar{
        width: 100%;
        height: 50px;
        background: #fff;
        margin: auto;
        h4{
            text-align: center;
            color: #232323;
        }
    }
    .box{
        .main{
        display: flex;
        justify-content: center;
    }
    .content{
        img{
            width: 150px;
            height: 150px;
        }
    }
    }
    
}
}
</style>
