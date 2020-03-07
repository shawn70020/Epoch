<template>
    <div class="wrap">
        <Navbar></Navbar>
        <div class="banner">
            <a href="#">
                <div class="shop-link">
                    WOMEN
                </div>
            </a>
            <h5>UP TO 30% OFF BETWEEN-SEASON STYLES</h5>
            <a href="#">
                <div class="shop-link">
                    MEN
                </div>
            </a>
        </div>
        <div class="navs">
            <ol class="bread">
                <li><a href="#">Home</a></li>
                <li><a href="#">Men</a></li>
                <li><a href="#">New In</a></li>
                <li><a href="#">New In: Clothing</a></li>
            </ol>
        </div>
        <div class="container">
            <div class="top">
                <div class="left-img">
                    <img
                        :src="'data:image/png;base64,' + products.image"
                        class="img-fluid"
                    />
                </div>
                <div class="right-info">
                    <h3>{{ products.name }}</h3>
                    <h4>NT {{ products.price | currency }}</h4>
                    <h5>COLOUR: White</h5>
                    <h5>SIZE : {{ value }}</h5>
                    <el-select
                        v-model="value"
                        placeholder="Please Select"
                        class="el-select"
                    >
                        <el-option
                            v-for="item in options"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value"
                        >
                        </el-option>
                    </el-select>
                    <div class="error" :style="{ opacity: showError }">
                        <div class="msg">
                            <h5>
                                Please select from the available colour and size
                                options
                            </h5>
                        </div>
                    </div>
                    <button type="button" class="btn" @click="addCart">
                        ADD TO BAG
                    </button>
                </div>
            </div>
            <div class="bottom">
                <div class="bottom-info">
                    <h3>PRODUCT DETAILS</h3>
                    <h5>{{ products.content }}</h5>
                    <p></p>
                </div>
                <div class="bottom-info">
                    <h3>ABOUT ME</h3>
                    <h5>{{ products.detail }}</h5>
                    <p></p>
                </div>
                <div class="bottom-info">
                    <h3>PRODUCT CODE | CATEGORY</h3>
                    <h5>{{ products.id }} | {{ products.class }}</h5>
                    <p></p>
                </div>
            </div>
        </div>
        <Carousel></Carousel>
        <div class="social">
            <ul>
                <li>
                    <div class="icon fb">
                        <i class="fab fa-facebook-square"></i>
                    </div>
                </li>
                <li>
                    <div class="icon ig">
                        <i class="fab fa-instagram"></i>
                    </div>
                </li>
                <li>
                    <div class="icon tw">
                        <i class="fab fa-twitter"></i>
                    </div>
                </li>
                <li>|</li>
                <li>
                    <div class="icon yt">
                        <i class="fab fa-youtube"></i>
                    </div>
                </li>
                <li>
                    <div class="icon sc">
                        <i class="fab fa-snapchat"></i>
                    </div>
                </li>
                <li>
                    <div class="icon pi">
                        <i class="fab fa-pinterest"></i>
                    </div>
                </li>
            </ul>
        </div>
        <div class="foot">
            <div class="foot-top">
                <div class="item">
                    <h4>HELP & INFORMATION</h4>
                    <ul>
                        <li><a href="#">Help</a></li>
                        <li><a href="#">Deliverey & Returns</a></li>
                        <li><a href="#">Track Order</a></li>
                    </ul>
                </div>
                <div class="item">
                    <h4>ABOUT VUESTORE</h4>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Careers at VueStore</a></li>
                        <li><a href="#">Investors Site</a></li>
                    </ul>
                </div>
                <div class="item">
                    <h4>MORE FROM VUESTORE</h4>
                    <ul>
                        <li><a href="#">Mobile and Apps</a></li>
                        <li><a href="#">VueStore Marketplcae</a></li>
                        <li><a href="#">Gift vouchers</a></li>
                    </ul>
                </div>
                <div class="item">
                    <h4>SHOPPING FROM:</h4>
                    <h5>
                        You're in <i class="fab fa-canadian-maple-leaf"></i>|
                        Change
                    </h5>
                </div>
            </div>
            <div class="foot-bot">
                <h5>&copy; 2020</h5>
                <h5>Privacy & Cookies | Ts&Cs | Accessibility</h5>
            </div>
        </div>
        <div class="epoch">
            <h5>Epoch</h5>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Navbar from "../components/Navbar";
import Carousel from "../components/Carousel";
export default {
    name: "Item",
    data() {
        return {
            showError: 0,
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
        Navbar,
        Carousel
    },
    created() {
        this.getProduct(this.pid);
    },
    methods: {
        getProduct(id) {
            axios
                .get(`/api/products/men/item/${id}`)
                .then(res => {
                    this.products = res.data.data;
                })
                .catch(err => {
                    console.log(err);
                });
        },
        addCart() {
            if (this.value == "") {
                this.showError = 1;
            } else {
                axios
                    .post("/api/user/addcart", {
                        uid: this.$store.state.info.id,
                        pid: this.pid
                    })
                    .then(res => {
                        console.log(res);
                        this.$store.commit('updateCart',parseInt(this.pid));
                    })
                    .catch(err => {
                        console.log(err);
                    });
            }
        },
         getUserCart() {
            let aCart = this.$store.state.cart;
            let i;
            let arr = [];
            for (i = 0; i < aCart.length; i++) {
                arr.push(aCart[i].pid);
            }
            axios
                .post("/api/user/getusercart", {
                    post: arr
                })
                .then(res => {
                    this.carts = res.data.data;
                    for (i = 0; i < aCart.length; i++) {
                        this.carts[i].item = this.cart[i].num;
                        this.items = aCart.length;
                        this.total =
                            this.total +
                            this.carts[i].item * this.carts[i].price;
                    }
                })
                .catch(err => {
                    console.log(err);
                });
        },
    }
};
</script>
<style lang="scss" scoped>
@import url("https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300&display=swap");
$color: #1010c4;
$color1: #1ca753;
.wrap {
    height: 100vh;
}
.banner {
    display: flex;
    height: 50px;
    background: rgb(187, 167, 249);
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
            a {
                color: #999;
            }
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
            .btn {
                margin-top: 30px;
                width: 240px;
                height: 45px;
                background: darken($color1, 10%);
                padding-top: 10px;
                color: #fff;
                font-size: 18px;
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
        padding-top: 25px;
        .item {
            h4 {
                color: #666;
                font-weight: bold;
                font-size: 20px;
            }
            a {
                text-decoration: none;
                color: #666;
                font-size: 16px;
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
        font-size:30px;
        font-family: 'IM Fell Great Primer SC' ;
        line-height: 45px;
    }
}
</style>
