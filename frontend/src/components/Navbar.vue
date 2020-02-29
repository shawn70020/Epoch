<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">VueStore</a>
        <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#"
                        >Home <span class="sr-only">(current)</span></a
                    >
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" @click="signout">Sign In</a>
                </li>
                <li class="nav-item dropdown">
                    <a
                        class="nav-link dropdown-toggle"
                        href="#"
                        id="navbarDropdownMenuLink"
                        role="button"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                    >
                        Top Trand
                    </a>
                    <div
                        class="dropdown-menu"
                        aria-labelledby="navbarDropdownMenuLink"
                    >
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#"
                            >Something else here</a
                        >
                    </div>
                </li>
                <li class="nav-item cart">
                    <a class="nav-link" href="#"
                        ><i class="fas fa-shopping-bag"></i
                    ></a>
                    <div class="dot">{{ items }}</div>
                    <div class="card-wrap">
                        <div class="triangle-1"></div>
                        <div class="top">
                            <h5>My Bag, {{ items }} items</h5>
                        </div>
                        <div class="cart-item">
                            <div
                                class="product"
                                v-for="item in carts"
                                :key="item.id"
                            >
                                <img
                                    :src="'data:image/png;base64,' + item.image"
                                    class="img-fluid"
                                />
                                <div class="product-info">
                                    <h3>NT$ {{ item.price }}</h3>
                                    <h4>{{ item.name }}</h4>
                                    <h4>QTY:{{ item.item }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
import axios from "axios";
export default {
    name: "Navbar",
    data() {
        return {
            uid: this.$store.state.info,
            cart: this.$store.state.cart,
            carts: [],
            items: ""
        };
    },
    created() {
        this.getUserCart();
    },
    methods: {
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
                        console.log(123);
                        this.carts[i].item = this.cart[i].num;
                        this.items = aCart.length;
                    }
                })
                .catch(err => {
                    console.log(err);
                });
        },
        signout() {
            localStorage.removeItem("token");
            localStorage.removeItem("isLogin");
            this.$router.push("/login");
        }
    }
};
</script>
<style lang="scss">
nav{
    position: relative;
    z-index: 99;
}
.cart {
    position: relative;
    &:hover {
        .card-wrap {
            z-index:auto;
            transition: 1.2s;
            transform: translateY(650px);
        }
    }
    .dot {
        width: 15px;
        height: 15px;
        background: #faf;
        font-size: 10px;
        text-align: center;
        border-radius: 50%;
        line-height: 15px;
        position: absolute;
        right: 2px;
        top: 10px;
        color: #2d2d2d;
    }
    .card-wrap {
        position: absolute;
        top: -590px;
        z-index: -2;
        width: 320px;
        background: #fff;
        border: 1px solid rgb(219, 216, 216);
        .triangle-1 {
            position: absolute;
            top: -32px;
            left: 5px;
            border-color: transparent transparent #ccc transparent;
            border-style: solid solid solid solid;
            border-width: 16px;
            height: 0px;
            width: 0px;
        }
        .top {
            background: #ccc;
            h5{
                font-size: 20px;
                font-family: "Sriracha";
                padding: 5px;
            }
        }
        .cart-item {
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
                    &:hover{
                        h3,h4{
                            color: rgb(102, 123, 216);
                        }
                        
                    }
                    h3{
                        font-size: 18px;
                        font-weight: bold;
                    }
                    h4 {
                        font-size: 14px;
                        color: #2d2d2d;
                    }
                }
            }
        }
    }
}
</style>
