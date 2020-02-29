<template>
    <div class="wrap">
        <Navbar></Navbar>
        <div class="banner">
            <div class="banner-top">
                <a href="#">
                    GET 20% OFF TOP PICKS
                </a>
            </div>
            <div class="banner-bottom">
                Limited time only. Selected styles marked down on site
            </div>
        </div>
        <div class="container">
            <div class="ad">
                <div class="title">The Y2K trend</div>
                <a href="#">
                    <div class="shop-link">
                        shop now
                    </div>
                </a>
            </div>
            <div class="row mt-5">
                <div class="col-6">
                    <img src="../assets/image/1.jpg" alt="" />
                    <h4>NEW-SEASON STYLES</h4>
                    <h5>Looks you haven't met yet</h5>
                    <a href="#">
                        <div class="shop-link">
                            SHOP NOW
                        </div>
                    </a>
                </div>
                <div class="col-6">
                    <img src="../assets/image/2.jpg" alt="" />
                    <h4>VARSITY VIBES</h4>
                    <h5>Campus it up</h5>
                    <a href="#">
                        <div class="shop-link">
                            SHOP THE BRAND
                        </div>
                    </a>
                </div>
                <div class="col-6">
                    <img src="../assets/image/3.jpg" alt="" />
                    <h4>FRESH CO-ORDS</h4>
                    <h5>What a match!</h5>
                    <a href="#">
                        <div class="shop-link">
                            SHOP NOW
                        </div>
                    </a>
                </div>
                <div class="col-6">
                    <img src="../assets/image/4.jpg" alt="" />
                    <h4>NEW COLLUSION</h4>
                    <h5>Oversized, graphic goodness</h5>
                    <a href="#">
                        <div class="shop-link">
                            SHOP THE BRAND
                        </div>
                    </a>
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
        <div class="vuestore">
            <h5>VUESTORE</h5>
        </div>
    </div>
</template>

<script>
import Navbar from "../components/Navbar";
import Carousel from "../components/Carousel";
import { mapState, mapActions } from "vuex";
export default {
    name: "Index",
    components: {
        Navbar,
        Carousel
    },
    computed: mapState({
        user: state => state.users
    }),
    created() {
        this.getUser();
        // console.log(this.$store.state);
    },
    methods: {
        // 映射 vuex 对象上的方法
        ...mapActions(["getUser"])
    }
};
</script>
<style lang="scss" scoped>
* {
    list-style: none;
}
.wrap {
    height: 100vh;
}
.banner {
    width: 100%;
    height: 120px;
    background: #1ca753;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    .banner-top {
        width: 500px;
        height: 55px;
        background: #1010c4;
        box-shadow: 0.37em 0 0 #1010c4, -0.37em 0 0 #1010c4;
        margin-top: 20px;
        text-align: center;
        a {
            font-family: "Krona One", sans-serif;
            color: #fa81e4;
            font-size: 28px;
            line-height: 55px;
            text-decoration: none;
        }
    }
    .banner-bottom {
        color: #fff;
        font-size: 10px;
        padding-top: 16px;
    }
}
.container {
    .ad {
        width: 100%;
        height: 600px;
        background-image: url(../assets/image/ads.jpg);
        background-repeat: no-repeat;
        background-size: cover;
        margin-top: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        .title {
            font-family: "Krona One", sans-serif;
            color: #fff;
            font-size: 64px;
        }
        a {
            text-decoration: none;
            background: #fff;
            color: #000;
            transition: 0.6s;
            &:hover {
                background: #000;
                color: #fff;
            }
            .shop-link {
                font-family: "Krona One", sans-serif;
                width: 180px;
                height: 44px;
                font-size: 18px;
                line-height: 44px;
                text-align: center;
                border: solid 2px #000;
            }
        }
    }
    .row {
        .col-6 {
            text-align: center;
            padding-bottom: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            h4 {
                font-family: "Sriracha", cursive;
                font-weight: bold;
                margin-top: 15px;
            }
            h5 {
                font-size: 18px;
            }
            img {
                width: 500px;
                height: 640px;
            }
            a {
                text-decoration: none;
                background: #fff;
                color: #000;
                transition: 0.6s;
                margin-top: 8px;
                &:hover {
                    background: #000;
                    color: #fff;
                }
                .shop-link {
                    font-family: "Krona One", sans-serif;
                    width: 180px;
                    height: 44px;
                    font-size: 12px;
                    font-weight: bold;
                    line-height: 44px;
                    text-align: center;
                    border: solid 2px #000;
                }
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
.vuestore {
    padding-left: 21%;
    height: 45px;
    h5 {
        font-size: 18px;
        font-family: "Krona One", sans-serif;
        line-height: 45px;
    }
}
</style>
