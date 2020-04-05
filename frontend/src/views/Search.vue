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
        <div class="wrap-loading">
            <loading
                loader="dots"
                :active.sync="wrapLoading"
                :is-full-page="false"
                :opacity="1"
                class="load-fix"
            >
            </loading>
            <div class="navs">
                <ol class="bread">
                    <li><router-link to="/">Home</router-link></li>
                    <li>
                        <a href="#">Search results for {{ search }}</a>
                    </li>
                </ol>
            </div>
            <div class="empty" v-if="this.products.length === 0">
                <div class="title">
                    <h4>NOTHING MATCHES YOUR SEARCH</h4>
                    <h5>
                        But don't give up – check the spelling or try less
                        specific search terms.
                    </h5>
                </div>
                <div class="shop">
                    <h5>Shop New in</h5>
                    <div class="commend">
                        <div class="women">
                            <router-link to="/women" class="">
                                <img
                                    src="../assets/image/women.jpg"
                                    class="img-fluid"
                                />
                                <h4>WOMEN</h4>
                            </router-link>
                        </div>
                        <div class="men">
                            <router-link to="/men" class="">
                                <img
                                    src="../assets/image/men.jpg"
                                    class="img-fluid"
                                />
                                <h4>MEN</h4>
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
            <div class="search-result" v-if="this.products.length !== 0">
                <div class="title">
                    <h5>Your search results for:</h5>
                    <h3>"{{ search }}"</h3>
                </div>
                <div class="num">
                    <h5>{{ allNum }} styles fond</h5>
                </div>
                <div class="product">
                    <div v-for="item in products" :key="item.id" class="item">
                        <router-link
                            :to="{
                                name: 'Item',
                                params: { pid: item.id }
                            }"
                        >
                            <img
                                :src="'data:image/png;base64,' + item.image"
                                class="img-fluid"
                            />
                            <div class="item-txt">
                                <h5>{{ item.name }}</h5>
                                <h4>NT {{ item.price | currency }}</h4>
                            </div>
                        </router-link>
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
                    <div class="loading">
                        <loading
                            loader="bars"
                            :active.sync="isLoading"
                            :is-full-page="false"
                            :opacity="1"
                        ></loading>
                        <button
                            class="load"
                            :style="{ display: loadBtn }"
                            @click="changePage"
                        >
                            LOAD MORE
                        </button>
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
    data() {
        return {
            isLoading: false,
            wrapLoading: false,
            show: "none",
            products: [],
            nowNum: "",
            allNum: "",
            bar: "1%",
            page: 2,
            loadBtn: "block",
            search: ""
        };
    },
    components: {
        Navbar
    },
    computed: {
        getQuery() {
            return this.$route.query.q;
        }
    },
    watch: {
        getQuery: {
            handler(sQuery) {
                this.wrapLoading = true;
                axios
                    .get(`/api/search/${sQuery}`)
                    .then(res => {
                        this.products = res.data.data;
                        this.allNum = res.data.total;
                        this.nowNum = res.data.data.length;
                        this.search = sQuery;
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
            immediate: true,
            deep: true
        }
    },
    methods: {
        changePage() {
            this.isLoading = true;
            axios
                .get(`/api/search/${this.search}/page=${this.page}`)
                .then(res => {
                    let newData = res.data.data;
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
                    this.isLoading = false;
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
$color: #5067b3;
.wrap-loading {
    position: relative;
}
.banner {
    display: flex;
    height: 50px;
    background: $color;
    align-items: center;
    justify-content: space-around;
    font-family: "Sriracha";
    h5 {
        padding-top: 10px;
        font-size: 18px;
        color: #fff;
    }
    a {
        width: 96px;
        height: 30px;
        text-decoration: none;
        color: #fff;
        border: 2px solid #fff;
        text-align: center;
        line-height: 30px;
        font-size: 14px;
        transition: 0.5s;
        &:hover {
            color: darken(#fff, 20%);
            border: 2px solid darken(#fff, 20%);
        }
    }
}
.navs {
    background: #fff;
    height: 50px;
    border-bottom: 1px solid #ccc;
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
.empty {
    .title {
        width: 100%;
        height: 160px;
        background: #edf1f7;
        color: #2d2d2d;
        text-align: center;
        h4 {
            padding-top: 40px;
            font-size: 26px;
            font-weight: bold;
        }
        h5 {
            margin-top: 20px;
            font-size: 18px;
        }
    }
    .shop {
        h5 {
            width: 100%;
            height: 120px;
            text-align: center;
            padding-top: 55px;
            font-size: 22px;
        }
        .commend {
            width: 100%;
            display: flex;
            justify-content: center;
            .women,
            .men {
                text-align: center;
                margin: 15px;
                a {
                    text-decoration: none;
                    color: #2d2d2d;
                }
                img {
                    width: 300px;
                    height: 404px;
                }
                h4 {
                    font-size: 20px;
                    font-weight: bold;
                    margin-top: 10px;
                }
            }
        }
    }
}
.search-result {
    .title {
        width: 100%;
        height: 90px;
        background: #f8f8f8;
        color: #2d2d2d;
        text-align: center;
        h5 {
            font-size: 16px;
            padding-top: 15px;
        }
        h3 {
            font-size: 26px;
            font-weight: bold;
        }
    }
    .num {
        width: 100%;
        height: 45px;
        text-align: center;
        padding-top: 25px;
        h5 {
            font-size: 15px;
        }
    }
    .product {
        width: 67%;
        display: flex;
        flex-wrap: wrap;
        margin: auto;
        .item {
            padding: 10px;
            margin-top: 25px;
            a {
                text-decoration: none;
            }
            img {
                width: 300px;
                height: 404px;
            }
            .item-txt {
                width: 300px;
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
        .loading {
            position: relative;
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
                border: none;
                outline: none;
            }
        }
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
</style>
