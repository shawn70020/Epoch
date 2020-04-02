<template>
    <div class="body">
        <div class="title">
            <router-link to="/">
                <h4>EPOCH</h4>
            </router-link>
        </div>
        <div class="wrapper">
            <div class="left-nav">
                <div class="user">
                    <div class="circle">
                        <h5>{{ spiltName }}</h5>
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
                    <i class="fas fa-list-alt"></i>
                    <h3>MY ORDERS</h3>
                </div>
                <div class="display">
                    <h5>Displaying {{ order.length }} orders</h5>
                </div>
                <div class="order">
                    <div
                        class="order-list"
                        v-for="(item, index) in order"
                        :key="item.id"
                    >
                        <div class="title">
                            <div class="label">
                                <h5 v-if="item.shipDate !== null">
                                    WE'VE SENT IT!
                                </h5>
                                <h5 v-if="item.shipDate === null">
                                    WE'RE WORKING ON IT!
                                </h5>
                                <h5>ORDER NO.</h5>
                                <h5>SHIPPED DATE.</h5>
                            </div>
                            <div class="input">
                                <h5 v-if="item.shipDate !== null">
                                    {{
                                        moment(item.shipDate)
                                            .add(3, "days")
                                            .calendar()
                                    }}
                                </h5>
                                <h5 v-if="item.shipDate === null">
                                    Thanks for orders
                                </h5>
                                <h5>{{ item.id }}</h5>
                                <h5 v-if="item.shipDate !== null">
                                    {{ moment(item.shipDate).calendar() }}
                                </h5>
                                <h5 v-if="item.shipDate === null">
                                    {{
                                        moment()
                                            .add(1, "days")
                                            .calendar()
                                    }}
                                </h5>
                            </div>
                        </div>
                        <div class="bottom">
                            <div class="image-wrap">
                                <div
                                    class="image"
                                    v-for="product in image[index]"
                                    :key="product.id"
                                >
                                    <img
                                        :src="
                                            'data:image/png;base64,' +
                                                product.image
                                        "
                                        class="img-fluid"
                                    />
                                </div>
                            </div>
                            <div class="btn-order">
                                <router-link
                                    :to="{
                                        name: 'Myorderdetail',
                                        params: { oid: item.id }
                                    }"
                                    ><button>VIEW ORDER</button></router-link
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page" v-if="order.length !== 0">
                    <h5>You've viewed {{ nowNum }} of {{ allNum }} Orders</h5>
                    <div class="loading">
                        <loading
                            loader="dots"
                            :active.sync="isLoading"
                            :is-full-page="false"
                            :opacity="1"
                            background-color="#eee"
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
                <div class="empty" :class="{ show: isEmpty }">
                    <i class="far fa-hand-point-down"></i>
                    <h4>You currently have no orders</h4>
                    <h5>Best get shopping EPOCH pronto…</h5>
                    <router-link to="/">
                        <button class="btn-shopping">START SHOPPING</button>
                    </router-link>
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
    name: "Myorder",

    data() {
        return {
            isLoading: false,
            moment: moment,
            uid: this.$store.state.info.id,
            userName: this.$store.state.info.name,
            order: [],
            image: [],
            isEmpty: true,
            spiltName: "",
            loadBtn: "block",
            nowNum: "",
            allNum: "",
            bar: "10%",
            page: 2
        };
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
                this.spiltName = aInfo.name.split("")[0].toUpperCase();
                this.uid = aInfo.id;
                this.getMyOrders(this.uid);
            },
            immediate: true
        }
    },
    methods: {
        getMyOrders(id) {
            axios.get(`/api/user/myorder/${id}`).then(res => {
                if (res.data.result === true) {
                    this.order = res.data.data;
                    this.image = res.data.image;
                    this.nowNum = res.data.data.length;
                    this.allNum = res.data.total;
                } else {
                    this.isEmpty = false;
                }
            });
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
        },
        changePage() {
            this.isLoading = true;
            let uid = this.$store.state.info.id;
            setTimeout(() => {
                axios
                    .get(`/api/myorder/${uid}/page=${this.page}`)
                    .then(res => {
                        let newData = res.data.data;
                        let newImage = res.data.image;
                        for (let i = 0; i < newData.length; i++) {
                            this.order.push(newData[i]);
                            this.image.push(newImage[i]);
                        }
                        this.nowNum = this.order.length;
                        this.page = this.page + 1;
                        let barWidth;
                        barWidth = (
                            this.order.length *
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
                    .catch(err => {
                        console.log(err);
                    });
            }, 1000);
        }
    }
};
</script>
<style lang="scss" scoped>
.body {
    background: #eee;
}
.title {
    width: 55%;
    height: 110px;
    margin: auto;
    text-align: center;

    h4 {
        line-height: 110px;
        margin-right: 130px;
        font-size: 48px;
        font-family: "IM Fell Great Primer SC";
        font-weight: 700;
    }
    a {
        color: #2d2d2d;
        text-decoration: none;
    }
}
.fa-sign-out-alt {
    transform: scalex(-1);
}
.pointer {
    cursor: pointer;
}
.wrapper {
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
            .fa-list-alt {
                padding: 20px;
                font-size: 28px;
            }
            h3 {
                padding-left: 20px;
                font-weight: bold;
            }
        }
        .show {
            display: none;
        }
        .page {
            margin: auto;
            background: #eee;
            text-align: center;
            margin-top: 25px;
            font-family: "Cormorant SC";
            h5 {
                font-size: 18px;
                color: #666666;
            }
            .loading {
                position: relative;
                margin-top: 20px;
                margin-bottom: 30px;
                .load {
                    margin: auto;
                    width: 300px;
                    height: 55px;
                    color: #fff;
                    line-height: 55px;
                    font-size: 18px;
                    font-weight: bold;
                    background: #0f4c81;
                    border: none;
                    outline: none;
                }
            }
        }
    }
    .empty {
        background: #fff;
        width: 100%;
        height: 300px;
        margin-top: 15px;
        text-align: center;
        .fa-hand-point-down {
            margin: 40px 0;
            font-size: 40px;
        }
        h4 {
            font-weight: bold;
        }
        h5 {
            margin: 15px 0 25px 0;
            font-size: 20px;
        }
        .btn-shopping {
            width: 330px;
            height: 50px;
            padding: 10px 28px;
            background: #2d2d2d;
            font-weight: bold;
            color: #fff;
            margin-bottom: 5px;
        }
    }
    .display {
        width: 100%;
        height: 70px;
        color: #999;
        h5 {
            font-size: 20px;
            line-height: 70px;
            margin-left: 30px;
        }
    }
    .order {
        width: 100%;
        background: #eee;
        .order-list {
            width: 100%;
            height: 300px;
            background: #fff;
            margin-bottom: 20px;
            .title {
                width: 100%;
                padding-top: 30px;
                &::after {
                    content: "";
                    display: block;
                    width: 88%;
                    height: 1px;
                    background: #999;
                    margin: auto;
                    margin-top: 15px;
                }
                h5 {
                    font-size: 18px;
                }
                .label {
                    width: 100%;
                    display: flex;
                    justify-content: space-around;
                }
                .input {
                    width: 100%;
                    display: flex;
                    justify-content: space-around;
                }
            }
            .bottom {
                width: 100%;
                display: flex;
                margin-top: 30px;
                .image-wrap {
                    display: flex;
                    width: 50%;
                    padding-left: 20px;
                    .image {
                        img {
                            width: 90px;
                            height: 120px;
                            margin-left: 15px;
                        }
                    }
                }
                .btn-order {
                    padding-top: 30px;
                    width: 45%;
                    padding-right: 50px;
                    button {
                        width: 270px;
                        height: 50px;
                        background: transparent;
                        color: #2d2d2d;
                        padding: 10px;
                        margin-bottom: 10px;
                        font-weight: bold;
                    }
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
