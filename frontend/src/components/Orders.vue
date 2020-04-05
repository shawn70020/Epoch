<template>
    <div class="wrap">
        <div class="title">
            <h3>
                訂單管理<span class="outside"
                    >(以下列出<span class="inside" @click="getOrders">今日</span
                    >訂單)</span
                >
            </h3>
            <div class="block">
                <el-date-picker
                    v-model="value2"
                    type="daterange"
                    align="right"
                    unlink-panels
                    range-separator="至"
                    start-placeholder="開始日期"
                    end-placeholder="结束日期"
                    :picker-options="pickerOptions"
                    value-format="yyyy-MM-dd HH:mm:ss"
                    @change="getDateOrder"
                >
                </el-date-picker>
            </div>
        </div>
        <el-select
            v-model="value"
            placeholder="請選擇"
            @change="selectItem"
            class="selectBox"
        >
            <el-option
                v-for="item in options"
                :key="item.value"
                :label="item.label"
                :value="item.value"
            >
            </el-option>
        </el-select>
        <div class="table-wrap">
            <div class="empty" v-if="orders.length === 0">
                抱歉！今日尚無訂單
            </div>
            <table class="table table-borderless" v-if="orders.length !== 0">
                <thead>
                    <tr>
                        <th scope="col">分類</th>
                        <th scope="col">訂單編號</th>
                        <th scope="col">下單者ID</th>
                        <th scope="col">成立日期</th>
                        <th scope="col">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in orders" :key="item.id">
                        <th v-if="item.status === 0">處理中</th>
                        <td v-if="item.status === 1">已出貨</td>
                        <td v-if="item.status === 2">完成</td>
                        <td v-if="item.status === 3">取消</td>
                        <td>{{ item.id }}</td>
                        <td>{{ item.uid }}</td>
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
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "Orders",
    data() {
        return {
            orders: [],
            array: [],
            page: 1,
            total: "",
            tempProduct: {},
            isNew: false,
            isLoading: false,
            imageUrl: null,
            status: {
                fileUploading: false
            },
            options: [
                {
                    value: 4,
                    label: "全部"
                },
                {
                    value: 0,
                    label: "處理中"
                },
                {
                    value: 1,
                    label: "已出貨"
                },
                {
                    value: 2,
                    label: "完成"
                },
                {
                    value: 3,
                    label: "取消"
                }
            ],
            value: "",
            pickerOptions: {
                shortcuts: [
                    {
                        text: "最近一周",
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(
                                start.getTime() - 3600 * 1000 * 24 * 7
                            );
                            picker.$emit("pick", [start, end]);
                        }
                    },
                    {
                        text: "最近一個月",
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(
                                start.getTime() - 3600 * 1000 * 24 * 30
                            );
                            picker.$emit("pick", [start, end]);
                        }
                    },
                    {
                        text: "最近三個月",
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(
                                start.getTime() - 3600 * 1000 * 24 * 90
                            );
                            picker.$emit("pick", [start, end]);
                        }
                    }
                ]
            },
            value2: ""
        };
    },
    created() {
        this.getOrders();
    },
    methods: {
        getOrders() {
            axios
                .get("/api/admin/orders")
                .then(res => {
                    this.orders = res.data.data;
                    this.array = res.data.data;
                    this.total = res.data.total;
                })
                .catch(() => {
                    this.$notify.error({
                        title: "Something Goes Wrong ...",
                        message: "Please refresh your page again",
                        duration: 6800
                    });
                });
        },
        selectItem() {
            this.orders = this.array;
            if (this.value === 4) {
                return true;
            }
            if (this.value === 0) {
                this.orders = this.orders.filter(function(item) {
                    return item.status === 0;
                });
            }
            if (this.value === 1) {
                this.orders = this.orders.filter(function(item) {
                    return item.status === 1;
                });
            }
            if (this.value === 2) {
                this.orders = this.orders.filter(function(item) {
                    return item.status === 2;
                });
            }
            if (this.value === 3) {
                this.orders = this.orders.filter(function(item) {
                    return item.status === 3;
                });
            }
        },
        getDateOrder() {
            axios
                .post("/api/orders/datepick", {
                    date: this.value2
                })
                .then(res => {
                    this.orders = res.data.data;
                    this.array = res.data.data;
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
.wrap {
    background: #eee;
    display: flex;
    flex-direction: column;
    .title {
        margin-left: 50px;
        margin-top: 50px;
        h3 {
            .outside,
            .inside {
                font-size: 24px;
            }
            .inside {
                color: #db2c00;
                cursor: pointer;
            }
        }
    }
    .selectBox {
        width: 20%;
        margin-left: 3%;
        margin-top: 1%;
    }
    .table-wrap {
        width: 100vw;
        .empty {
            width: 80%;
            height: 50%;
            text-align: center;
            font-size: 40px;
            font-weight: bold;
            margin-top: 5rem;
        }
        .table {
            width: 75%;
            margin-top: 1.5rem;
            margin-left: 3%;
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
    .page-arrow {
        margin: auto;
        .fas {
            margin: 0 20px;
        }
    }
}
</style>
