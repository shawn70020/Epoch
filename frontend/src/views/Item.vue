<template lang="pug">
div
  navbar
  .banner
    router-link(to='/women')
      .shop-link
        | WOMEN
    h5 UP TO 30% OFF BETWEEN-SEASON STYLES
    router-link(to='/men')
      .shop-link
        | MEN
  .wrap-loading
    loading(loader='dots' :active.sync='wrapLoading' :is-full-page='false' :opacity='1')
    .navs
      ol.bread
        li
          router-link(to='/') Home
        li(v-if="products.sex === 'M'")
          router-link(to='/men') Men
        li(v-if="products.sex === 'W'")
          router-link(to='/women') Women
        li {{ products.name }}
    .container
      .top
        .left-img
          img.img-fluid(:src="'data:image/png;base64,' + products.image")
        .right-info
          h3 {{ products.name }}
          h4 NT {{ products.price | currency }}
          h5 COLOUR: White
          h5.sufficient(v-if='products.num >= 150')
            | STOCK: SUFFICIENT
          h5.enough(v-if='150 > products.num && products.num >= 50')
            | STOCK: ENOUGH
          h5.few(v-if='50 > products.num && products.num > 0')
            | STOCK: ONLY FEW
          h5.out(v-if='products.num === 0')
            i.fas.fa-exclamation-circle
            |  STOCK:
            |                             SELL OUT
          h5 SIZE : {{ value }}
          el-select.el-select(v-model='value' placeholder='Please Select')
            el-option(v-for='item in options' :key='item.value' :label='item.label' :value='item.value')
          .error(:style='{ opacity: showError }')
            .msg
              h5
                | Please select from the available colour and
                | size options
          .item-btn
            button.btn(v-if='products.num > 0' type='button' @click='addCart')
              | ADD TO BAG
            button.btn(v-if='products.num === 0' type='button' disabled='disabled')
              | ADD TO BAG
            .heart(@click='saveItem()')
              i.fa-heart(:class='{ fas: isCheck, far: noCheck }')
      .bottom
        .bottom-info
          h3 PRODUCT DETAILS
          h5 {{ products.content }}
          p
        .bottom-info
          h3 ABOUT ME
          h5 {{ products.detail }}
          p
        .bottom-info
          h3 PRODUCT CODE | CATEGORY
          h5 {{ products.id }} | {{ products.class }}
          p
    .social
      ul
        li
          .icon.fb
            i.fab.fa-facebook-square
        li
          .icon.ig
            i.fab.fa-instagram
        li
          .icon.tw
            i.fab.fa-twitter
        li |
        li
          .icon.yt
            i.fab.fa-youtube
        li
          .icon.sc
            i.fab.fa-snapchat
        li
          .icon.pi
            i.fab.fa-pinterest
    .foot
      .foot-top
        .item
          h4 HELP &amp; INFORMATION
          ul
            li
              a(href='#') Help
            li
              a(href='#') Deliverey &amp; Returns
            li
              a(href='#') Track Order
        .item
          h4 ABOUT VUESTORE
          ul
            li
              a(href='#') About Us
            li
              a(href='#') Careers at VueStore
            li
              a(href='#') Investors Site
        .item
          h4 MORE FROM VUESTORE
          ul
            li
              a(href='#') Mobile and Apps
            li
              a(href='#') VueStore Marketplcae
            li
              a(href='#') Gift vouchers
        .item
          h4 SHOPPING FROM:
          h5
            | You&apos;re in 
            i.fas.fa-globe-americas
            |  |
            |                             Change
      .foot-bot
        h5 &copy; 2020
        h5 Privacy &amp; Cookies | Ts&amp;Cs | Accessibility
</template>

