<template>
    <div>
        <header class="main-header">
            <div class="nav">
                <nav class="main-nav">
                    <router-link to="/" class="logo">
                        <h5>Epoch</h5>
                    </router-link>
                    <router-link to="/women" class="women">WOMEN</router-link>
                    <router-link to="/men" class="men">MEN</router-link>
                </nav>
                <form action="" class="header-search">
                    <input
                        type="search"
                        name=""
                        id=""
                        placeholder="Search for items,style and dream"
                    />
                    <button><i class="fas fa-search"></i></button>
                </form>
                <nav class="side-nav">
                    <li v-on:mouseover="userMouseOver">
                        <a href="#"><i class="icon far fa-user"></i></a>
                    </li>
                    <li>
                        <router-link to="/user/saved" class="women"
                            ><i class="icon far fa-heart"></i
                        ></router-link>
                    </li>
                    <li class="cart" v-on:mouseover="cartMouseOver">
                        <a href="#"><i class="icon fas fa-shopping-bag"></i></a>
                        <div class="dot" :style="{ display: showDot }">
                            {{ items }}
                        </div>
                    </li>
                </nav>
            </div>
        </header>
        <div class="user-wrap" :class="{ rollon: isClose, userdown: isUser }">
            <div class="top">
                <h5 v-if="userName !== undefined">Hi {{ userName }}</h5>
                <router-link to="/login" class="user-account">
                    <h5 v-if="userName == undefined">Sign In |</h5>
                </router-link>
                <router-link to="/register" class="user-account">
                    <h5 v-if="userName == undefined">Join</h5>
                </router-link>
                <a href="#" v-if="userName !== undefined" @click="signout"
                    >Sign Out</a
                >
                <i class="fas fa-times" @click="closeItem"></i>
            </div>
            <div class="info">
                <div class="account">
                    <router-link to="/account" class="user-account">
                        <i class="fas fa-skating"></i>
                        <h5>My Account</h5>
                    </router-link>
                </div>
                <div class="order">
                    <router-link to="/myorder" class="user-order">
                        <i class="fas fa-home"></i>
                        <h5>My Orders</h5>
                    </router-link>
                </div>
            </div>
        </div>
        <div class="card-wrap" :class="{ rollon: isClose, carddown: isCard }">
            <div class="top">
                <h5>My Bag, {{ items }} items</h5>
                <i class="fas fa-times" @click="closeItem"></i>
            </div>
            <div class="empty-bag" :style="{ display: toggle.empty }">
                <div class="wrap">
                    <i class="icon fas fa-shopping-bag"></i>
                    <h4>Your bag is empty</h4>
                    <h5>
                        Items remain in your bag for 1 day, and then they’re
                        moved to your Saved Items.
                    </h5>
                </div>
            </div>
            <div class="cart-item" :style="{ display: toggle.bag }">
                <div class="cart-wrap">
                    <div class="product" v-for="item in carts" :key="item.id">
                        <img
                            :src="'data:image/png;base64,' + item.image"
                            class="img-fluid"
                        />
                        <div class="product-info">
                            <h3>NT {{ item.price | currency }}</h3>
                            <h4>{{ item.name }}</h4>
                            <h4>QTY:{{ item.item }}</h4>
                            <i
                                class="far fa-trash-alt"
                                @click="deleteCart(item.id)"
                            ></i>
                        </div>
                    </div>
                </div>
                <div class="total">
                    <h5>Sub-total</h5>
                    <h5>NT {{ total | currency }}</h5>
                </div>
                <div class="btn-group">
                    <router-link to="/user/bag">
                        <button class="bt btn-bag">VIEW BAG</button>
                    </router-link>
                    <router-link to="/user/checkout">
                        <button class="bt btn-check">CHECKOUT</button>
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "Navbar",
    data() {
        return {
            userName: "",
            uid: "",
            cart: this.$store.state.cart,
            carts: [],
            items: "",
            total: 0,
            isClose: false,
            isCard: false,
            isUser: false,
            showDot: "block",
            toggle: {
                empty: "none",
                bag: "block"
            }
        };
    },
    computed: {
        getCart() {
            return this.$store.state.cart;
        },
        userInfo() {
            return this.$store.state.info;
        }
    },
    watch: {
        getCart: {
            handler(aCart) {
                if (this.$store.state.isEmpty === false) {
                    this.showDot = "none";
                    this.toggle.empty = "block";
                    this.toggle.bag = "none";
                    this.items = aCart.length;
                    this.total = 0;
                } else {
                    this.showDot = "block";
                    this.toggle.empty = "none";
                    this.toggle.bag = "block";
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
                            this.total = 0;
                            this.carts = res.data.data;
                            for (i = 0; i < aCart.length; i++) {
                                this.carts[i].item = aCart[i].num;
                                this.items = aCart.length;
                                this.total =
                                    this.total +
                                    this.carts[i].item * this.carts[i].price;
                            }
                        })
                        .catch(err => {
                            console.log(err);
                        });
                }
            },
            immediate: true,
            deep: true
        },
        userInfo: {
            handler(aInfo) {
                this.userName = aInfo.name;
                this.uid = aInfo.id;
            },
            immediate: true,
            deep: true
        }
    },
    methods: {
        signout() {
            let uid = this.$store.state.info.id;
            axios
                .put("/api/user/logout", {
                    user: uid
                })
                .then(res => {
                    if (res.data.result === true) {
                        localStorage.removeItem("token");
                        localStorage.removeItem("isLogin");
                        this.$router.push("/login");
                    }
                })
        },
        deleteCart(id) {
            axios.delete(`/api/cart/${this.uid}/${id}`).then(() => {
                this.$store.commit("deleteCart", parseInt(id));
            });
        },
        closeItem() {
            this.isCard = false;
            this.isUser = false;
            this.isClose = true;
        },
        userMouseOver() {
            if (this.isCard === true) {
                this.isCard = false;
            }
            this.isUser = true;
        },
        cartMouseOver() {
            if (this.isUser === true) {
                this.isUser = false;
            }
            this.isCard = true;
        }
    }
};
</script>

