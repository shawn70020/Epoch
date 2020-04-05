<template>
    <div class="wrap">
        <div class="top">
            <div class="title"><h3>商品管理</h3></div>
            <div class="open-modal">
                <button class="btn btn-primary" @click="openModal(true)">
                    建立新商品
                </button>
            </div>
        </div>
        <div class="table-wrap">
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th scope="col">＃編號</th>
                        <th scope="col">分類</th>
                        <th scope="col">名稱</th>
                        <th scope="col">售價</th>
                        <th scope="col">庫存</th>
                        <th scope="col">狀態</th>
                        <th scope="col">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in products" :key="item.id">
                        <th>{{ item.id }}</th>
                        <th>{{ item.class }}</th>
                        <td>{{ item.name }}</td>
                        <td>{{ item.price }}</td>
                        <td>{{ item.num }}</td>
                        <td v-if="item.enable === 1">啟用</td>
                        <td v-if="item.enable === 0">未啟用</td>
                        <td class="operate-btn">
                            <button @click="openModal(false, item)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button @click="delProduct(item.id)">
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
                            <span>商品管理</span>
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
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="customFile"
                                        >請上傳圖片
                                        <i
                                            class="fas fa-spinner fa-spin"
                                            v-if="status.fileUploading"
                                        ></i>
                                    </label>
                                    <input
                                        type="file"
                                        id="customFile"
                                        class="form-control"
                                        ref="files"
                                        @change="uploadFile"
                                    />
                                </div>
                                <img
                                    class="img-fluid"
                                    v-if="imageUrl"
                                    :src="imageUrl"
                                    alt=""
                                />
                                <img
                                    class="img-fluid"
                                    v-if="tempProduct.image && !imageUrl"
                                    :src="
                                        'data:image/png;base64,' +
                                            tempProduct.image
                                    "
                                    alt=""
                                />
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="title">品名</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="title"
                                        v-model="tempProduct.name"
                                        placeholder="請輸入商品名稱"
                                    />
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="category">大分類</label>
                                        <div class="class">
                                            <div class="left">
                                                <input
                                                    class="form-control"
                                                    type="radio"
                                                    name="inlineRadioOptions"
                                                    id="category"
                                                    value="W"
                                                    v-model="tempProduct.sex"
                                                />
                                                <label
                                                    class="form-check-label"
                                                    for="category"
                                                    >女裝</label
                                                >
                                            </div>
                                            <div>
                                                <input
                                                    class="form-control"
                                                    type="radio"
                                                    name="inlineRadioOptions"
                                                    id="category"
                                                    value="M"
                                                    v-model="tempProduct.sex"
                                                />
                                                <label
                                                    class="form-check-label"
                                                    for="inlineRadio2"
                                                    >男裝</label
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="category">細分類</label>
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
                                        <label for="origin_price">售價</label>
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
                                    <label for="description">產品描述</label>
                                    <textarea
                                        type="text"
                                        class="form-control"
                                        id="description"
                                        v-model="tempProduct.detail"
                                        placeholder="請輸入產品描述"
                                    ></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="content">說明內容</label>
                                    <textarea
                                        type="text"
                                        class="form-control"
                                        id="content"
                                        v-model="tempProduct.content"
                                        placeholder="請輸入產品說明內容"
                                    ></textarea>
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
import axios from "axios";
import $ from "jquery";

export default {
    name: "Products",
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
            axios
                .get(`/api/admin/products/page=${this.page}`)
                .then(res => {
                    this.products = res.data.data;
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
        previousPage() {
            let page = this.page - 1;
            if (page > 0) {
                axios
                    .get(`/api/admin/products/page=${page}`)
                    .then(res => {
                        this.products = res.data.data;
                        this.page = page;
                    })
                    .catch(() => {
                        this.$notify.error({
                            title: "Something Goes Wrong ...",
                            message: "Please refresh your page again",
                            duration: 6800
                        });
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
                    .get(`/api/admin/products/page=${page}`)
                    .then(res => {
                        this.products = res.data.data;
                        this.page = page;
                    })
                    .catch(() => {
                        this.$notify.error({
                            title: "Something Goes Wrong ...",
                            message: "Please refresh your page again",
                            duration: 6800
                        });
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
                            this.$notify({
                                title: "成功",
                                message: "已編輯一筆商品",
                                type: "success",
                                duration: 1500
                            });
                            $("#productModal").modal("hide");
                            this.getProducts();
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
                axios
                    .post("/api/products/upload", vm.tempProduct)
                    .then(res => {
                        if (res.data.result === true) {
                            this.$notify({
                                title: "成功",
                                message: "已新增一筆商品",
                                type: "success",
                                duration: 1500
                            });
                            $("#productModal").modal("hide");
                            this.getProducts();
                        } else {
                            this.$notify.error({
                                title: "抱歉",
                                message: "請確認所有欄位都填寫",
                                duration: 1500
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
            }
        },
        openDelProductModal(item) {
            const vm = this;
            $("#delProductModal").modal("show");
            vm.tempProduct = Object.assign({}, item);
        },
        uploadFile() {
            const uploadedFile = this.$refs.files.files[0];
            const formData = new FormData();
            formData.append("file-to-upload", uploadedFile);
            const config = {
                headers: { "Content-Type": "multipart/form-data" }
            };
            this.status.fileUploading = true;
            axios
                .post("/api/products/imageupload", formData, config)
                .then(res => {
                    this.status.fileUploading = false;
                    if (res.data.result === true) {
                        this.imageUrl = URL.createObjectURL(uploadedFile);
                        this.tempProduct.image = res.data.data;
                    } else {
                        this.imageUrl = null;
                        this.tempProduct.image = "";
                        $("#customFile").val("");
                        this.$notify.error({
                            title: "錯誤",
                            message: "只接受圖片檔",
                            duration: 1500
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
        },
        delProduct(id) {
            this.$confirm("此操作將永久刪除此商品, 是否繼續?", "提示", {
                confirmButtonText: "確定",
                cancelButtonText: "取消",
                type: "warning"
            })
                .then(() => {
                    axios
                        .delete(`/api/products/delete/${id}`)
                        .then(res => {
                            if (res.data.result === true) {
                                this.$notify({
                                    title: "成功",
                                    message: "已成功刪除此商品",
                                    type: "success",
                                    duration: 1500
                                });
                                this.getProducts();
                            } else {
                                this.$notify.error({
                                    title: "錯誤",
                                    message: "查無此商品",
                                    duration: 1500
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
        }
        .fa-arrow-left,
        .fa-arrow-right {
            cursor: pointer;
        }
    }
}
.class {
    display: flex;
    .left {
        margin-right: 40px;
    }
}
</style>
