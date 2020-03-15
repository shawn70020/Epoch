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
                        <th>{{ item.class }}</th>
                        <td>{{ item.name }}</td>
                        <td>{{ item.price }}</td>
                        <td>{{ item.num }}</td>
                        <td v-if="item.enable === 1">啟用</td>
                        <td v-if="item.enable === 0">未啟用</td>
                        <td class="operate-btn">
                            <button @click="openModal(false, item)">
                                編輯
                            </button>
                            <button>刪除</button>
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
                                    <label for="title">券名</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="title"
                                        v-model="tempProduct.name"
                                        placeholder="請輸入優惠券名稱"
                                    />
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="category">優惠碼</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="category"
                                            v-model="tempProduct.class"
                                            placeholder="請輸入分類"
                                        />
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-8">
                                        <label for="origin_price"
                                            >折扣百分比</label
                                        >
                                        <input
                                            type="number"
                                            class="form-control"
                                            id="origin_price"
                                            v-model="tempProduct.price"
                                            placeholder="請輸入原價"
                                        />
                                    </div>
                                </div>
                                <hr />
                                <div class="form-group">
                                    <label for="due_date">到期日</label>
                                    <el-date-picker
                                        v-model="tempProduct.date"
                                        type="date"
                                        placeholder="Choose Date"
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
        <div
            class="modal fade"
            id="delProductModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content border-0">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="exampleModalLabel">
                            <span>刪除產品</span>
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
                        是否刪除
                        <strong class="text-danger">{{
                            tempProduct.title
                        }}</strong>
                        商品(刪除後將無法恢復)。
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
                            class="btn btn-danger"
                            @click="delProduct"
                        >
                            確認刪除
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import $ from "jquery";

export default {
    name: "Coupon",
    data() {
        return {
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
        this.getProducts();
    },
    methods: {
        getProducts() {
            axios.get(`/api/admin/products/page=${this.page}`).then(res => {
                this.products = res.data.data;
                this.total = res.data.total;
            });
        },
        previousPage() {
            let page = this.page - 1;
            if (page > 0) {
                axios
                    .get(`/api/admin/products/page=${page}`)
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
                    message: "這已是第一頁！(`・ω・´)"
                });
            }
        },
        nextPage() {
            let page = this.page + 1;
            if (page <= this.total) {
                axios
                    .get(`/api/admin/products/page=${page}`)
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
                    message: "這已是最後一頁！(`・ω・´)"
                });
            }
        },
        openModal(isNew, item) {
            if (isNew) {
                this.tempProduct = {
                    is_enabled: 0
                };
                this.imageUrl = null;
                $("#customFile").val("");
                this.isNew = true;
            } else {
                this.imageUrl = null;
                $("#customFile").val("");
                this.tempProduct = Object.assign({}, item);
                this.isNew = false;
            }
            $("#productModal").modal("show");
        },
        updateProduct() {
            const vm = this;
            if (!vm.isNew) {
                axios
                    .put("/api/products/update", vm.tempProduct)
                    .then(res => {
                        if (res.data.result === true) {
                            $("#productModal").modal("hide");
                            this.getProducts();
                        }
                    })
                    .catch(err => {
                        console.log(err);
                    });
            } else {
                axios
                    .post("/api/products/upload", vm.tempProduct)
                    .then(res => {
                        if (res.data.result === true) {
                            $("#productModal").modal("hide");
                            this.getProducts();
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
        delProduct() {
            const vm = this;
            const url = `${process.env.APIPATH}/api/${process.env.CUSTOMPATH}/admin/product/${vm.tempProduct.id}`;
            this.$http.delete(url).then(response => {
                console.log(response, vm.tempProduct);
                $("#delProductModal").modal("hide");
                vm.isLoading = false;
                this.getProducts();
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
        }
    }
}
</style>
