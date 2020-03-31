<template>
    <div class="body">
        <div class="top">
            <div class="info">
                <i class="fas fa-long-arrow-alt-left" @click="backPage">
                    返回 |</i
                >
                <h4>會員 # {{ uid }}</h4>
                <i class="fas fa-angle-double-right"></i>
                <h5>加入時間：{{ info.addDate }}</h5>
            </div>
            <div class="online">
                <h5 v-if="info.token === ''" >
                    會員未上線<div :class="{ grey: true }"></div>
                </h5>
                <h5 v-if="info.token !== ''" >
                    會員上線中<div :class="{ green: true }"></div>
                </h5>
            </div>
        </div>
        <div class="main-member">
            <div class="member-info">
                <div class="box">
                    <div v-if="info.sex === 'M'" class="man"></div>
                    <div v-if="info.sex === 'F'" class="woman"></div>
                    <h5>{{ info.name }}</h5>
                    <div class="member-data">
                        <h5>會員名稱: {{ info.name }}</h5>
                        <h5>信箱: {{ info.email }}</h5>
                        <h5>生日: {{ moment(info.birthday).calendar() }}</h5>
                        <h5 v-if="info.sex === 'M'">性別: 男性</h5>
                        <h5 v-if="info.sex === 'F'">性別: 女性</h5>
                        <h5>加入時間: {{ moment(info.addDate).fromNow() }}</h5>
                    </div>
                </div>
                <div class="member-status">
                    <h4><i class="fas fa-info-circle"></i> 會員狀態</h4>
                    <div class="status">
                        <h5 v-if="info.level === 0">等級： 普通會員</h5>
                        <h5>
                            上次上線： {{ moment(info.lastDate).fromNow() }}
                        </h5>
                        <h5>
                            狀態：
                            <el-switch
                                v-model="value1"
                                active-color="#13ce66"
                                inactive-color="#ff4949"
                                active-text="已凍結"
                                inactive-text="可使用"
                                @change="open"
                            >
                            </el-switch>
                        </h5>
                    </div>
                </div>
            </div>
            <div class="member-order">
                <div class="product">
                    <div class="product-top">
                        <h4>
                            <i class="fas fa-sort-amount-down"></i> 訂單列表
                        </h4>
                        <span>按箭頭向下以取得詳細資訊</span>
                        <i
                            class="fas fa-chevron-up"
                            :class="{ toggle: isTrue }"
                            @click="toggle"
                        ></i>
                    </div>
                    <table :class="{ show: isTrue }">
                        <thead>
                            <tr class="head">
                                <th scope="col">訂單編號</th>
                                <th scope="col">訂單狀態</th>
                                <th scope="col">成立時間</th>
                                <th scope="col">檢視訂單</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <tr v-for="(item, index) in order" :key="index">
                                <td>#{{ item.id }}</td>
                                <td v-if="item.status === 0">處理中</td>
                                <td v-if="item.status === 1">已出貨</td>
                                <td v-if="item.status === 2">完成</td>
                                <td v-if="item.status === 3">取消</td>
                                <td>{{ item.addDate }}</td>
                                <td class="operate-btn">
                                    <router-link
                                        :to="{
                                            name: 'Orderdetails',
                                            params: { oid: item.id }
                                        }"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </router-link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="order-total">
                        <h5>訂單總計: {{ total.all }}</h5>
                        <div class="total">
                            <h5>處理中: {{ total.handle }}</h5>
                            <h5>已出貨: {{ total.ship }}</h5>
                            <h5>完成: {{ total.done }}</h5>
                            <h5>取消: {{ total.cancel }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
var moment = require("moment");
moment.locale("zh-tw");
import axios from "axios";
export default {
    name: "Memberdetails",
    data() {
        return {
            moment: moment,
            isTrue: false,
            uid: this.$route.params.uid,
            order: [],
            info: [],
            value: "",
            subTotal: 0,
            group: [],
            cash: "尚未收到款項",
            value1: true,
            total: {
                all: 0,
                handle: 0,
                ship: 0,
                done: 0,
                cancel: 0
            }
        };
    },
    created() {
        this.getMemberdetails(this.uid);
    },
    methods: {
        open() {
            this.$confirm("更改此會員狀態, 是否繼續?", "提示", {
                confirmButtonText: "確定",
                cancelButtonText: "取消",
                type: "info"
            })
                .then(() => {
                    let status;
                    if (this.value1 === true) {
                        status = 0;
                    } else {
                        status = 1;
                    }
                    axios
                        .get(`/api/member/status/${this.uid}/${status}`)
                        .then(res => {
                            if (res.data.result === true) {
                                this.$message({
                                    type: "success",
                                    message: "更改會員狀態成功!"
                                });
                            }
                        })
                        .catch(err => {
                            console.log(err);
                        });
                })
                .catch(() => {
                    if (this.value1 === true) {
                        this.value1 = false;
                    } else {
                        this.value1 = true;
                    }
                    this.$message({
                        type: "warning",
                        message: "已取消動作！"
                    });
                });
        },
        toggle() {
            if (this.isTrue === false) {
                this.isTrue = true;
            } else {
                this.isTrue = false;
            }
        },
        getMemberdetails(id) {
            axios
                .get(`/api/member/detail/${id}`)
                .then(res => {
                    this.info = res.data.data;
                    if (this.info.status === 1) {
                        this.value1 = false;
                    }
                    this.order = res.data.order;
                    let i;
                    for (i = 0; i < this.order.length; i++) {
                        this.total.all = this.order.length;
                        if (this.order[i].status === 0) {
                            this.total.handle = this.total.handle + 1;
                        }
                        if (this.order[i].status === 1) {
                            this.total.ship = this.total.ship + 1;
                        }
                        if (this.order[i].status === 2) {
                            this.total.done = this.total.done + 1;
                        }
                        if (this.order[i].status === 3) {
                            this.total.cancel = this.total.cancel + 1;
                        }
                    }
                })
        },
        backPage() {
            this.$router.go(-1);
        }
    }
};
</script>

<style lang="scss" scoped>
$color: #2d2d2d;
.body {
    font-family: "Noto Serif TC", serif;
    font-weight: 400;
}
.top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    height: 85px;
    background: #eee;
    .info {
        display: flex;
        color: $color;
        .fa-long-arrow-alt-left{
            margin-left: 10px;
            margin-top: 8px;
            cursor: pointer;
        }
        h4 {
            margin-left: 10px;
        }
        .fa-angle-double-right {
            margin-top: 8px;
            margin-left: 15px;
        }
        h5 {
            margin-top: 7px;
            margin-left: 10px;
            font-size: 20px;
        }
    }
    .online {
        margin-right: 30px;
        h5{
            display: flex;
            align-items: center;
        }
        .grey{
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background: #666;
            margin-left: 10px;
        }
        .green{
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background: rgb(19, 146, 61);
            margin-left: 10px;
        }
    }
}
.main-member {
    display: flex;
    .toggle {
        transform: scaley(-1);
    }
    .show {
        display: none;
    }
    .member-info {
        width: 50%;
        .box {
            margin: auto;
            margin-top: 30px;
            padding: 15px;
            width: 70%;
            background: linear-gradient(5deg, #ffefba, #ffffff);
            border-radius: 10px;
            color: #2d2d2d;
            h5 {
                text-align: center;
            }
            .member-data {
                width: 60%;
                margin: auto;
                padding-left: 30px;
                margin-top: 20px;
                h5 {
                    font-size: 22px;
                    text-align: left;
                }
            }
            .man {
                width: 90px;
                height: 90px;
                border-radius: 50%;
                background-image: url(../assets/image/jiazhen.jpg);
                background-repeat: no-repeat;
                background-size: cover;
                margin: auto;
            }
            .woman {
                width: 90px;
                height: 90px;
                border-radius: 50%;
                background-image: url(../assets/image/me.png);
                background-repeat: no-repeat;
                background-size: cover;
                margin: auto;
            }
        }
        .member-status {
            padding-top: 50px;
            width: 70%;
            margin: auto;
            color: #0f4c81;
            h4 {
                &::after {
                    content: "";
                    display: block;
                    width: 100%;
                    height: 1px;
                    background: #666;
                    margin-top: 15px;
                }
            }
            .status {
                h5 {
                    color: #2d2d2d;
                    font-size: 22px;
                }
            }
        }
    }
    .member-order {
        width: 50%;
        .product {
            margin-top: 30px;
            .product-top {
                display: flex;
                height: 50px;
                position: relative;
                width: 85%;
                h4 {
                    color: #0f4c81;
                }
                span {
                    font-size: 14px;
                    line-height: 50px;
                    margin-left: 5px;
                    color: #2d2d2d;
                }
                .fa-chevron-up {
                    position: absolute;
                    font-size: 30px;
                    color: #666;
                    right: 0;
                    top: 10px;
                    padding-left: 10px;
                    border-left: 2.2px solid #666;
                    cursor: pointer;
                }
            }
            table {
                margin-top: 20px;
                width: 85%;
                .head {
                    height: 60px;
                    background: rgb(37, 59, 109);
                    color: #fff;
                    th {
                        padding-top: 10px;
                        padding-left: 15px;
                    }
                }
                .tbody {
                    tr {
                        height: 50px;
                        &:nth-child(even) {
                            background: #ffefba;
                        }
                        td {
                            &:first-child {
                                text-align: left;
                            }
                            text-align: center;
                        }
                    }
                    .operate-btn {
                        a {
                            color: #2d2d2d;
                            &:hover {
                                color: lighten(#2d2d2d, 20%);
                            }
                        }
                    }
                }
            }
            .price {
                display: flex;
                margin-top: 10px;
                width: 85%;
                justify-content: space-between;
            }
        }
        .order-total {
            margin-top: 30px;
            padding: 12px 0 12px 20px;
            width: 85%;
            color: #2d2d2d;
            border: 1px solid #666;
            border-radius: 20px;
            margin-bottom: 30px;
            .total {
                h5 {
                    font-size: 20px;
                    & + h5 {
                        margin-left: 35px;
                    }
                }
                display: flex;
            }
        }
    }
}
</style>
