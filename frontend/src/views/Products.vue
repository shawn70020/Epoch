<template>
    <div>
        <div class="text-right mt-4">
            <button class="btn btn-primary" @click="openModal(true)">
                建立新商品
            </button>
        </div>
        <!-- <table class="table mt-4">
      <thead>
        <tr>
          <th width="120">分類</th>
          <th>產品名稱</th>
          <th width="120">原價</th>
          <th width="120">售價</th>
          <th width="100">是否啟用</th>
          <th width="80">編輯</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item) in products" :key="item.id">
          <td>{{ item.category }}</td>
          <td>{{ item.title }}</td>
          <td class="text-right">
            {{ item.origin_price | currency }}
          </td>
          <td class="text-right">
            {{ item.price | currency }}
          </td>
          <td>
            <span v-if="item.is_enabled" class="text-success">啟用</span>
            <span v-else>未啟用</span>
          </td>
          <td>
            <div class="btn-group">
              <button class="btn btn-outline-primary btn-sm"
              @click="openModal(false, item)">編輯</button>
              <button class="btn btn-outline-danger btn-sm"
                @click="openDelProductModal(item)"
              >刪除</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table> -->

        <!-- <Pagination :pages="pagination" @emitPages="getProducts"></Pagination> -->
        <!-- Modal -->
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
                                    <label for="image">輸入圖片網址</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="image"
                                        v-model="tempProduct.imageUrl"
                                        placeholder="請輸入圖片連結"
                                    />
                                </div>
                                <div class="form-group">
                                    <label for="customFile"
                                        >或 上傳圖片
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
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="title">品名</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="title"
                                        v-model="tempProduct.title"
                                        placeholder="請輸入商品名稱"
                                    />
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="category">大分類</label>
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
                                    <div class="form-group col-md-6">
                                        <label for="category">細分類</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="category"
                                            v-model="tempProduct.category"
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
                                        v-model="tempProduct.description"
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
                                            v-model="tempProduct.is_enabled"
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
// import Pagination from '../components/Pagination';

export default {
    name: "Products",
    data() {
        return {
            products: [],
            pagination: {},
            tempProduct: {},
            isNew: false,
            isLoading: false,
            imageUrl: null,
            status: {
                fileUploading: false
            }
        };
    },
    components: {
        // Pagination,
    },
    methods: {
        getProducts(page = 1) {
            const api = `${process.env.APIPATH}/api/${process.env.CUSTOMPATH}/admin/products?page=${page}`; // 'http://localhost:3000/api/casper/products';
            const vm = this;
            console.log(process.env.APIisLoadingPATH, process.env.CUSTOMPATH);
            vm.isLoading = true;
            this.$http.get(api).then(response => {
                console.log(response.data);
                if (response.data.success) {
                    vm.isLoading = false;
                    vm.products = response.data.products;
                    vm.pagination = response.data.pagination;
                }
            });
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
                this.tempProduct = Object.assign({}, item);
                this.isNew = false;
            }
            $("#productModal").modal("show");
        },
        updateProduct() {
            const vm = this;
            if (!vm.isNew) {
                // api = `${process.env.APIPATH}/api/${process.env.CUSTOMPATH}/admin/product/${vm.tempProduct.id}`;
            }
            axios
                .post("/api/products/upload", vm.tempProduct)
                .then(res => {
                    if (res.data.result === true) {
                        console.log(123);
                    } else {
                        console.log(456);
                    }
                })
                .catch(err => {
                    console.log(err);
                });
            // this.$http[httpMethod](api, { data: vm.tempProduct }).then(
            //     response => {
            //         console.log(response.data);
            //         if (response.data.success) {
            //             $("#productModal").modal("hide");
            //             vm.getProducts();
            //         } else {
            //             $("#productModal").modal("hide");
            //             vm.getProducts();
            //             console.log("新增失敗");
            //         }
            //         // vm.products = response.data.products;
            //     }
            // );
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
                    }
                })
                .catch(err => {
                    console.log(err);
                });
        }
    },
    created() {
        this.getProducts();
    }
};
</script>
