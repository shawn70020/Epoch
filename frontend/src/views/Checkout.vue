<template>
    <div class="body">
        <div class="title">
            <router-link to="/"><h2>EPOCH</h2></router-link>
        </div>
        <div class="wrap">
            <div class="left-info">
                <div class="email">
                    <h4>EMAIL ADDRESS</h4>
                    <h5>shawn70020@gmail.com</h5>
                </div>
                <div class="coupon">
                    <div class="top">
                        <h3>PROMO CODE</h3>
                        <label for="side-menu-switch">
                            <i
                                class="fas fa-chevron-down"
                                :class="{ toggle: isTrue }"
                                @click="toggle"
                            ></i>
                        </label>
                    </div>
                    <input type="checkbox" name="" id="side-menu-switch" />
                    <div class="coupon-wrap">
                        <h4>ADD A PROMO CODE</h4>
                        <h4>PROMO CODE</h4>
                        <div class="coupon-code">
                            <input
                                type="text"
                                class="code"
                                placeholder="折價券"
                                v-model="coupon"
                            />
                            <button class="coupon-btn" @click="useCoupon">
                                APPLY CODE
                            </button>
                        </div>
                        <div class="coupon-info">
                            <h4>NEED TO KNOW</h4>
                            <ul>
                                <li>
                                    You can only use one discount/promo code per
                                    order. This applies to our free-delivery
                                    codes, too.
                                </li>
                                <li>
                                    Discount/promo codes cannot be used when
                                    buying gift vouchers.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="delivery">
                    <h4>DELIVERY ADDRESS</h4>
                    <h5>ADD ADDRESS</h5>
                    <form class="form-signin" @submit.prevent="signin">
                        <label for="inputName">FULL NAME:</label>
                        <input type="text" id="inputName" v-model="user.name" />
                        <label for="inputMobile">MOBILE:</label>
                        <input
                            type="number"
                            id="inputMobile"
                            v-model="user.phone"
                        />
                        <label for="inputAddress">ADDRESS:</label>
                        <input
                            type="name"
                            id="inputAddress"
                            v-model="user.address"
                        />
                        <label for="inputNote">NOTE:</label>
                        <textarea id="inputNote" v-model="user.note">
                        </textarea>
                        <button class="address-btn" type="submit">
                            DELIVER TO THIS ADDRESS
                        </button>
                    </form>
                </div>
                <div class="option">
                    <h3>DELIVERY OPTIONS</h3>
                    <div class="standard">
                        <div class="freight">NT $100</div>
                        <div class="info">
                            <label for="standard">Standard Delivery:</label>
                            <h5>
                                Delivered on or before
                                {{
                                    moment()
                                        .add(10, "days")
                                        .calendar()
                                }}
                            </h5>
                            <input
                                type="radio"
                                class="radio"
                                name="inlineRadioOptions"
                                id="standard"
                                value="S"
                                v-model="delivery"
                            />
                        </div>
                    </div>
                    <div class="express">
                        <div class="freight">NT $300</div>
                        <div class="info">
                            <label for="express"> Express Delivery:</label>
                            <h5>
                                Delivered on or before
                                {{
                                    moment()
                                        .add(3, "days")
                                        .calendar()
                                }}
                            </h5>
                            <input
                                type="radio"
                                class="radio"
                                name="inlineRadioOptions"
                                id="express"
                                value="E"
                                v-model="delivery"
                            />
                        </div>
                    </div>
                </div>
                <div class="payment">
                    <div class="billing-info">
                        <h3>PAYMENT</h3>
                        <h4>BILLING ADDRESS</h4>
                        <h5>{{ user.name }}</h5>
                        <h5>{{ user.address }}</h5>
                        <h5>{{ user.phone }}</h5>
                    </div>
                    <div class="payment-type">
                        <div class="choose">
                            <label for="express"
                                ><i class="fab fa-cc-visa"></i> CREDIT
                                CARD:</label
                            >
                            <input
                                type="radio"
                                class="radio"
                                name="inlineRadioOption"
                                id="express"
                                value="Card"
                                v-model="payment"
                            />
                        </div>
                        <div class="choose">
                            <label for="express"
                                ><i class="fas fa-wallet"></i> CASH ON
                                DELIVERY:</label
                            >
                            <input
                                type="radio"
                                class="radio"
                                name="inlineRadioOption"
                                id="express"
                                value="Cash"
                                v-model="payment"
                            />
                        </div>
                        <div class="choose">
                            <label for="express"
                                ><i class="fab fa-cc-paypal"></i> ATM
                                TRANSFER:</label
                            >
                            <input
                                type="radio"
                                class="radio"
                                name="inlineRadioOption"
                                id="express"
                                value="Atm"
                                v-model="payment"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="right-info">
                <div class="top">
                    <h3>{{ items }} Item</h3>
                    <router-link to="/user/bag"><h3>EDIT</h3></router-link>
                </div>
                <div class="wrapper">
                    <div class="cart-wrap">
                        <div class="cart" v-for="item in carts" :key="item.id">
                            <img
                                :src="'data:image/png;base64,' + item.image"
                                class="img-fluid"
                            />
                            <div class="cart-info">
                                <h3>NT {{ item.price | currency }}</h3>
                                <h4>{{ item.name }}</h4>
                                <h4>QTY:{{ item.item }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="fee">
                        <div class="fee-title">
                            <h4>Subtotal</h4>
                            <h4>Delivery</h4>
                            <h4>
                                Discount
                            </h4>
                            <h4>
                                TOTAL TO PAY
                            </h4>
                        </div>
                        <div class="cost">
                            <h4>NT {{ subtotal | currency }}</h4>
                            <h4 v-if="delivery === 'S'">
                                NT {{ 100 | currency }}
                            </h4>
                            <h4 v-if="delivery === 'E'">
                                NT {{ 300 | currency }}
                            </h4>
                            <h4>NT {{ discount | currency }}</h4>
                            <h4>NT {{ total | currency }}</h4>
                        </div>
                    </div>
                    <button class="btn-order" @click="checkoutCart">
                        PLACE ORDER
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
var moment = require("moment");
import axios from "axios";
export default {
    name: "Checkout",
    data() {
        return {
            moment: moment,
            isTrue: false,
            coupon: "",
            user: {
                name: "",
                phone: "",
                address: "",
                note: ""
            },
            carts: [],
            items: "",
            payment: "",
            subtotal: "",
            delivery: "S",
            discount: 0
        };
    },
    computed: {
        getCart() {
            return this.$store.state.cart;
        },
        total() {
            if (this.delivery === "S") {
                return this.subtotal + 100 - this.discount;
            } else {
                return this.subtotal + 300 - this.discount;
            }
        }
    },
    watch: {
        getCart: {
            handler(aCart) {
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
                        this.subtotal = 0;
                        this.carts = res.data.data;
                        for (i = 0; i < aCart.length; i++) {
                            this.carts[i].item = aCart[i].num;
                            this.items = aCart.length;
                            this.subtotal =
                                this.subtotal +
                                this.carts[i].item * this.carts[i].price;
                        }
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },
            immediate: true
        }
    },
    methods: {
        success() {
            this.$notify({
                title: "成功",
                message: "已兌換優惠券",
                type: "success"
            });
        },
        error() {
            this.$notify.error({
                title: "抱歉",
                message: "此優惠券不存在"
            });
        },
        toggle() {
            if (this.isTrue === false) {
                this.isTrue = true;
            } else {
                this.isTrue = false;
            }
        },
        useCoupon() {
            axios
                .post("/api/user/coupon", {
                    coupon: this.coupon
                })
                .then(res => {
                    if (res.data.result === true) {
                        let discount = res.data.data;
                        this.discount = this.subtotal * (1 - discount);
                        this.success();
                    } else {
                        this.error();
                    }
                });
        },
        checkoutCart() {
            let checkout = [];
            checkout = this.$store.state.cart;
            let info = this.$store.state.info;
            let finalTotal;
            if (this.delivery === "S") {
                finalTotal = this.subtotal + 100 - this.discount;
            } else {
                finalTotal = this.subtotal + 300 - this.discount;
            }
            axios
                .post("/api/user/checkout", {
                    cart: checkout,
                    user: info,
                    address: this.user,
                    delivery: this.delivery,
                    payment: this.payment,
                    total: finalTotal
                })
                .then(res => {
                    if (res.data.result === true) {
                        this.$message({
                            message: "恭喜您！訂單發送成功",
                            type: "success"
                        });
                    } else {
                        this.$notify.error({
                            title: "抱歉",
                            message: res.data.msg
                        });
                    }
                })
                .catch(err => {
                    console.log(err);
                });
        }
    }
};
</script>

<style lang="scss" scoped>
$color: #2d2d2d;
.body {
    background: #eee;
    width: 100%;
    height: 2600px;
    font-family: "Josefin Sans", sans-serif;
    color: #2d2d2d;
}

.title {
    width: 100%;
    height: 85px;
    text-align: center;
    padding-top: 20px;
    a {
        color: #2d2d2d;
        text-decoration: none;
    }
}
.wrap {
    width: 50%;
    margin: auto;
    display: flex;
    .toggle {
        transform: scaley(-1);
    }
    .left-info {
        width: 60%;
        height: 900px;
        background: #eee;
        margin-right: 0.6rem;
        .email {
            width: 100%;
            height: 148px;
            background: #fff;
            h4 {
                font-size: 24px;
                font-weight: bold;
                letter-spacing: 1.5px;
                padding: 30px 0 0 30px;
                color: $color;
            }
            h5 {
                font-size: 20px;
                padding: 20px 0 0 30px;
                color: lighten($color, 10%);
            }
        }
        .coupon {
            width: 100%;
            background: #fff;
            margin-top: 0.6rem;
            #side-menu-switch {
                position: absolute;
                opacity: 0;
                z-index: -1;
                & + .coupon-wrap {
                    display: none;
                }
                &:checked + .coupon-wrap {
                    display: block;
                }
                &:checked {
                    .fa-chevron-down {
                        font-size: 10px;
                        transform: scaley(-1);
                    }
                }
            }
            .top {
                color: $color;
                position: relative;
                display: flex;
                width: 100%;
                height: 88px;
                align-items: center;
                h3 {
                    font-size: 24px;
                    padding-left: 30px;
                    font-weight: bold;
                }
                .fa-chevron-down {
                    font-size: 28px;
                    position: absolute;
                    top: 26px;
                    right: 30px;
                }
            }
            .coupon-wrap {
                h4 {
                    color: $color;
                    font-size: 20px;
                    padding: 0 0 10px 30px;
                    font-family: "Josefin Sans", sans-serif;
                    font-weight: bold;
                    &:nth-child(2) {
                        color: #666;
                        padding-bottom: 5px;
                    }
                }
                .coupon-code {
                    padding-left: 30px;
                    .code {
                        width: 330px;
                        height: 56px;
                        font-size: 18px;
                        padding: 12px;
                    }
                    .coupon-btn {
                        background: $color;
                        color: #fff;
                        width: 170px;
                        height: 56px;
                        margin-left: 10px;
                    }
                }
                .coupon-info {
                    margin-top: 40px;
                    padding-bottom: 30px;
                    ul {
                        li {
                            color: lighten($color, 10%);
                            margin-top: 20px;
                            &:last-child {
                                margin-top: 50px;
                            }
                        }
                    }
                }
            }
        }
        .delivery {
            width: 100%;
            background: #fff;
            margin-top: 0.6rem;
            h4 {
                font-size: 24px;
                font-weight: bold;
                padding: 45px 0 15px 30px;
            }
            h5 {
                font-size: 20px;
                font-weight: bold;
                padding-left: 30px;
            }
            label {
                display: block;
                color: #666;
                padding-left: 30px;
                margin-top: 50px;
            }
            input {
                width: 330px;
                height: 56px;
                margin-left: 30px;
                border: 1px solid #2d2d2d;
            }
            textarea {
                width: 330px;
                height: 112px;
                margin-left: 30px;
                border: 1px solid #2d2d2d;
            }
            .address-btn {
                background: $color;
                color: #fff;
                width: 326px;
                height: 56px;
                margin: 50px 0 50px 30px;
                line-height: 56px;
            }
        }
        .option {
            width: 100%;
            background: #fff;
            margin-top: 0.6rem;
            h3 {
                padding-left: 30px;
                padding-top: 45px;
                font-size: 24px;
                font-weight: bold;
                letter-spacing: 1.5px;
            }
            .standard,
            .express {
                display: flex;
                margin: 30px 0 0 30px;
                .freight {
                    margin-right: 10px;
                }
                .info {
                    margin-left: 10px;
                    position: relative;
                    h5 {
                        margin-right: 30px;
                        font-size: 16px;
                    }
                }
            }
            .express {
                padding-bottom: 45px;
            }
        }
        .payment {
            width: 100%;
            background: #fff;
            margin-top: 0.6rem;
            .billing-info {
                &::after {
                    display: block;
                    content: "";
                    width: 90%;
                    height: 1px;
                    background: #666;
                    margin: auto;
                    margin-top: 40px;
                }
                h3 {
                    padding-left: 30px;
                    padding-top: 45px;
                    font-size: 24px;
                    font-weight: bold;
                    letter-spacing: 1.5px;
                    margin-bottom: 45px;
                }
                h4 {
                    padding-left: 30px;
                    font-size: 20px;
                    margin-bottom: 20px;
                }
                h5 {
                    font-size: 20px;
                    padding-left: 30px;
                    color: lighten($color, 5%);
                }
            }
            .payment-type {
                margin-top: 30px;
                .choose {
                    position: relative;
                    padding-bottom: 40px;
                    label {
                        display: block;
                        padding-left: 30px;
                    }
                    .radio {
                        position: absolute;
                        right: 40%;
                        top: 0;
                    }
                }
            }
        }
    }
    .right-info {
        width: 35%;
        height: 650px;
        background: #fff;
        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            a {
                color: #2d2d2d;
            }
            h3 {
                padding-left: 30px;
                padding-top: 20px;
                font-size: 28px;
                font-weight: bold;
                letter-spacing: 1.5px;
                &:last-child {
                    padding-right: 30px;
                    font-size: 24px;
                    font-weight: normal;
                    letter-spacing: 1px;
                }
            }
        }
        .wrapper {
            margin-top: 20px;
            .cart-wrap {
                height: 360px;
                width: 100%;
                overflow-y: scroll;
                .cart {
                    display: flex;
                    img {
                        width: 90px;
                        height: 120px;
                        margin-right: 20px;
                        margin-left: 30px;
                        margin-bottom: 45px;
                    }
                    .cart-info {
                        h3 {
                            font-size: 20px;
                            font-weight: bold;
                        }
                        h4 {
                            font-size: 16px;
                            color: #2d2d2d;
                            margin-right: 12px;
                        }
                    }
                }
            }
            .fee {
                width: 100%;
                display: flex;
                .fee-title {
                    width: 60%;
                    padding-left: 25px;
                    h4 {
                        font-size: 20px;
                        &:last-child {
                            font-size: 22px;
                            font-weight: bold;
                        }
                    }
                }
                .cost {
                    margin-left: 10px;
                    h4 {
                        margin-right: 20px;
                        font-size: 20px;
                        &:last-child {
                            font-size: 22px;
                            font-weight: bold;
                        }
                    }
                }
            }
            .btn-order {
                width: 94%;
                height: 56px;
                background: $color;
                color: #fff;
                line-height: 56px;
                margin-left: 3%;
                margin-top: 3%;
            }
        }
    }
}
</style>
