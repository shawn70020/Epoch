<template>
    <div class="body">
        <div class="title">
            <h4>EPOCH</h4>
        </div>
        <div class="wrapper">
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
            </div>
            <div class="right">
                <div class="top">
                    <h3>Order DETAILS</h3>
                    <h5>Thanks for the order! Check out the details below.</h5>
                </div>
                <div class="step">
                    <div class="title">
                        <i class="fas fa-long-arrow-alt-left">Back</i>
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
                    <h5>Receiver： {{ info.name }}</h5>
                    <h5>Mobile :{{ info.phone }}</h5>
                    <h5>Address :{{ info.address }}</h5>
                    <h5 v-if="info.note">Order Note: {{ info.note }}</h5>
                    <h5 v-if="!info.note">Order Note: Nothing Here</h5>
                </div>
                <div class="info">
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
                            <h5>{{ item.name }}</h5>
                            <h5>X{{ num[index].num }}</h5>
                            <h5>${{ item.price }}</h5>
                        </div>
                    </div>
                    <div class="total">
                        <h5 v-if="order.delivery === 'S'">DELIVERY: $100</h5>
                        <h5 v-if="order.delivery === 'E'">DELIVERY: $300</h5>
                        <h5>TOTAL : ${{ order.total }}</h5>
                        <h5>PAYMENT : {{ info.payment }}</h5>
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
            axios.get(`/api/myorder/detail/${id}`).then(res => {
                if (res.data.result === true) {
                    this.order = res.data.data;
                    this.info = res.data.info;
                    this.num = res.data.num;
                    this.item = res.data.item;
                } else {
                    this.isEmpty = false;
                }
            });
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
}
.wrapper {
    width: 55%;
    height: 100vh;
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
        .step {
            margin-top: 20px;
            width: 100%;
            height: 260px;
            background: #fff;
            .title {
                width: 90%;
                padding-top: 30px;
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
            }
        }
        .address {
            width: 100%;
            height: 150px;
            background: #fff;
            margin-top: 20px;
            padding-left: 30px;
            padding-top: 10px;
            h5 {
                font-size: 20px;
            }
        }
        .info{
            margin-top: 20px;
            width: 100%;
            height: 400px;
            background: #fff;
            .detail{
                .item{
                    display: flex;
                    justify-content: space-around;
                    padding-top: 15px;
                    img {
                            width: 90px;
                            height: 120px;
                            margin-left: 15px;
                        }
                        h5{
                            font-size: 20px;
                        }
                }
            }
            .total{
                text-align: right;
                h5{
                    font-size: 20px;
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
    margin-top: 30px;
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
