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
        <div class="navs">
            <ol class="bread">
                <li><router-link to="/">Home</router-link></li>
                <li><router-link to="/men">Men</router-link></li>
                <li><a href="#">New In</a></li>
            </ol>
        </div>
        <div class="container">
            <div class="introduce">
                <h3>Men's New in</h3>
                <p>
                    Looking for something new? Discover emerging trends, the
                    latest clothing for men and the freshest new fits with our
                    ASOS New In page. From sharp office shirts and suits to see
                    you right through to 5PM, to the shorts, tees and vests
                    that’ll keep you looking fresh– you can find the look here
                    as soon as it lands. What’s more, our men’s new clothing
                    selection includes all those accessory touches that make the
                    difference, from laidback caps and timeless
                    <span id="more" :style="{ display: show }">
                        >shades to boardroom-ready watches and belts. Expect
                        fresh drops from sportswear authorities Nike and adidas
                        Originals. If you’re after a style change up, you’ll
                        find the best in men’s new clothing, shoes and
                        accessories courtesy of our very own ASOS Design. Men’s
                        denim doesn’t get much better than the likes of Cheap
                        Monday, while brands like BOSS combine sophisticated
                        prints with casual fits for a weekend-ready look.
                    </span>
                </p>
                <div class="view-btn">
                    <button
                        type="button"
                        class="btn"
                        id="myBtn"
                        @click="showMore"
                    >
                        View more
                    </button>
                </div>
            </div>
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
                    <div class="heart"><i class="far fa-heart"></i></div>
                    <div class="item-txt">
                        <h5>{{ item.name }}</h5>
                        <h4>NT {{ item.price | currency }}</h4>
                    </div>
                </router-link>
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
            show: "none",
            products: []
        };
    },
    components: {
        Navbar
    },
    created() {
        this.getProducts();
    },
    methods: {
        showMore() {
            let btnTxt = document.getElementById("myBtn");
            let btn = document.querySelector(".view-btn");
            if (this.show == "none") {
                this.show = "block";
                btnTxt.innerHTML = "View Less";
                btn.style.position = "static";
            } else {
                this.show = "none";
                btnTxt.innerHTML = "View More";
                btn.style.position = "relative";
            }
        },
        getProducts() {
            axios
                .get("/api/products/men")
                .then(res => {
                    this.products = res.data.data;
                    this.products = this.products.filter(e => e.sex === "M");
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
.container {
    .introduce {
        text-align: center;
        margin-top: 30px;
        font-family: "Sriracha";
        h3 {
            font-size: 28px;
        }
        p {
            font-size: 16px;
            color: lighten(#000000, 35%);
        }
        .view-btn {
            position: relative;
            top: -32px;
            width: 100%;
            height: 70px;
            background: #fff;
            box-shadow: 0 -5px 10px 0 #fff;
            .btn {
                font-family: "Sriracha";
                padding: 0;
                border: none;
                background: none;
                outline: none;
            }
        }
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
            bottom: 100px;
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
    }
}
</style>
