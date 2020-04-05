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
                    MEN
                </div></router-link
            >
        </div>
        <div class="title">
            <h5>Saved Items</h5>
        </div>
        <div class="wrap-loading">
            <loading
                loader="dots"
                :active.sync="wrapLoading"
                :is-full-page="false"
                :opacity="1"
            >
            </loading>
            <div class="empty" :style="{ display: isA }">
                <div class="box">
                    <i class="far fa-heart"></i>
                    <h4>You have no Saved Items</h4>
                    <h5>
                        Start saving as you shop by selecting the little heart.
                        We'll sync your items across all your devices. Easy.
                    </h5>
                    <router-link to="/" class="">
                        <button>START SHOPPING</button>
                    </router-link>
                </div>
            </div>
            <div class="product" :style="{ display: isB }">
                <div v-for="item in products" :key="item.id" class="item">
                    <img
                        :src="'data:image/png;base64,' + item.image"
                        class="img-fluid"
                    />
                    <div class="heart">
                        <i
                            class="far fa-trash-alt"
                            @click="deleteCart(item.id)"
                        ></i>
                    </div>
                    <div class="item-txt">
                        <h5>{{ item.name }}</h5>
                        <h4>NT {{ item.price | currency }}</h4>
                    </div>
                    <button class="bag-btn" @click="moveToBag(item.id)">
                        MOVE TO BAG
                    </button>
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
                            You're in <i class="fas fa-globe-americas"></i> |
                            Change
                        </h5>
                    </div>
                </div>
                <div class="foot-bot">
                    <h5>&copy; 2020</h5>
                    <h5>Privacy & Cookies | Ts&Cs | Accessibility</h5>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import Navbar from "../components/Navbar";
export default {
    name: "Saved",
    data() {
        return {
            wrapLoading: false,
            uid: this.$store.state.info.id,
            isA: "none",
            isB: "flex",
            products: []
        };
    },
    components: {
        Navbar
    },
    computed: {
        userInfo() {
            return this.$store.state.info;
        }
    },
    watch: {
        userInfo: {
            handler(aInfo) {
                this.userName = aInfo.name;
                this.uid = aInfo.id;
                this.getSavedItems(this.uid);
            },
            immediate: true
        }
    },
    methods: {
        getSavedItems(id) {
            this.wrapLoading = true;
            axios
                .get(`/api/user/saved/${id}`)
                .then(res => {
                    if (res.data.result === true) {
                        this.isA = "none";
                        this.isB = "flex";
                        this.products = res.data.data;
                        this.allNum = res.data.total;
                    } else {
                        this.isA = "block";
                        this.isB = "none";
                    }
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
        moveToBag(id) {
            let token = localStorage.getItem("token");
            axios
                .put(`/api/saved/moveback/${this.uid}/${id}`)
                .then(() => {
                    this.$store.commit("getUserInfo", token);
                    this.getSavedItems(this.uid);
                })
                .catch(() => {
                    this.$notify.error({
                        title: "Something Goes Wrong ...",
                        message: "Please refresh your page again",
                        duration: 6800
                    });
                });
        },
        deleteCart(id) {
            axios
                .delete(`/api/cart/${this.uid}/${id}`)
                .then(() => {
                    this.$store.commit("deleteCart", parseInt(id));
                    this.getSavedItems(this.uid);
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
};
</script>

<style lang="scss" scoped>
$color: #232323;
.wrap-loading {
    position: relative;
}
.banner {
    display: flex;
    height: 50px;
    background: #20c891;
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
.title {
    width: 100%;
    height: 80px;
    background: #eee;
    color: #2d2d2d;
    text-align: center;
    h5 {
        line-height: 80px;
        font-weight: bold;
    }
}
.empty {
    width: 100%;
    height: 400px;
    text-align: center;
    .box {
        width: 300px;
        margin: auto;
        margin-top: 160px;
        h4 {
            font-size: 20px;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        h5 {
            width: 320px;
            font-size: 15px;
        }
        button {
            width: 100%;
            height: 45px;
            color: #fff;
            background: #2d2d2d;
            margin: 8px 0px 0px;
            padding: 1px 7px 2px;
            font-size: 16px;
        }
    }
}
.product {
    width: 1300px;
    display: flex;
    flex-wrap: wrap;
    margin: auto;
    margin-top: 15px;
    .item {
        position: relative;
        padding: 10px;
        margin-top: 25px;
        a {
            text-decoration: none;
        }
        img {
            width: 300px;
            height: 404px;
        }
        .heart {
            width: 36px;
            height: 36px;
            text-align: center;
            position: absolute;
            background: #fff;
            border-radius: 50%;
            bottom: 135px;
            right: 20px;
            .far {
                line-height: 36px;
                width: 20px;
                height: 18px;
                color: #2d2d2d;
                cursor: pointer;
            }
        }
        .item-txt {
            margin-top: 10px;
            h5 {
                font-size: 16px;
                color: #000000;
            }
            h4 {
                font-size: 18px;
                color: #2d2d2d;
            }
        }
        .bag-btn {
            background: Transparent;
            width: 100%;
            height: 32px;
            font-size: 14px;
            font-weight: bold;
            border: 2px solid darken(#1ca753, 5%);
            margin-top: 15px;
        }
    }
}
.page {
    width: 1300px;
    margin: auto;
    text-align: center;
    margin-top: 25px;
    font-family: "Cormorant SC";
    h5 {
        font-size: 18px;
        color: #666666;
    }
    .progress {
        width: 20%;
        margin: auto;
        margin-top: 20px;
    }
    .load {
        margin: auto;
        width: 300px;
        height: 55px;
        color: #fff;
        line-height: 55px;
        font-size: 18px;
        margin-top: 25px;
        font-weight: bold;
        background: #0f4c81;
    }
}
.social {
    height: 60px;
    margin-top: 50px;
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
