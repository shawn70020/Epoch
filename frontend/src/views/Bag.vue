<template>
    <div>
        <Navbar></Navbar>
        <div class="banner">
            <router-link to="/women" class="">
                <div class="shop-link">
                    WOMEN
                </div>
            </router-link>
            <h5>UP TO 30% OFF BETWEEN-SEASON STYLES</h5>
            <router-link to="/men" class="">
                <div class="shop-link">
                    MENU
                </div>
            </router-link>
        </div>
        <div class="empty-bag" :style="{ display: isA }">
            <div class="wrap">
                <i class="icon fas fa-shopping-bag"></i>
                <h4>Your bag is empty</h4>
                <h5>
                    Items remain in your bag for 1 day, and then they’re moved
                    to your Saved Items.
                </h5>
                <router-link to="/user/saved"
                    ><button>VIEW SAVED ITEMS</button></router-link
                >
                <a href="#">Continue Shopping</a>
            </div>
        </div>
        <div class="bag" :style="{ display: isB }">
            <div class="bag-top">
                <div class="left">
                    <div class="bag-item">
                        <div class="title">
                            <h3>MY BAG</h3>
                            <h5>Items are reserved for 24 hours</h5>
                        </div>
                        <div class="loading">
                            <loading
                                :active.sync="isLoading"
                                :is-full-page="false"
                                :opacity="1"
                                class="loading-style"
                            >
                                <template slot="before">Ep</template>
                                <template slot="after">ch</template>
                            </loading>
                            <div
                                class="item"
                                v-for="item in carts"
                                :key="item.id"
                            >
                                <img
                                    :src="'data:image/png;base64,' + item.image"
                                    class="img-fluid"
                                />
                                <div class="item-info">
                                    <h4>NT {{ item.price | currency }}</h4>
                                    <h5>
                                        {{ item.name }}
                                    </h5>
                                    <span>QTY : </span>
                                    <el-select
                                        v-model="item.item"
                                        @change="updateNum"
                                    >
                                        <el-option
                                            v-for="items in options"
                                            :key="items.value"
                                            :label="items.label"
                                            :value="items.value"
                                        >
                                        </el-option>
                                    </el-select>
                                    <i
                                        class="fas fa-times"
                                        @click="deleteCart(item.id)"
                                    ></i>
                                </div>
                            </div>
                        </div>

                        <h3 class="total">
                            SUB-TOTAL NT {{ total | currency }}
                        </h3>
                    </div>
                    <div class="delivery">
                        <i class="fas fa-truck"></i>
                        <div class="info">
                            <h3>FREE* STANDARD DELIVERY</h3>
                            <h4>
                                Faster delivery options available to most
                                countries.
                            </h4>
                            <a href="#">More info</a>
                        </div>
                    </div>
                    <div class="return">
                        <i class="fas fa-undo-alt"></i>
                        <div class="info">
                            <h3>FREE & EASY RETURNS</h3>
                            <h4>
                                Send it back within 30 days of receiving your
                                order.
                            </h4>
                            <a href="#">More info</a>
                        </div>
                    </div>
                </div>
                <div class="right">
                    <div class="bag-info">
                        <h3>TOTAL</h3>
                        <div class="wrap">
                            <div class="title">
                                <h4>Sub-total</h4>
                            </div>
                            <div class="cost">
                                <h4>NT {{ total | currency }}</h4>
                            </div>
                        </div>
                        <router-link to="/user/checkout"
                            ><button class="checkout-btn">
                                CHECKOUT
                            </button></router-link
                        >
                        <div class="payment">
                            <h5>WE ACCEPT:</h5>
                            <i class="fab fa-cc-visa"></i>
                            <i class="fas fa-wallet"> </i
                            ><i class="fab fa-cc-paypal"> </i>
                        </div>
                        <div class="coupon">
                            <h5>
                                Got a discount code? Add it in the next step.
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
export default {
    inject: ["reload"],
    name: "Bag",
    data() {
        return {
            carts: [],
            isLoading: false,
            uid: this.$store.state.info.id,
            isA: "none",
            isB: "block",
            total: 0,
            finalTotal: 0,
            options: [
                {
                    value: 1,
                    label: "1"
                },
                {
                    value: 2,
                    label: "2"
                },
                {
                    value: 3,
                    label: "3"
                },
                {
                    value: 4,
                    label: "4"
                },
                {
                    value: 5,
                    label: "5"
                }
            ],
            num: []
        };
    },
    components: {
        Navbar
    },
    computed: {
        getCart() {
            return this.$store.state.cart;
        }
    },
    watch: {
        getCart: {
            handler(aCart) {
                if (this.$store.state.isEmpty === false) {
                    this.isA = "flex";
                    this.isB = "none";
                } else {
                    this.isA = "none";
                    this.isB = "block";
                    this.carts = [];
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
                            this.total = 0;
                            for (i = 0; i < aCart.length; i++) {
                                this.carts[i].item = aCart[i].num;
                                this.items = aCart.length;
                                this.total =
                                    this.total +
                                    this.carts[i].item * this.carts[i].price;
                            }
                            this.finalTotal = this.total;
                        })
                        .catch(err => {
                            console.log(err);
                        });
                }
            },
            immediate: true,
            deep: true
        }
    },
    methods: {
        getProducts() {
            axios
                .get("/api/products/men")
                .then(res => {
                    this.products = res.data.data;
                })
                .catch(err => {
                    console.log(err);
                });
        },
        updateNum() {
            this.isLoading = true;
            let i;
            let uid = this.$store.state.info.id;
            for (i = 0; i < this.carts.length; i++) {
                this.num[i] = this.carts[i].item;
            }
            this.total = 0;
            axios
                .post("/api/user/updatecart", {
                    post: this.num,
                    id: uid
                })
                .then(res => {
                    if (res.data.result === true) {
                        this.$store.state.cart = res.data.data;
                        setTimeout(() => {
                            this.reload();
                            this.isLoading = false;
                        }, 1000);
                    }
                })
                .catch(err => {
                    console.log(err);
                });
        },
        deleteCart(id) {
            axios.delete(`/api/cart/${this.uid}/${id}`).then(() => {
                this.$store.commit("deleteCart", parseInt(id));
            });
        }
    }
};
</script>
<style lang="scss" scoped>
$color: #f2f2fa;
$color1: #1ca753;
.banner {
    display: flex;
    height: 50px;
    background: rgb(252, 59, 53);
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
.empty-bag {
    width: 100%;
    height: 480px;
    background: #fff;
    display: flex;
    .wrap {
        width: 390px;
        height: 330px;
        background: #fff;
        margin: auto;
        text-align: center;
        padding: 10px;
        font-family: "Sriracha";
        h4 {
            margin-top: 10px;
            font-size: 24px;
            font-weight: bold;
        }
        h5 {
            margin-top: 15px;
            font-size: 16px;
            line-height: 25px;
        }
        button {
            margin-top: 15px;
            width: 288px;
            height: 55px;
            background: darken($color1, 10%);
            color: #fff;
            font-size: 16px;
        }
        a {
            margin-top: 20px;
            display: block;
            color: #2d2d2d;
            text-decoration: underline;
        }
    }
}
.loading-style {
    font-size: 40px;
    font-family: "IM Fell Great Primer SC";
    color: #2d2d2d;
}
.bag {
    width: 100%;
    // height: 100vh;
    font-family: "PT Serif", serif;
    background: #eee;
    padding-bottom: 30px;
    padding-top: 28px;
    .bag-top {
        width: 960px;
        display: flex;
        margin: auto;
        .left {
            color: #2d2d2d;
            margin-bottom: 20px;
            .bag-item {
                width: 570px;
                background: #fff;
                margin-top: 20px;
                position: relative;
                .total {
                    text-align: right;
                    margin-top: 70px;
                    margin-right: 15px;
                    font-size: 20px;
                    font-weight: 700;
                    color: #2d2d2d;
                    padding-bottom: 10px;
                }
                .title {
                    display: flex;
                    justify-content: space-between;
                    align-items: flex-end;
                    width: 100%;
                    height: 75px;

                    h3,
                    h5 {
                        padding: 0 20px;
                    }
                    h3 {
                        font-size: 26px;
                        font-weight: bold;
                    }
                    h5 {
                        font-size: 18px;
                    }
                }
                .loading {
                    position: relative;
                }
                .item {
                    margin-top: 40px;
                    display: flex;
                    position: relative;
                    margin-left: 20px;
                    &::before {
                        position: absolute;
                        content: "";
                        width: 85%;
                        height: 1px;
                        top: -20px;
                        left: 2rem;
                        background: #eee;
                    }
                    img {
                        margin-left: 10px;
                        width: 110px;
                        height: 140px;
                    }
                    .item-info {
                        margin-left: 15px;
                        h4,
                        h5 {
                            color: #2d2d2d;
                        }
                        h4 {
                            font-size: 20px;
                            font-weight: 700;
                        }
                        h5 {
                            font-size: 20px;
                            color: lighten(#2d2d2d, 10%);
                            width: 80%;
                        }
                        span {
                            font-size: 18px;
                        }
                        .fa-times {
                            position: absolute;
                            top: 0;
                            right: 50px;
                            cursor: pointer;
                        }
                    }
                }
            }
            .delivery {
                display: flex;
                width: 570px;
                height: 140px;
                background: #fff;
                margin-top: 10px;
                a {
                    color: #2d2d2d;
                    text-decoration: underline;
                }
                .fa-truck {
                    width: 10%;
                    font-size: 28px;
                    position: relative;
                    top: 1.2rem;
                    left: 1.2rem;
                }
                .info {
                    width: 85%;
                    padding-top: 1rem;
                    margin-left: 25px;
                    h3 {
                        font-size: 20px;
                        font-weight: bold;
                    }
                    h4 {
                        font-size: 18px;
                    }
                }
            }
            .return {
                display: flex;
                width: 570px;
                height: 140px;
                background: #fff;
                margin-top: 10px;
                a {
                    color: #2d2d2d;
                    text-decoration: underline;
                }
                .fa-undo-alt {
                    width: 10%;
                    font-size: 28px;
                    position: relative;
                    top: 1.2rem;
                    left: 1.2rem;
                }
                .info {
                    width: 85%;
                    padding-top: 1rem;
                    margin-left: 25px;
                    h3 {
                        font-size: 20px;
                        font-weight: bold;
                    }
                    h4 {
                        font-size: 18px;
                    }
                }
            }
        }
        .right {
            width: 360px;
            height: 360px;
            background: #fff;
            margin-top: 20px;
            margin-left: 10px;
            color: #2d2d2d;
            .bag-info {
                width: 90%;
                height: 65%;
                margin: auto;
                margin-top: 1rem;
                h3 {
                    font-size: 26px;
                    font-weight: 700;
                    margin-bottom: 40px;
                }
                .wrap {
                    border-top: 1px solid #eee;
                    padding-top: 15px;
                    display: flex;
                    justify-content: space-between;
                    font-family: "PT Serif", serif;
                    .title {
                        h4 {
                            font-size: 22px;
                            font-weight: 700;
                        }
                    }
                    .cost {
                        h4 {
                            font-size: 18px;
                        }
                    }
                }
                .checkout-btn {
                    margin-top: 30px;
                    width: 260px;
                    height: 45px;
                    background: darken($color1, 5%);
                    color: #fff;
                    font-size: 18px;
                    margin-left: 1.5rem;
                    &:hover {
                        background: darken($color1, 10%);
                    }
                }
                .payment {
                    margin-top: 20px;
                    h5 {
                        font-size: 18px;
                        font-weight: bold;
                    }
                    i + i {
                        margin-left: 10px;
                    }
                }
                .coupon {
                    h5 {
                        font-size: 20px;
                    }
                }
            }
        }
    }
}
.social {
    height: 60px;
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
    width: 100%;
    height: 40px;
    h5 {
        font-size: 30px;
        font-family: "IM Fell Great Primer SC";
        line-height: 40px;
    }
}
</style>
