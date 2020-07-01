<template lang="pug">
.wrap
  navbar
  .banner-up
    router-link(to='/women')
      .shop-link
        | WOMEN
    h5 UP TO 30% OFF BETWEEN-SEASON STYLES
    router-link(to='/men')
      .shop-link
        | MEN
  .banner
    .banner-top
      router-link(to='/women')
        .solgan1 GET 20% OFF*
        .solgan2 (HELLO, SAVED ITEMS)
        .solgan3 With code: AMAZING20
    .banner-bottom
      | *Limited time only. Selected styles marked down on site
  .container
    .ad
      .title The Y2K trend
      router-link(to='/women')
        .shop-link
          | shop now
    .row.mt-5
      .col-6
        img(src='../assets/image/1.jpg' alt='')
        h4 NEW-SEASON STYLES
        h5 Looks you haven&apos;t met yet
        router-link(to='/men')
          .shop-link
            | SHOP NOW
      .col-6
        img(src='../assets/image/2.jpg' alt='')
        h4 VARSITY VIBES
        h5 Campus it up
        router-link(to='/men')
          .shop-link
            | SHOP THE BRAND
      .col-6
        img(src='../assets/image/3.jpg' alt='')
        h4 FRESH CO-ORDS
        h5 What a match!
        router-link(to='/men')
          .shop-link
            | SHOP NOW
      .col-6
        img(src='../assets/image/4.jpg' alt='')
        h4 NEW COLLUSION
        h5 Oversized, graphic goodness
        router-link(to='/women')
          .shop-link
            | SHOP THE BRAND
  .block
    el-carousel(trigger='click' height='580px')
      el-carousel-item(v-for='item in 4' :key='item')
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
          |  | Change
    .foot-bot
      h5 &copy; 2020
      h5 Privacy &amp; Cookies | Ts&amp;Cs | Accessibility

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
.banner-up {
    display: flex;
    height: 50px;
    background: #ff9173;
    align-items: center;
    justify-content: space-around;
    font-family: "Sriracha";
    margin-bottom: 2px;
    // position: relative;
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
