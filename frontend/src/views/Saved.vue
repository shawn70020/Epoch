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
        <div class="product">
            <div v-for="item in products" :key="item.id" class="item">
                <img
                    :src="'data:image/png;base64,' + item.image"
                    class="img-fluid"
                />
                <div class="heart"><i class="far fa-trash-alt"></i></div>
                <div class="item-txt">
                    <h5>{{ item.name }}</h5>
                    <h4>NT {{ item.price | currency }}</h4>
                </div>
                <button class="bag-btn" @click="moveToBag(item.id)">
                    MOVE TO BAG
                </button>
            </div>
        </div>
        <div class="page">
            <h5>You've viewed {{ nowNum }} of {{ allNum }} products</h5>
            <div class="progress" style="height: 2.5px;">
                <div
                    class="progress-bar"
                    role="progressbar"
                    :style="{ width: bar }"
                    aria-valuenow="20"
                    aria-valuemin="0"
                    aria-valuemax="100"
                ></div>
            </div>
            <button
                class="load"
                :style="{ display: loadBtn }"
                @click="changePage"
            >
                LOAD MORE
            </button>
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
    name: "Saved",
    data() {
        return {
            uid: this.$store.state.info.id,
            show: "none",
            products: [],
            nowNum: 12,
            allNum: 1,
            bar: "1%",
            page: 2,
            loadBtn: "block"
        };
    },
    components: {
        Navbar
    },
    created() {
        this.getSavedItems(this.uid);
    },
    methods: {
        getSavedItems(id) {
            axios
                .get(`/api/user/saved/${id}`)
                .then(res => {
                    this.products = res.data.data;
                    this.allNum = res.data.total;
                    let barWidth;
                    barWidth = (
                        this.products.length *
                        (100 / this.allNum)
                    ).toString();
                    this.bar = barWidth + "%";
                    if (this.nowNum === this.allNum) {
                        this.loadBtn = "none";
                    } else {
                        this.loadBtn = "block";
                    }
                })
                .catch(err => {
                    console.log(err);
                });
        },
        moveToBag(id) {
            axios
                .put(`/api/saved/moveback/${this.uid}/${id}`)
                .then(res => {
                    console.log(res);
                    this.getSavedItems(this.uid);
                })
                .catch(err => {
                    console.log(err);
                });
        },
        changePage() {
            axios
                .get(`/api/products/men/page=${this.page}`)
                .then(res => {
                    let newData = res.data.data;
                    console.log(newData[0]);
                    for (let i = 0; i < newData.length; i++) {
                        this.products.push(newData[i]);
                    }
                    this.nowNum = this.products.length;
                    this.page = this.page + 1;
                    let barWidth;
                    barWidth = (
                        this.products.length *
                        (100 / this.allNum)
                    ).toString();
                    this.bar = barWidth + "%";
                    if (this.nowNum === this.allNum) {
                        this.loadBtn = "none";
                    } else {
                        this.loadBtn = "block";
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
$color: #1010c4;
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
.product {
    width: 1300px;
    display: flex;
    flex-wrap: wrap;
    margin: auto;

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
            bottom: 110px;
            right: 20px;
            .far {
                line-height: 36px;
                width: 20px;
                height: 18px;
                color: #2d2d2d;
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
    margin-top: 30px;
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
