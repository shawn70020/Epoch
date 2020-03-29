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
                                @keyup.enter="useCoupon"
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
                    <h5>ADD ORDER DETAIL</h5>
                    <el-form
                        :model="ruleForm"
                        :rules="rules"
                        ref="ruleForm"
                        label-width="100px"
                        class="demo-ruleForm"
                        label-position="top"
                        size="medium"
                    >
                        <el-form-item label="FULL NAME :" prop="name">
                            <el-input v-model="ruleForm.name"></el-input>
                        </el-form-item>
                        <el-form-item
                            label="Mobile :"
                            prop="phone"
                            :rules="[
                                {
                                    required: true,
                                    message: 'Mobile should not empty'
                                },
                                {
                                    type: 'number',
                                    message: 'Please input number'
                                }
                            ]"
                        >
                            <el-input
                                type="phone"
                                v-model.number="ruleForm.phone"
                                autocomplete="off"
                            ></el-input>
                        </el-form-item>
                        <el-form-item label="ADDRESS :" prop="address">
                            <el-input v-model="ruleForm.address"></el-input>
                        </el-form-item>
                        <el-form-item label="NOTE :" prop="note">
                            <el-input
                                type="textarea"
                                v-model="ruleForm.note"
                            ></el-input>
                        </el-form-item>
                        <div class="delivery-radio">
                            <el-form-item label="Delivery :" prop="delivery">
                                <el-radio-group v-model="ruleForm.delivery">
                                    <el-radio label="S"
                                        >Standard Delivery</el-radio
                                    >
                                    <h5>
                                        NT $100 Delivered on or before
                                        {{
                                            moment()
                                                .add(10, "days")
                                                .calendar()
                                        }}
                                    </h5>

                                    <el-radio label="E"
                                        >Express Delivery</el-radio
                                    >
                                    <h5>
                                        NT $300 Delivered on or before
                                        {{
                                            moment()
                                                .add(3, "days")
                                                .calendar()
                                        }}
                                    </h5>
                                </el-radio-group>
                            </el-form-item>
                        </div>
                        <div class="payment-radio">
                            <el-form-item label="Payment :" prop="payment">
                                <el-radio-group v-model="ruleForm.payment">
                                    <el-radio label="Card"
                                        ><i class="fab fa-cc-visa">
                                            CREDIT CARD
                                        </i></el-radio
                                    >
                                    <el-radio label="Cash"
                                        ><i class="fas fa-people-arrows">
                                            CASH ON DELIVERY
                                        </i></el-radio
                                    >
                                    <el-radio label="Atm"
                                        ><i class="fab fa-cc-paypal">
                                            ATM TRANSFER
                                        </i></el-radio
                                    >
                                </el-radio-group>
                            </el-form-item>
                        </div>
                    </el-form>
                </div>
                <div class="payment">
                    <div class="billing-info">
                        <h3>PAYMENT</h3>
                        <h4>BILLING ADDRESS</h4>
                        <h5 v-if="ruleForm.name !== ''">
                            <i class="fas fa-user-circle">
                                {{ ruleForm.name }}</i
                            >
                        </h5>
                        <h5 v-if="ruleForm.address !== ''">
                            <i class="fas fa-map-marker-alt">
                                {{ ruleForm.address }}</i
                            >
                        </h5>
                        <h5 v-if="ruleForm.phone !== ''">
                            <i class="fas fa-phone-square">
                                {{ ruleForm.phone }}</i
                            >
                        </h5>
                        <h5 v-if="ruleForm.delivery === 'S'">
                            <i class="fas fa-truck"> Standard Delivery</i>
                        </h5>
                        <h5 v-if="ruleForm.delivery === 'E'">
                            <i class="fas fa-truck"> Express Delivery</i>
                        </h5>
                        <h5 v-if="ruleForm.payment === 'Cash'">
                            <i class="fas fa-wallet">
                                CASH ON DELIVERY
                            </i>
                        </h5>
                        <h5 v-if="ruleForm.payment === 'Atm'">
                            <i class="fab fa-cc-paypal">
                                ATM TRANSFER
                            </i>
                        </h5>
                        <h5 v-if="ruleForm.payment === 'Card'">
                            <i class="fab fa-cc-visa">
                                CREDIT CARD
                            </i>
                        </h5>
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
                            <h4 v-if="ruleForm.delivery === 'S'">
                                NT {{ 100 | currency }}
                            </h4>
                            <h4 v-if="ruleForm.delivery === 'E'">
                                NT {{ 300 | currency }}
                            </h4>
                            <h4 v-if="ruleForm.delivery === ''">
                                NT {{ 0 | currency }}
                            </h4>
                            <h4>
                                <span class="cut">-</span>NT
                                {{ discount | currency }}
                            </h4>
                            <h4>NT {{ total | currency }}</h4>
                        </div>
                    </div>
                    <button class="btn-order" @click="submitForm('ruleForm')">
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
            ruleForm: {
                name: "",
                phone: "",
                address: "",
                note: "",
                delivery: "",
                payment: ""
            },
            carts: [],
            items: "",
            subtotal: "",
            discount: 0,
            rules: {
                name: [
                    {
                        required: true,
                        message: "Please Enter Your Full Name",
                        trigger: "blur"
                    }
                ],
                address: [
                    {
                        required: true,
                        message: "Please Enter Your Address",
                        trigger: "blur"
                    }
                ],
                delivery: [
                    {
                        required: true,
                        message: "At least Choose One",
                        trigger: "change"
                    }
                ],
                payment: [
                    {
                        required: true,
                        message: "At least Choose One Payment",
                        trigger: "change"
                    }
                ]
            }
        };
    },
    computed: {
        getCart() {
            return this.$store.state.cart;
        },
        total() {
            if (this.ruleForm.delivery === "S") {
                return this.subtotal + 100 - this.discount;
            } else if (this.ruleForm.delivery === "E") {
                return this.subtotal + 300 - this.discount;
            } else {
                return this.subtotal + 0 - this.discount;
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
        submitForm(formName) {
            this.$refs[formName].validate(valid => {
                if (valid) {
                    let checkout = [];
                    checkout = this.$store.state.cart;
                    let info = this.$store.state.info;
                    let finalTotal;
                    if (this.ruleForm.delivery === "S") {
                        finalTotal = this.subtotal + 100 - this.discount;
                    } else {
                        finalTotal = this.subtotal + 300 - this.discount;
                    }
                    axios
                        .post("/api/user/checkout", {
                            cart: checkout,
                            user: info,
                            detail: this.ruleForm,
                            total: finalTotal
                        })
                        .then(res => {
                            if (res.data.result === true) {
                                this.$notify({
                                    title: "Success",
                                    message: "Your Order is Send",
                                    type: "success"
                                });
                                this.$store.commit("checkoutCart");
                                this.$router.push("/myorder");
                            } else {
                                this.$notify.error({
                                    title: "Sorry",
                                    message: res.data.msg
                                });
                            }
                        })
                        .catch(err => {
                            console.log(err);
                        });
                } else {
                    console.log("error submit!!");
                    return false;
                }
            });
        },
        success() {
            this.$notify({
                title: "Success",
                message: "Use The Coupon",
                type: "success"
            });
        },
        error() {
            this.$notify.error({
                title: "Sorry",
                message: "This Coupon Is Not Exist"
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
                    cursor: pointer;
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
            form {
                width: 85%;
                margin: auto;
                padding-bottom: 20px;
                .delivery-radio {
                    h5 {
                        font-size: 16px;
                        padding-bottom: 10px;
                    }
                }
                .payment-radio {
                    label {
                        display: block;
                        margin-bottom: 25px;
                    }
                }
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
                padding-bottom: 10px;
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
        .cut {
            position: relative;
            right: 10px;
        }
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
