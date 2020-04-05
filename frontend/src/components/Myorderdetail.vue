<template>
    <div>
        <div class="body">
            <div class="title">
                <router-link to="/">
                    <h4>EPOCH</h4>
                </router-link>
            </div>
            <div class="wrappere">
                <div class="left-nav">
                    <div class="user">
                        <div class="circle">
                            <h5>{{ splitName }}</h5>
                        </div>
                        <div class="name">
                            <h5>Hi,</h5>
                            <h5>{{ userName }}</h5>
                        </div>
                    </div>
                    <router-link to="/account">
                        <div class="item">
                            <i class="far fa-user"></i>
                            <h5>Account overview</h5>
                        </div>
                    </router-link>
                    <router-link to="/mydetails">
                        <div class="item">
                            <i class="far fa-address-card"></i>
                            <h5>My details</h5>
                        </div>
                    </router-link>
                    <router-link to="/mypassword">
                        <div class="item">
                            <i class="fas fa-lock"></i>
                            <h5>Change password</h5>
                        </div>
                    </router-link>
                    <router-link to="/myorder">
                        <div class="item line">
                            <i class="fas fa-list-alt"></i>
                            <h5>My orders</h5>
                        </div>
                    </router-link>
                    <div class="item">
                        <i class="fas fa-sign-out-alt"></i>
                        <h5 @click="signout" class="pointer">Sign out</h5>
                    </div>
                </div>
                <div class="right">
                    <div class="top">
                        <h3>Order Details</h3>
                        <h5>
                            Thanks for the order! Check out the details below.
                        </h5>
                    </div>
                    <div class="step">
                        <div class="title">
                            <i
                                class="fas fa-long-arrow-alt-left"
                                @click="backPage"
                            >
                                Back</i
                            >
                            <h5>Order No.{{ oid }}</h5>
                        </div>
                        <el-steps :active="order.status + 1" align-center>
                            <el-step
                                title="Order Established"
                                :description="order.addDate"
                            ></el-step>
                            <el-step
                                title="Order Shipped"
                                :description="order.shipDate"
                            ></el-step>
                            <el-step
                                title="Order Done"
                                :description="order.doneDate"
                            ></el-step>
                        </el-steps>
                    </div>
                    <div class="address">
                        <h4>Bill Information</h4>
                        <h5>Receiver： {{ info.name }}</h5>
                        <h5>Mobile :{{ info.phone }}</h5>
                        <h5>Address :{{ info.address }}</h5>
                        <h5 v-if="info.note">Order Note: {{ info.note }}</h5>
                        <h5 v-if="!info.note">Order Note: None</h5>
                    </div>
                    <div class="info">
                        <h3>Product Detail</h3>
                        <div class="detail">
                            <div
                                class="item"
                                v-for="(item, index) in item"
                                :key="index"
                            >
                                <img
                                    :src="'data:image/png;base64,' + item.image"
                                    class="img-fluid"
                                />
                                <div class="num">
                                    <h5>{{ item.name }}</h5>
                                    <h5>X{{ num[index].num }}</h5>
                                </div>
                                <h4>{{ item.price | currency }}</h4>
                            </div>
                        </div>
                        <div class="total">
                            <h5>
                                <i class="far fa-calendar-check"></i> PAYMENT :
                                {{ info.payment }}
                            </h5>
                            <h5 v-if="order.delivery === 'S'">
                                <i class="fas fa-people-carry"></i> DELIVERY:
                                $100
                            </h5>
                            <h5 v-if="order.delivery === 'E'">
                                <i class="fas fa-people-carry"></i> DELIVERY:
                                $300
                            </h5>
                            <h5>
                                <i class="fas fa-wallet"></i> TOTAL :
                                {{ order.total | currency }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
            <h5>EPOCH Homepage</h5>
            <h5>Terms & Conditions</h5>
            <h5>Privacy Policy</h5>
            <h5>&copy; Epoch 2020</h5>
        </div>
    </div>
</template>
<script>
import axios from "axios";
var moment = require("moment");
moment.locale("zh-tw");
export default {
    name: "Myorderdetail",

    data() {
        return {
            moment: moment,
            oid: this.$route.params.oid,
            uid: this.$store.state.info.id,
            userName: this.$store.state.info.name,
            order: [],
            info: [],
            num: [],
            item: [],
            isEmpty: true
        };
    },
    computed: {
        splitName: function() {
            return this.userName.split("")[0].toUpperCase();
        }
    },
    created() {
        this.getOrderdetail(this.oid);
    },
    methods: {
        getOrderdetail(id) {
            axios
                .get(`/api/myorder/detail/${id}`)
                .then(res => {
                    if (res.data.result === true) {
                        this.order = res.data.data;
                        this.info = res.data.info;
                        this.num = res.data.num;
                        this.item = res.data.item;
                    } else {
                        this.isEmpty = false;
                    }
                })
                .catch(() => {
                    this.$notify.error({
                        title: "Something Goes Wrong ...",
                        message: "Please refresh your page again",
                        duration: 6800
                    });
                });
        },
        backPage() {
            this.$router.go(-1);
        },
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
.body {
    background: #eee;
    width: 100%;
}
.title {
    width: 55%;
    height: 110px;
    margin: auto;
    text-align: center;
    a {
        color: #2d2d2d;
        text-decoration: none;
    }
    h4 {
        line-height: 110px;
        margin-right: 130px;
        font-size: 48px;
        font-family: "IM Fell Great Primer SC";
        font-weight: 700;
    }
}
.fa-sign-out-alt {
    transform: scalex(-1);
}
.pointer {
    cursor: pointer;
}
.wrappere {
    width: 55%;
    margin: auto;
    display: flex;
    justify-content: center;
    .left-nav {
        .user {
            width: 300px;
            height: 170px;
            background: #fff;
            display: flex;
            align-items: center;
            .circle {
                width: 90px;
                height: 90px;
                background: #0f4c81;
                border-radius: 50%;
                position: relative;
                left: -15px;
                text-align: center;
                h5 {
                    line-height: 90px;
                    color: #fff;
                    font-size: 36px;
                    font-weight: bold;
                }
            }
            .name {
                h5 {
                    &:first-child {
                        font-family: "IM Fell Great Primer SC";
                    }
                    &:last-child {
                        font-weight: bold;
                    }
                }
            }
        }
        .item {
            display: flex;
            width: 300px;
            height: 62px;
            background: #fff;
            margin-top: 5px;
            align-items: center;
            color: #2d2d2d;
            .far,
            .fas {
                padding: 20px;
            }
            h5 {
                padding-top: 10px;
                font-size: 22px;
            }
        }
    }
    .right {
        width: 640px;
        margin-left: 20px;
        .top {
            width: 100%;
            height: 140px;
            background: #fff;
            padding-top: 20px;
            .fa-list-alt {
                padding: 20px;
                font-size: 28px;
            }
            h3 {
                padding-left: 20px;
                font-weight: bold;
            }
            h5 {
                padding-left: 20px;
            }
        }
        .step {
            margin-top: 20px;
            width: 100%;
            height: 260px;
            background: #fff;
            .title {
                width: 92%;
                padding-top: 20px;
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                .fa-long-arrow-alt-left {
                    cursor: pointer;
                }
            }
        }
        .address {
            width: 100%;
            background: #fff;
            margin-top: 20px;
            padding: 20px;
            h4 {
                font-size: 28px;
                &::after {
                    content: "";
                    width: 100%;
                    height: 1px;
                    background: #999;
                    display: block;
                    margin: auto;
                    margin-top: 20px;
                }
            }
            h5 {
                font-size: 20px;
                color: lighten(#2d2d2d, 5%);
            }
        }
        .info {
            margin-top: 20px;
            width: 100%;
            background: #fff;
            margin-bottom: 30px;
            h3 {
                font-size: 28px;
                padding: 15px;
                &::after {
                    content: "";
                    width: 100%;
                    height: 1px;
                    background: #999;
                    display: block;
                    margin: auto;
                    margin-top: 20px;
                }
            }
            .detail {
                .item {
                    display: flex;
                    padding-top: 10px;
                    img {
                        width: 90px;
                        height: 120px;
                        margin-left: 45px;
                    }
                    .num {
                        margin-left: 50px;
                        width: 300px;
                        overflow-x: scroll;
                    }
                    h4,
                    h5 {
                        font-size: 20px;
                    }
                    h4 {
                        margin-left: 30px;
                        margin-right: 30px;
                    }
                }
            }
            .total {
                margin-top: 10px;
                text-align: right;
                padding-right: 20px;
                padding-bottom: 10px;
                color: #2d2d2d;
                h5 {
                    font-size: 22px;
                }
            }
        }
    }
}
.footer {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 62px;
    background: #fff;
    h5 {
        font-size: 22px;
        margin-right: 2rem;
        &:last-child {
            margin-left: 5rem;
        }
    }
}
.line {
    border-left: 4px solid #0f4c81;
}
</style>