<style lang="scss" scoped>
$color1: #1ca753;
.main-header {
    height: 60px;
    width: 100%;
    background: #2d2d2d;
    position: relative;
    z-index: 3;
    a {
        text-decoration: none;
    }
    .nav {
        display: flex;
        justify-content: center;
        .main-nav {
            display: flex;
            text-align: center;
            align-items: center;
            .logo {
                color: #fff;
                margin-right: 30px;
                margin-top: 5px;
                h5 {
                    font-size: 40px;
                    font-family: "IM Fell Great Primer SC";
                }
            }
            .women,
            .men {
                color: #eee;
                width: 114px;
                height: 60px;
                font-size: 18px;
                line-height: 60px;
                border-right: 1px solid #666;
                font-family: "IM Fell Great Primer SC";
            }
            .women {
                border-left: 1px solid #666;
            }
        }
        .header-search {
            display: flex;
            width: 40%;
            height: 40px;
            align-items: center;
            padding-top: 18px;
            padding-left: 30px;
            button,
            input {
                border: none;
                background-color: #fff;
                padding: 5px 10px;
                &:focus {
                    //focus藍框移除
                    outline: none;
                }
            }
            button {
                //左上 右上 右下 左下
                border-radius: 0 200px 200px 0;
            }
            input {
                width: 100%;
                border-radius: 200px 0 0 200px;
            }
        }
        .side-nav {
            display: flex;
            padding-left: 20px;
            width: 10%;
            li {
                .icon {
                    color: #fff;
                    width: 55px;
                    height: 60px;
                    line-height: 60px;
                }
            }
        }
    }
}
.cart {
    position: relative;
    .dot {
        width: 15px;
        height: 15px;
        background: #0f4c81;
        font-size: 10px;
        text-align: center;
        border-radius: 50%;
        line-height: 15px;
        position: absolute;
        right: 30px;
        top: 15px;
        color: #fff;
        font-family: "Sriracha";
    }
}
.card-wrap {
    position: absolute;
    z-index: 2;
    right: 40px;
    top: -560px;
    width: 320px;
    background: #fff;
    border: 1px solid rgb(219, 216, 216);
    .empty-bag {
        width: 100%;
        height: 260px;
        background: #fff;
        display: flex;
        .wrap {
            width: 70%;
            height: 260px;
            background: #fff;
            margin: auto;
            text-align: center;
            padding-top: 35px;
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
    .top {
        background: lighten(#999, 28%);
        width: 100%;
        height: 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        h5 {
            font-size: 20px;
            font-family: "Sriracha";
            padding-left: 10px;
            padding-top: 3px;
        }
        .fa-times {
            font-size: 24px;
            padding-right: 10px;
            cursor: pointer;
        }
    }
    .cart-item {
        margin-top: 15px;
        .cart-wrap {
            height: 360px;
            width: 100%;
            overflow-y: scroll;
            .product {
                padding-left: 10px;
                display: flex;
                margin-bottom: 20px;
                img {
                    width: 90px;
                    height: 120px;
                    margin-right: 20px;
                }
                .product-info {
                    font-family: "Sriracha";
                    &:hover {
                        h3,
                        h4 {
                            color: rgb(102, 123, 216);
                        }
                    }
                    h3 {
                        font-size: 18px;
                        font-weight: bold;
                    }
                    h4 {
                        font-size: 14px;
                        color: #2d2d2d;
                    }
                    .fa-trash-alt {
                        cursor: pointer;
                    }
                }
            }
        }

        .total {
            display: flex;
            justify-content: space-around;
            align-items: flex-end;
            width: 100%;
            height: 55px;
            background: #eee;
            h5 {
                font-family: "Sriracha";
                font-size: 20px;
            }
        }
        .btn-group {
            width: 100%;
            height: 70px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            background: lighten(#999, 28%);
            .bt {
                font-family: "Sriracha";
                width: 125px;
                height: 40px;
            }
            .btn-bag {
                background: #fff;
                color: #2d2d2d;
            }
            .btn-check {
                background: #1ca753;
                color: #fff;
            }
        }
    }
}
.user-wrap {
    position: absolute;
    z-index: 2;
    right: 170px;
    top: -80px;
    width: 300px;
    background: #fff;
    border: 1px solid rgb(219, 216, 216);
    .top {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        width: 100%;
        height: 45px;
        background: lighten(#999, 28%);
        font-family: "Sriracha";
        position: relative;
        h5 {
            margin-right: 10px;
            margin-top: 5px;
            margin-left: 5px;
            color: #2d2d2d;
            font-size: 24px;
        }
        a {
            color: #2d2d2d;
            text-decoration: underline;
            font-size: 20px;
            margin-bottom: 5px;
            &:hover {
                color: #0f4c81;
            }
        }
        .fa-times {
            position: absolute;
            right: 10px;
            cursor: pointer;
        }
    }
    .info {
        .account {
            width: 100%;
            height: 45px;
            border-bottom: 1px solid lighten(#666666, 40%);
            font-family: "Sriracha";
            .user-account {
                display: flex;
                color: #2d2d2d;
                .fa-skating {
                    margin: 10px;
                }
                h5 {
                    font-size: 22px;
                    margin-top: 6px;
                }
            }
        }
        .order {
            width: 100%;
            height: 45px;
            font-family: "Sriracha";
            .user-order {
                display: flex;
                color: #2d2d2d;
                .fa-home {
                    margin: 10px;
                }
                h5 {
                    font-size: 22px;
                    margin-top: 6px;
                }
            }
        }
    }
}
.rollon {
    transform: translateY(-600px);
    transition: 1.5s;
}
.userdown {
    transform: translateY(140px);
    transition: 0.8s;
}
.carddown {
    transform: translateY(620px);
    transition: 0.8s;
}
</style>