<script>
import axios from "axios";
import Navbar from "../components/Navbar";
export default {
    name: "Item",
    data() {
        return {
            showError: 0,
            wrapLoading: false,
            isCheck: false,
            noCheck: true,
            pid: this.$route.params.pid,
            products: [],
            options: [
                {
                    value: "XS",
                    label: "XS - (86-91cm)"
                },
                {
                    value: "S",
                    label: "S - (91-96cm)"
                },
                {
                    value: "M",
                    label: "M - (96-101cm)"
                },
                {
                    value: "L",
                    label: "L - (101-106cm)"
                },
                {
                    value: "XL",
                    label: "XL - (106-111cm)"
                }
            ],
            value: ""
        };
    },
    components: {
        Navbar
    },
    computed: {
        getQuery() {
            return this.$route.params.pid;
        }
    },
    watch: {
        getQuery: {
            handler(sQuery) {
                this.getProduct(sQuery);
            }
        }
    },
    created() {
        this.getProduct(this.pid);
    },
    methods: {
        getProduct(id) {
            this.wrapLoading = true;
            axios
                .get(`/api/products/men/item/${id}`)
                .then(res => {
                    this.products = res.data.data;
                    this.wrapLoading = false;
                })
                .catch(() => {
                    this.$notify.error({
                        title: "Something Goes Wrong ...",
                        message: "Please refresh your page again",
                        duration: 6800
                    });
                });
        },
        addCart() {
            if (this.value == "") {
                this.showError = 1;
            } else if (!this.$store.state.isLogin) {
                this.$notify({
                    title: "Sorry !",
                    message: "Please Sign In",
                    type: "warning",
                    duration: 1800
                });
            } else {
                axios
                    .post("/api/user/addcart", {
                        uid: this.$store.state.info.id,
                        pid: this.$route.params.pid
                    })
                    .then(() => {
                        this.$store.commit("updateCart", parseInt(this.$route.params.pid));
                        this.$notify({
                            title: "Success !",
                            message: "Add To Cart",
                            type: "success",
                            duration: 1800
                        });
                    })
                    .catch(() => {
                        this.$notify.error({
                            title: "Something Goes Wrong ...",
                            message: "Please refresh your page again",
                            duration: 6800
                        });
                    });
            }
        },
        saveItem() {
            if (!this.$store.state.isLogin) {
                this.$notify({
                    title: "Sorry !",
                    message: "Please Sign In First",
                    type: "warning",
                    duration: 1800
                });
            } else {
                axios
                    .post("/api/user/saved", {
                        uid: this.$store.state.info.id,
                        pid: this.$route.params.pid
                    })
                    .then(res => {
                        if (res.data.result === true) {
                            this.isCheck = true;
                            this.noCheck = false;
                            this.$notify({
                                title: "Success !",
                                message: "ADD TO SAVED ITEMS",
                                type: "success",
                                duration: 1800
                            });
                        }
                    })
                    .catch(() => {
                        this.$notify.error({
                            title: "Something Goes Wrong ...",
                            message: "Please refresh your page again",
                            duration: 6800
                        });
                    });
            }
        }
    }
};
</script>
<style lang="scss" scoped>
@import url("https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300&display=swap");
$color: #1010c4;
$color1: #1ca753;
.wrap-loading {
    position: relative;
}
.banner {
    display: flex;
    height: 50px;
    background: rgb(255, 251, 0);
    align-items: center;
    justify-content: space-around;
    font-family: "Sriracha";
    h5 {
        padding-top: 10px;
        font-size: 18px;
        color: $color;
    }
    a {
        width: 96px;
        height: 30px;
        text-decoration: none;
        color: $color;
        border: 2px solid $color;
        text-align: center;
        line-height: 30px;
        font-size: 14px;
        transition: 0.5s;
        &:hover {
            color: lighten($color, 20%);
            border: 2px solid lighten($color, 20%);
        }
    }
}
.navs {
    background: #fff;
    height: 50px;
}
.bread {
    display: flex;
    list-style: none;
    line-height: 50px;
    font-size: 18px;
    font-family: "Sriracha";
    li {
        padding: 0 15px;
        a {
            text-decoration: none;
            color: #2d2d2d;
        }
        &:last-child {
            &::before {
                content: ">";
                color: #999;
                margin-right: 15px;
            }
            color: #999;
        }
    }
    li + li {
        padding-left: 0;
    }
    li + li::before {
        content: ">";
        color: #2d2d2d;
        margin-right: 15px;
    }
}
.container {
    .top {
        display: flex;
        margin-top: 30px;
        justify-content: center;
        .left-img {
            padding-right: 67px;
            img {
                width: 512px;
                height: 654px;
            }
        }
        .right-info {
            padding-top: 30px;
            padding-left: 30px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            font-family: "Cormorant SC";
            .sufficient {
                color: #1ca753;
            }
            .enough {
                color: #2d2d2d;
            }
            .few {
                color: #ed3833;
            }
            .out {
                color: #666;
            }
            h3 {
                font-size: 24px;
            }
            h4 {
                font-size: 26px;
                margin-top: 10px;
            }
            h5 {
                font-size: 20px;
                margin-top: 10px;
            }
            .el-select {
                margin-top: 20px;
            }
            .error {
                width: 330px;
                height: 60px;
                background: #fae7ec;
                color: #2d2d2d;
                margin-top: 20px;
                h5 {
                    font-size: 16px;
                    padding-left: 15px;
                    padding-right: 5px;
                }
            }
            .item-btn {
                display: flex;
                justify-content: space-around;
                align-items: center;
                margin-top: 20px;
                .heart {
                    width: 36px;
                    height: 36px;
                    text-align: center;
                    background: #eee;
                    border-radius: 50%;
                    .far {
                        line-height: 36px;
                        width: 20px;
                        height: 18px;
                        color: #2d2d2d;
                    }
                    .fas {
                        line-height: 36px;
                        width: 20px;
                        height: 18px;
                        color: #2d2d2d;
                    }
                }
                .btn {
                    width: 240px;
                    height: 45px;
                    background: darken($color1, 10%);
                    padding-top: 10px;
                    color: #fff;
                    font-size: 18px;
                }
            }
        }
    }
    .bottom {
        display: flex;
        margin-top: 50px;
        justify-content: center;
        margin-bottom: 100px;
        .bottom-info {
            width: 30%;
            font-family: "Lato";
            padding-left: 30px;
            h3 {
                color: #999;
                font-size: 16px;
                font-weight: bold;
                padding-bottom: 10px;
            }
            h5 {
                color: #2d2d2d;
                font-size: 18px;
            }
        }
    }
}
.social {
    height: 60px;
    margin-top: 60px;
    border-top: 1px solid #ccc;
    border-bottom: 1px solid #ccc;
    ul {
        width: 600px;
        padding-top: 15px;
        display: flex;
        margin: auto;
        justify-content: space-around;
        li {
            list-style: none;
            transition: 1.5s;
            .icon {
                width: 32px;
                height: 32px;
                border-radius: 32px;
                line-height: 32px;
                text-align: center;
                color: #fff;
                font-size: 16px;
            }
            .fb {
                background: #4267b2;
            }
            .ig {
                background: #833ab4;
            }
            .tw {
                background: #38a1f3;
            }
            .yt {
                background: #ed3833;
            }
            .sc {
                background: #fffc00;
            }
            .pi {
                background: #bd081c;
            }
            &:nth-child(odd) {
                &:hover {
                    transform: rotate(360deg);
                }
            }
            &:nth-child(even) {
                &:hover {
                    transform: rotate(-360deg);
                }
            }
            &:nth-child(4) {
                color: #999;
            }
        }
    }
}
.foot {
    .foot-top {
        height: 220px;
        background: #eee;
        display: flex;
        justify-content: space-around;
        padding-top: 45px;
        .item {
            h4 {
                color: #666;
                font-weight: bold;
                font-size: 20px;
            }
            ul {
                list-style: none;
                padding: 0;
                li {
                    a {
                        text-decoration: none;
                        color: #666;
                        font-size: 16px;
                    }
                }
            }
        }
    }
    .foot-bot {
        display: flex;
        justify-content: space-around;
        background: #ddd;
        height: 50px;
        h5 {
            color: #2d2d2d;
            font-size: 14px;
            line-height: 50px;
        }
    }
}
.epoch {
    padding-left: 21%;
    height: 45px;
    h5 {
        font-size: 30px;
        font-family: "IM Fell Great Primer SC";
        line-height: 45px;
    }
}
</style>
