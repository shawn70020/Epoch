<template lang="pug">
div
  navbar
  .banner
    router-link(to='/women')
      .shop-link
        | WOMEN
    h5 UP TO 30% OFF BETWEEN-SEASON STYLES
    router-link(to='/men')
      .shop-link
        | MEN
  .wrap-loading
    loading(loader='dots' :active.sync='wrapLoading' :is-full-page='false' :opacity='1')
    .navs
      ol.bread
        li
          router-link(to='/') Home
        li
          router-link(to='/men') Men
        li
          a(href='#') New In
    .container
      .introduce
        h3 Men&apos;s New in
        p
          | Looking for something new? Discover emerging trends, the
          | latest clothing for men and the freshest new fits with
          | our ASOS New In page. From sharp office shirts and suits
          | to see you right through to 5PM, to the shorts, tees and
          | vests that&rsquo;ll keep you looking fresh&ndash; you can find the
          | look here as soon as it lands. What&rsquo;s more, our men&rsquo;s
          | new clothing selection includes all those accessory
          | touches that make the difference, from laidback caps and
          | timeless
          span#more(:style='{ display: show }')
            | &gt;shades to boardroom-ready watches and belts. Expect
            | fresh drops from sportswear authorities Nike and
            | adidas Originals. If you&rsquo;re after a style change up,
            | you&rsquo;ll find the best in men&rsquo;s new clothing, shoes
            | and accessories courtesy of our very own ASOS
            | Design. Men&rsquo;s denim doesn&rsquo;t get much better than the
            | likes of Cheap Monday, while brands like BOSS
            | combine sophisticated prints with casual fits for a
            | weekend-ready look.
        .view-btn
          button#myBtn.btn(type='button' @click='showMore')
            | View more
    .product
      .item(v-for='item in products' :key='item.id')
        router-link(:to="{\
        name: 'Item',\
        params: { pid: item.id }\
        }")
          img.img-fluid(:src="'data:image/png;base64,' + item.image")
          .item-txt
            h5 {{ item.name }}
            h4 NT {{ item.price | currency }}
    .page
      h5 You&apos;ve viewed {{ nowNum }} of {{ allNum }} products
      .progress(style='height: 2.5px;')
        .progress-bar(role='progressbar' :style='{ width: bar }' aria-valuenow='20' aria-valuemin='0' aria-valuemax='100')
      .loading
        loading(loader='bars' :active.sync='isLoading' :is-full-page='false' :opacity='1')
        button.load(:style='{ display: loadBtn }' @click='changePage')
          | LOAD MORE
    .social
      ul
        li
          .icon.fb
            i.fab.fa-facebook-square
        li
          .icon.ig
            i.fab.fa-instagram
        li
          .icon.tw
            i.fab.fa-twitter
        li |
        li
          .icon.yt
            i.fab.fa-youtube
        li
          .icon.sc
            i.fab.fa-snapchat
        li
          .icon.pi
            i.fab.fa-pinterest
    .foot
      .foot-top
        .item
          h4 HELP &amp; INFORMATION
          ul
            li
              a(href='#') Help
            li
              a(href='#') Deliverey &amp; Returns
            li
              a(href='#') Track Order
        .item
          h4 ABOUT VUESTORE
          ul
            li
              a(href='#') About Us
            li
              a(href='#') Careers at VueStore
            li
              a(href='#') Investors Site
        .item
          h4 MORE FROM VUESTORE
          ul
            li
              a(href='#') Mobile and Apps
            li
              a(href='#') VueStore Marketplcae
            li
              a(href='#') Gift vouchers
        .item
          h4 SHOPPING FROM:
          h5
            | You&apos;re in 
            i.fas.fa-globe-americas
            |  |
            |                             Change
      .foot-bot
        h5 &copy; 2020
        h5 Privacy &amp; Cookies | Ts&amp;Cs | Accessibility

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
            loadBtn: "block"
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
            this.wrapLoading = true;
            axios
                .get("/api/products/men")
                .then(res => {
                    this.products = res.data.data;
                    this.allNum = res.data.total;
                    this.nowNum = res.data.data.length;
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
        changePage() {
            this.isLoading = true;
            axios
                .get(`/api/products/men/page=${this.page}`)
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
$color: #1010c4;
.wrap-loading {
    position: relative;
}
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
