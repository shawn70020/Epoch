<template>
    <div>
        <div class="wrap">
            <div class="side-bar">
                <div class="top">
                    <router-link to="/">
                        <h5>EPOCH</h5>
                    </router-link>
                    <div class="head"></div>
                </div>
                <div class="side-nav">
                    <h5>Levi</h5>
                    <h5>管理員</h5>
                    <div class="side-item">
                        <router-link to="/admin/dashboard">
                            <div class="item">
                                <i class="fas fa-cog"></i>總覽
                            </div>
                        </router-link>
                        <router-link to="/admin/products">
                            <div class="item">
                                <i class="fas fa-box-open"></i>商品
                            </div>
                        </router-link>
                        <router-link to="/admin/orders">
                            <div class="item">
                                <i class="far fa-list-alt"></i>訂單
                            </div>
                        </router-link>
                        <router-link to="/admin/coupon">
                            <div class="item">
                                <i class="fas fa-ticket-alt"></i>優惠券
                            </div>
                        </router-link>
                        <router-link to="/admin/member">
                            <div class="item">
                                <i class="fas fa-users"></i>會員
                            </div>
                        </router-link>
                        <div class="item pointer" @click="signout">
                            <i class="fas fa-sign-out-alt"></i>登出
                        </div>
                    </div>
                </div>
            </div>
            <router-view class="main"></router-view>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "Admin",
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
    }
};
</script>

<style lang="scss" scoped>
.wrap {
    display: flex;
    .fa-sign-out-alt {
        transform: scalex(-1);
    }
    .pointer {
        cursor: pointer;
    }
    .side-bar {
        width: 17%;
        height: 100vh;
        background: #333;
        .top {
            width: 100%;
            height: 15%;
            background: darken(#333, 7%);
            color: #fff;
            text-align: center;
            a {
                color: #fff;
                text-decoration: none;
            }
            h5 {
                font-size: 30px;
                padding-top: 30px;
                margin: auto;
                font-family: "IM Fell Great Primer SC";
            }
            .head {
                width: 90px;
                height: 90px;
                border-radius: 50%;
                background-image: url(../assets/image/levi.jpg);
                background-repeat: no-repeat;
                background-size: cover;
                margin: auto;
                position: relative;
                top: 30px;
            }
        }
        .side-nav {
            color: #fff;
            margin-top: 50px;
            h5 {
                text-align: center;
                &:last-child {
                    font-size: 18px;
                }
            }
            .side-item {
                margin-top: 40px;
                a {
                    color: #fff;
                    text-decoration: none;
                }
                .item {
                    height: 55px;
                    // margin-bottom: 10px;
                    padding-left: 20px;
                    border-bottom: 1px solid darken(#eee, 30%);
                    line-height: 50px;
                    position: relative;
                    &:hover {
                        background: #2d2d2d;
                    }
                    &::after {
                        content: ">";
                        position: absolute;
                        right: 20px;
                    }
                    .fas,
                    .far {
                        margin-right: 15px;
                    }
                }
            }
        }
    }
    .main {
        width: calc(100vw - 17%);
        height: 100vh;
        overflow-x: hidden;
    }
}
</style>
