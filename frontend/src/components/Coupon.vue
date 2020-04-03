<template>
    <div class="wrap">
        <div class="top">
            <div class="title"><h3>優惠券管理</h3></div>
            <div class="open-modal">
                <button class="btn btn-primary" @click="openModal(true)">
                    建立優惠券
                </button>
            </div>
        </div>
        <div class="table-wrap">
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th scope="col">名稱</th>
                        <th scope="col">折扣(%)</th>
                        <th scope="col">到期日</th>
                        <th scope="col">狀態</th>
                        <th scope="col">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in products" :key="item.id">
                        <th>{{ item.name }}</th>
                        <td>{{ item.discount }}</td>
                        <td>{{ moment(item.expiry_date).calendar() }}</td>
                        <td v-if="item.enable === 1">啟用</td>
                        <td v-if="item.enable === 0">未啟用</td>
                        <td class="operate-btn">
                            <button @click="openModal(false, item)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button @click="delCoupon(item.id)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="page-arrow">
            <i class="fas fa-arrow-left" @click="previousPage"></i>
            <i class="fas fa-arrow-right" @click="nextPage"></i>
        </div>
        <div
            class="modal fade"
            id="productModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content border-0">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <span>優惠券管理</span>
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="title">優惠券名</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="title"
                                        v-model="tempProduct.name"
                                        placeholder="請輸入券名"
                                    />
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="category">折扣碼</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="category"
                                            v-model="tempProduct.code"
                                            placeholder="請輸入折扣碼"
                                        />
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-8">
                                        <label for="origin_price">百分比</label>
                                        <input
                                            type="number"
                                            class="form-control"
                                            id="origin_price"
                                            v-model="tempProduct.discount"
                                            placeholder="請輸入折扣百分比"
                                        />
                                    </div>
                                </div>
                                <hr />
                                <div class="form-group">
                                    <label for="due_date">到期日</label>
                                    <el-date-picker
                                        v-model="tempProduct.expiry_date"
                                        type="date"
                                        placeholder="請選擇到期日"
                                    >
                                    </el-date-picker>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            v-model="tempProduct.enable"
                                            :true-value="1"
                                            :false-value="0"
                                            id="is_enabled"
                                        />
                                        <label
                                            class="form-check-label"
                                            for="is_enabled"
                                        >
                                            是否啟用
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            data-dismiss="modal"
                        >
                            取消
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="updateProduct"
                        >
                            確認
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
var moment = require("moment");
import axios from "axios";
import $ from "jquery";

export default {
    name: "Coupon",
    data() {
        return {
            moment: moment,
            products: [],
            page: 1,
            total: "",
            tempProduct: {},
            isNew: false,
            isLoading: false,
            imageUrl: null,
            status: {
                fileUploading: false
            }
        };
    },
    created() {
        this.getCoupons();
    },
    methods: {
        getCoupons() {
            axios.get(`/api/admin/coupons/page=${this.page}`).then(res => {
                this.products = res.data.data;
                this.total = res.data.total;
            });
        },
        previousPage() {
            let page = this.page - 1;
            if (page > 0) {
                axios.get(`/api/admin/coupons/page=${page}`).then(res => {
                    this.products = res.data.data;
                    this.page = page;
                });
            } else {
                this.$notify.info({
                    title: "提醒",
                    message: "這已是第一頁！(`・ω・´)",
                    duration: 1500
                });
            }
        },
        nextPage() {
            let page = this.page + 1;
            if (page <= this.total) {
                axios
                    .get(`/api/admin/coupons/page=${page}`)
                    .then(res => {
                        this.products = res.data.data;
                        this.page = page;
                    })
                    .catch(err => {
                        console.log(err);
                    });
            } else {
                this.$notify.info({
                    title: "提醒",
                    message: "這已是最後一頁！(`・ω・´)",
                    duration: 1500
                });
            }
        },
        openModal(isNew, item) {
            if (isNew) {
                this.tempProduct = {
                    enable: 0
                };
                this.isNew = true;
            } else {
                this.tempProduct = Object.assign({}, item);
                this.isNew = false;
            }
            $("#productModal").modal("show");
        },
        updateProduct() {
            const vm = this;
            if (!vm.isNew) {
                axios
                    .put("/api/coupons/update", vm.tempProduct)
                    .then(res => {
                        if (res.data.result === true) {
                            this.$notify({
                                title: "成功",
                                message: "已編輯一筆優惠券",
                                type: "success",
                                duration: 1500
                            });
                            $("#productModal").modal("hide");
                            this.getCoupons();
                        }
                    })
                    .catch(err => {
                        console.log(err);
                    });
            } else {
                axios
                    .post("/api/coupons/upload", vm.tempProduct)
                    .then(res => {
                        if (res.data.result === true) {
                            this.$notify({
                                title: "成功",
                                message: "已新增一筆優惠券",
                                type: "success",
                                duration: 1500
                            });
                            $("#productModal").modal("hide");
                            this.getCoupons();
                        } else {
                            this.$notify.error({
                                title: "錯誤",
                                message: "請確定所有欄位輸入",
                                duration: 1500
                            });
                        }
                    })
                    .catch(err => {
                        console.log(err);
                    });
            }
        },
        openDelProductModal(item) {
            const vm = this;
            $("#delProductModal").modal("show");
            vm.tempProduct = Object.assign({}, item);
        },
        delCoupon(id) {
            this.$confirm("此操作將永久刪除此優惠券, 是否繼續?", "提示", {
                confirmButtonText: "確定",
                cancelButtonText: "取消",
                type: "warning"
            })
                .then(() => {
                    axios
                        .delete(`/api/coupons/delete/${id}`)
                        .then(res => {
                            if (res.data.result === true) {
                                this.$notify({
                                    title: "成功",
                                    message: "已成功刪除此優惠券",
                                    type: "success",
                                    duration: 1500
                                });
                                this.getCoupons();
                            } else {
                                this.$notify.error({
                                    title: "錯誤",
                                    message: "查無此優惠券",
                                    duration: 1500
                                });
                            }
                        })
                        .catch(err => {
                            console.log(err);
                        });
                })
                .catch(() => {
                    this.$notify.info({
                        title: "提醒",
                        message: "已取消刪除動作",
                        duration: 1500
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
    .top {
        display: flex;
        width: 100%;
        height: 100px;
        justify-content: space-between;
        align-items: flex-end;
        .title {
            margin-left: 50px;
        }
        .open-modal {
            margin-right: 50px;
        }
    }
    .table-wrap {
        // background: #000;
        width: 100vw;
        .table {
            width: 75%;
            margin-top: 1.5rem;
            margin-left: 5%;
            .operate-btn {
                button {
                    color: #0f4c81;
                    &:last-child {
                        color: darken(red, 8%);
                    }
                }
            }
        }
    }
    .page-arrow {
        margin: auto;
        .fas {
            margin: 0 20px;
            cursor: pointer;
        }
    }
}
</style>
