<template>
    <div>
        <div class="top">
            <div class="info">
                <i class="fas fa-long-arrow-alt-left" @click="backPage">
                    返回 |</i
                >
                <h4>訂單 # {{ oid }}</h4>
                <i class="fas fa-angle-double-right"></i>
                <h5>成立時間：{{ info.addDate }}</h5>
            </div>
            <div class="btn-group">
                <button class="btn truck" @click="open(1)">
                    <i class="fas fa-truck-moving"></i>出貨
                </button>
                <button class="btn done" @click="open(2)">
                    <i class="fas fa-check"></i>完成
                </button>
                <button class="btn cancel" @click="open(3)">
                    <i class="fas fa-ban"></i>取消
                </button>
            </div>
        </div>
        <div class="main-wrap">
            <div class="order-detail">
                <div class="product">
                    <div class="product-top">
                        <h4>
                            <i class="fas fa-sort-amount-down"></i> 訂單明細
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
                                <th scope="col">購買商品品項</th>
                                <th scope="col">價格</th>
                                <th scope="col">數量</th>
                                <th scope="col">金額</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <tr v-for="(item, index) in products" :key="index">
                                <td>{{ item.name }}</td>
                                <td>{{ item.price }}</td>
                                <td>{{ item.num }}</td>
                                <td>{{ item.total }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="price">
                        <h5>小計</h5>
                        <h5>NT {{ subTotal | currency }}</h5>
                    </div>
                </div>
                <div class="other-fee">
                    <h4><i class="fas fa-th-list"></i> 清單</h4>
                    <table>
                        <thead>
                            <tr class="head">
                                <th scope="col" colspan="2">
                                    折扣明細及運費資訊
                                </th>
                                <th scope="col">折抵(百分比)</th>
                                <th scope="col">金額</th>
                            </tr>
                        </thead>
                        <tbody class="tbody">
                            <tr>
                                <td colspan="2" v-if="info.coupon">
                                    {{ info.coupon }}
                                </td>
                                <td colspan="2" v-if="!info.coupon">無使用</td>
                                <td v-if="info.discount">
                                    {{ info.discount }}
                                </td>
                                <td v-if="!info.discount">無折扣</td>
                                <td v-if="info.discount">
                                    -
                                    {{
                                        (subTotal * (1 - info.discount))
                                            | currency
                                    }}
                                </td>
                                <td v-if="!info.discount">
                                    - $0
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">折扣後(不含運)</td>
                                <td v-if="info.discount">
                                    {{ (subTotal * info.discount) | currency }}
                                </td>
                                <td v-if="!info.discount">
                                    {{ subTotal | currency }}
                                </td>
                            </tr>
                            <tr v-if="info.delivery === 'S'">
                                <td colspan="3">配送費用</td>
                                <td>$100</td>
                            </tr>
                            <tr v-if="info.delivery === 'E'">
                                <td colspan="3">配送費用</td>
                                <td>$300</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="price">
                        <h5>總金額</h5>
                        <h5 v-if="info.discount && info.delivery === 'S'">
                            NT {{ (subTotal * info.discount + 100) | currency }}
                        </h5>
                        <h5 v-if="info.discount && info.delivery === 'E'">
                            NT {{ (subTotal * info.discount + 300) | currency }}
                        </h5>
                        <h5 v-if="!info.discount && info.delivery === 'S'">
                            NT {{ (subTotal + 100) | currency }}
                        </h5>
                        <h5 v-if="!info.discount && info.delivery === 'E'">
                            NT {{ (subTotal + 300) | currency }}
                        </h5>
                    </div>
                </div>
                <div class="bill">
                    <h4><i class="fas fa-info-circle"></i> 帳單資訊</h4>
                    <div class="bill-info">
                        <h5><i class="fas fa-user"></i> {{ info.name }}</h5>
                        <h5>
                            <i class="fas fa-envelope"></i> {{ info.email }}
                        </h5>
                        <h5><i class="fas fa-phone"></i> {{ info.phone }}</h5>
                    </div>
                    <div class="bill-address">
                        <h5>收貨人地址:</h5>
                        <h5>{{ info.address }}</h5>
                    </div>
                </div>
            </div>
            <div class="payment-info">
                <div class="pay">
                    <h4><i class="fas fa-dollar-sign"></i> 貨款</h4>
                    <div class="pay-detail">
                        <div class="title">
                            <h5>付款方式</h5>
                            <h5>付款狀態</h5>
                        </div>
                        <div class="txt">
                            <h5 v-if="info.payment === 'Cash'">貨到付款</h5>
                            <h5 v-if="info.payment === 'Card'">信用卡</h5>
                            <h5 v-if="info.payment === 'Atm'">ATM轉帳</h5>
                            <h5>{{ cash }}</h5>
                        </div>
                    </div>
                    <div class="btn-pay">
                        <h5>如以確認收到款項，請按確認收款</h5>
                        <button @click="getMoney">確認收款</button>
                    </div>
                </div>
                <div class="delivery">
                    <h4><i class="fas fa-truck-moving"></i> 配送資訊</h4>
                    <div class="delivery-item">
                        <div class="title">
                            <h5>您尚須準備{{ ship.length }}項商品</h5>
                            <h5>選擇您欲出貨商品</h5>
                        </div>
                        <div
                            v-for="(item, index) in ship"
                            :key="index"
                            class="checkbox"
                        >
                            <input
                                type="checkbox"
                                id="vehicle1"
                                name="vehicle1"
                                v-model="group"
                                :value="item.pid"
                            />
                            <label for="vehicle1">{{ item.name }}</label
                            ><br />
                        </div>
                        <div class="btn-send">
                            <h5>請勾選可出貨商品，並按確認出貨</h5>
                            <button @click="confirmItem">確認出貨</button>
                        </div>
                    </div>
                </div>
                <div class="order-note">
                    <h4><i class="far fa-clipboard"></i> 訂單備註</h4>
                    <div class="note" v-if="info.note">
                        <p>
                            {{ info.note }}
                        </p>
                    </div>
                    <div class="note" v-if="!info.note">
                        <p>
                            訂單無備註
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Orderdetails",
    data() {
        return {
            showError: 0,
            isTrue: false,
            oid: this.$route.params.oid,
            details: [],
            info: [],
            products: [],
            value: "",
            subTotal: 0,
            group: [],
            cash: "尚未收到款項",
            ship: []
        };
    },
    created() {
        this.getOrderdetails(this.oid);
    },
    methods: {
        open(status) {
            this.$confirm("送出前請確認此狀態, 是否繼續?", "提示", {
                confirmButtonText: "確定",
                cancelButtonText: "取消",
                type: "info"
            })
                .then(() => {
                    axios
                        .get(`/api/orders/status/${this.oid}/${status}`)
                        .then(res => {
                            if (res.data.result === true) {
                                this.$message({
                                    type: "success",
                                    message: "更改狀態成功!"
                                });
                            }
                        })
                        .catch(() => {
                            this.$notify.error({
                                title: "Something Goes Wrong ...",
                                message: "Please refresh your page again",
                                duration: 6800
                            });
                        });
                })
                .catch(() => {
                    this.$message({
                        type: "warning",
                        message: "已取消動作！"
                    });
                });
        },
        confirmItem() {
            this.$confirm("送出前請確認此狀態, 是否繼續?", "提示", {
                confirmButtonText: "確定",
                cancelButtonText: "取消",
                type: "info"
            })
                .then(() => {
                    if (this.group.length !== 0) {
                        axios
                            .post(`/api/orders/${this.oid}/ship`, {
                                group: this.group
                            })
                            .then(() => {
                                let i;
                                let j;
                                for (i = 0; i < this.ship.length; i++) {
                                    for (j = 0; j < this.group.length; j++) {
                                        if (
                                            this.group[j] === this.ship[i].pid
                                        ) {
                                            this.ship.splice(i, 1);
                                        }
                                    }
                                }
                                this.$message({
                                    type: "success",
                                    message: "選中商品已出貨(ﾉ>ω<)ﾉ"
                                });
                                if (this.ship.length === 0) {
                                    setTimeout(() => {
                                        this.$message({
                                            type: "info",
                                            message:
                                                "所有商品皆已出貨，建議將訂單狀態改為出貨。"
                                        });
                                    }, 1000);
                                }
                            })
                            .catch(() => {
                                this.$notify.error({
                                    title: "Something Goes Wrong ...",
                                    message: "Please refresh your page again",
                                    duration: 6800
                                });
                            });
                    } else {
                        this.$notify.error({
                            title: "錯誤",
                            message: "請至少選取一項商品",
                            type: "info",
                            duration: 1500
                        });
                    }
                })
                .catch(() => {
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
        getOrderdetails(id) {
            axios
                .get(`/api/orders/detail/${id}`)
                .then(res => {
                    let i;
                    let j;
                    this.info = res.data.info;
                    this.products = res.data.item;
                    this.details = res.data.data;
                    this.ship = this.details.filter(function(item) {
                        return item.ship === 0;
                    });
                    for (i = 0; i < this.products.length; i++) {
                        this.products[i].num = this.details[i].num;
                        this.products[i].id = this.details[i].pid;
                        this.products[i].total =
                            this.details[i].num * this.products[i].price;
                        this.subTotal =
                            this.subTotal + parseInt(this.products[i].total);
                        for (j = 0; j < this.ship.length; j++) {
                            if (this.ship[j].pid === this.products[i].id) {
                                this.ship[j].name = this.products[i].name;
                            }
                        }
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
        getMoney() {
            this.cash = "成功收到款項";
        },
        shipping() {
            if (this.group.length !== 0) {
                axios
                    .post(`/api/orders/${this.oid}/ship`, {
                        group: this.group
                    })
                    .then(() => {
                        let i;
                        let j;
                        for (i = 0; i < this.ship.length; i++) {
                            for (j = 0; j < this.group.length; j++) {
                                if (this.group[j] === this.ship[i].pid) {
                                    this.ship.splice(i, 1);
                                }
                            }
                        }
                        this.$notify({
                            title: "成功",
                            message: "選中商品已出貨(ﾉ>ω<)ﾉ",
                            type: "success",
                            duration: 1500
                        });
                    })
                    .catch(() => {
                        this.$notify.error({
                            title: "Something Goes Wrong ...",
                            message: "Please refresh your page again",
                            duration: 6800
                        });
                    });
            }
        },
        backPage() {
            this.$router.go(-1);
        }
    }
};
</script>

<style lang="scss" scoped>
$color: #2d2d2d;
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
        .fa-long-arrow-alt-left {
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
    .btn-group {
        margin-right: 20px;
        .btn {
            width: 120px;
            color: #fff;
            .fas {
                margin-right: 8px;
            }
        }
        .truck {
            background: lighten(#666, 30%);
        }
        .done {
            background: #1ca753;
        }
        .cancel {
            background: lighten(red, 20%);
        }
    }
}
.main-wrap {
    display: flex;
    margin-top: 30px;
    margin-left: 75px;
    .toggle {
        transform: scaley(-1);
    }
    .show {
        display: none;
    }
    .order-detail {
        width: 50%;
        .product {
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
                            background: rgb(182, 100, 100);
                        }
                        td {
                            &:first-child {
                                text-align: left;
                            }
                            text-align: center;
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
        .other-fee {
            margin-top: 50px;
            h4 {
                color: #0f4c81;
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
                            background: rgb(182, 100, 100);
                        }
                        td {
                            &:first-child {
                                text-align: left;
                            }
                            text-align: center;
                        }
                    }
                }
            }
            .price {
                width: 85%;
                display: flex;
                justify-content: space-between;
            }
        }
    }
    .bill {
        width: 85%;
        margin-top: 40px;
        h4 {
            color: #0f4c81;
        }
        .bill-info {
            margin-top: 30px;
            width: 100%;
            height: 60px;
            display: flex;
            justify-content: flex-start;
            background: rgb(226, 236, 248);
            align-items: center;
            border: 1px solid #999;
            color: lighten(#0f4c81, 10%);
            padding-left: 10px;
            h5 {
                font-size: 22px;
                margin-top: 5px;
                margin-right: 20px;
            }
        }
        .bill-address {
            margin-top: 20px;
            h5 {
                color: darken(#1ca753, 10%);
                font-size: 24px;
                &:last-child {
                    color: #2d2d2d;
                }
            }
        }
    }
    .payment-info {
        width: 50%;
        .pay {
            width: 85%;
            width: 100%;
            h4 {
                color: #0f4c81;
                &::after {
                    content: "";
                    display: block;
                    width: 85%;
                    height: 1px;
                    background: #666;
                    margin-top: 15px;
                }
            }
            .pay-detail {
                width: 85%;
                display: flex;
                justify-content: space-between;
                margin-top: 20px;
                .txt {
                    color: lighten(#0f4c81, 10%);
                    h5 {
                        &:last-child {
                            color: rgb(230, 154, 15);
                        }
                    }
                }
            }
            .btn-pay {
                width: 85%;
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 30px;
                h5 {
                    font-size: 18px;
                    color: #666;
                }
                button {
                    background: #1ca753;
                    color: #fff;
                    padding: 5px;
                }
            }
        }
        .delivery {
            margin-top: 70px;
            width: 85%;
            h4 {
                color: #0f4c81;
                &::after {
                    content: "";
                    display: block;
                    width: 100%;
                    height: 1px;
                    background: #666;
                    margin-top: 15px;
                }
            }
            .checkbox {
                margin-top: 10px;
                label {
                    margin-left: 30px;
                    color: #2d2d2d;
                }
            }
            .btn-send {
                width: 100%;
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 30px;
                h5 {
                    font-size: 18px;
                    color: #666;
                }
                button {
                    background: #1ca753;
                    color: #fff;
                    padding: 5px;
                }
            }
        }
        .order-note {
            width: 85%;
            margin-top: 30px;
            h4 {
                color: #0f4c81;
                &::after {
                    content: "";
                    display: block;
                    width: 100%;
                    height: 1px;
                    background: #666;
                    margin-top: 15px;
                }
            }
        }
    }
}
</style>
