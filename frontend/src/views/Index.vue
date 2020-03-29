<template>
    <div class="wrap">
        <Navbar></Navbar>
        <div class="banner-up">
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
        <div class="banner">
            <div class="banner-top">
                <router-link to="/women" class="">
                    <div class="solgan1">GET 20% OFF*</div>
                    <div class="solgan2">(HELLO, SAVED ITEMS)</div>
                    <div class="solgan3">With code: AMAZING20</div>
                </router-link>
            </div>
            <div class="banner-bottom">
                *Limited time only. Selected styles marked down on site
            </div>
        </div>
        <div class="container">
            <div class="ad">
                <div class="title">The Y2K trend</div>
                <router-link to="/women" class="">
                    <div class="shop-link">
                        shop now
                    </div>
                </router-link>
            </div>
            <div class="row mt-5">
                <div class="col-6">
                    <img src="../assets/image/1.jpg" alt="" />
                    <h4>NEW-SEASON STYLES</h4>
                    <h5>Looks you haven't met yet</h5>
                    <router-link to="/men" class="">
                        <div class="shop-link">
                            SHOP NOW
                        </div>
                    </router-link>
                </div>
                <div class="col-6">
                    <img src="../assets/image/2.jpg" alt="" />
                    <h4>VARSITY VIBES</h4>
                    <h5>Campus it up</h5>
                    <router-link to="/men" class="">
                        <div class="shop-link">
                            SHOP THE BRAND
                        </div>
                    </router-link>
                </div>
                <div class="col-6">
                    <img src="../assets/image/3.jpg" alt="" />
                    <h4>FRESH CO-ORDS</h4>
                    <h5>What a match!</h5>
                    <router-link to="/men" class="">
                        <div class="shop-link">
                            SHOP NOW
                        </div>
                    </router-link>
                </div>
                <div class="col-6">
                    <img src="../assets/image/4.jpg" alt="" />
                    <h4>NEW COLLUSION</h4>
                    <h5>Oversized, graphic goodness</h5>
                    <router-link to="/women" class="">
                        <div class="shop-link">
                            SHOP THE BRAND
                        </div>
                    </router-link>
                </div>
            </div>
        </div>
        <div class="block">
            <el-carousel trigger="click" height="580px">
                <el-carousel-item v-for="item in 4" :key="item">
                </el-carousel-item>
            </el-carousel>
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
                        You're in <i class="fas fa-globe-americas"></i>| Change
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
import Navbar from "../components/Navbar";
export default {
    name: "Index",
    components: {
        Navbar
    }
};
</script>
<style lang="scss" scoped>
$color: #7f033b;
* {
    list-style: none;
}
.wrap {
    height: 100vh;
}
.banner-up {
    display: flex;
    height: 50px;
    background: #ff9173;
    align-items: center;
    justify-content: space-around;
    font-family: "Sriracha";
    margin-bottom: 2px;
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
.banner {
    width: 100%;
    height: 210px;
    background: #ff9173;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    .banner-top {
        width: 500px;
        height: 160px;
        background: #ff9173;
        margin-top: 20px;
        text-align: center;
        a {
            font-family: "Sriracha";
            color: #fffd37;
            text-decoration: none;
            .solgan1,
            .solgan2,
            .solgan3 {
                background: $color;
                margin: auto;
            }
            .solgan1 {
                width: 300px;
                height: 50px;
                line-height: 50px;
                font-size: 32px;
            }
            .solgan2 {
                width: 400px;
                height: 50px;
                line-height: 50px;
                margin-top: 3px;
                font-size: 32px;
            }
            .solgan3 {
                width: 250px;
                height: 35px;
                line-height: 35px;
                margin-top: 10px;
                font-size: 20px;
            }
        }
    }
    .banner-bottom {
        color: #000;
        font-size: 10px;
        padding: 5px;
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
.el-carousel__item:nth-child(2n) {
    background-image: url(../assets/image/hi6.jpg);
    background-repeat: no-repeat;
    background-size: cover;
}

.el-carousel__item:nth-child(2n + 1) {
    background-image: url(../assets/image/hi5.jpg);
    background-repeat: no-repeat;
    background-size: cover;
}
.el-carousel__item:nth-child(5) {
    background-image: url(../assets/image/hi8.jpg);
    background-repeat: no-repeat;
    background-size: cover;
}
.el-carousel__item:nth-child(6) {
    background-image: url(../assets/image/hi10.jpg);
    background-repeat: no-repeat;
    background-size: cover;
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
    height: 45px;
    h5 {
        font-size: 30px;
        font-family: "IM Fell Great Primer SC";
        line-height: 45px;
    }
}
</style>
