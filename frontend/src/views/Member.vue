<template>
    <div class="wrap">
        <div class="top">
            <div class="title"><h3>會員管理</h3></div>
        </div>
        <div class="table-wrap">
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th scope="col">＃會員編號</th>
                        <th scope="col">會員信箱</th>
                        <th scope="col">會員狀態</th>
                        <th scope="col">加入日期</th>
                        <th scope="col">上次登入日期</th>
                        <th scope="col">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in member" :key="item.id">
                        <td>{{ item.id }}</td>
                        <td>{{ item.email }}</td>
                        <td v-if="item.status === 0">可使用</td>
                        <td v-if="item.status === 1">已凍結</td>
                        <td>{{ item.addDate }}</td>
                        <td>{{ item.lastDate }}</td>
                        <td class="operate-btn">
                            <router-link
                                :to="{
                                    name: 'Memberdetails',
                                    params: { uid: item.id }
                                }"
                            >
                                <i class="fas fa-edit"></i>
                            </router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="page-arrow">
            <i class="fas fa-arrow-left" @click="previousPage"></i>
            <i class="fas fa-arrow-right" @click="nextPage"></i>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "Orders",
    data() {
        return {
            member: [],
            page: 1,
            total: "",
            tempProduct: {},
            isNew: false
        };
    },
    created() {
        this.getMembers();
    },
    methods: {
        getMembers() {
            axios.get(`/api/admin/member/page=${this.page}`).then(res => {
                this.member = res.data.data.filter(function(item) {
                    return item.level === 0;
                });
                this.total = res.data.total;
            });
        },
        previousPage() {
            let page = this.page - 1;
            if (page > 0) {
                axios
                    .get(`/api/admin/orders/page=${page}`)
                    .then(res => {
                        this.orders = res.data.data;
                        this.array = res.data.data;
                        this.page = page;
                    })
                    .catch(err => {
                        console.log(err);
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
                    .get(`/api/admin/orders/page=${page}`)
                    .then(res => {
                        this.orders = res.data.data;
                        this.array = res.data.data;
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
    .selectBox {
        width: 20%;
        margin-left: 3%;
        margin-top: 1%;
    }
    .table-wrap {
        width: 100vw;
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
            cursor: pointer;
        }
    }
}
</style>
