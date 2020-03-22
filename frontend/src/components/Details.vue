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
                    <div class="item ine">
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
                    <div class="item">
                        <i class="fas fa-list-alt"></i>
                        <h5>My orders</h5>
                    </div>
                </router-link>
            </div>
            <div class="right">
                <i class="far fa-address-card"></i>
                <h3>MY DETAILS</h3>
                <h4>
                    Feel free to edit any of your details below so your EPOCH
                    account is totally up to date.
                </h4>
                <form class="form-signin" @submit.prevent="changeInfo">
                    <label for="inputEmail">EMAIL ADDRESS:</label>
                    <input
                        type="email"
                        id="inputEmail"
                        name="email"
                        class="form-control"
                        v-model="user[0].email"
                    />
                    <label for="inputName">NAME:</label>
                    <input
                        type="name"
                        id="inputName"
                        class="form-control"
                        v-model="user[0].name"
                    />
                    <label for="inputPassword">DATE OF BIRTH:</label>
                    <el-date-picker
                        v-model="user[0].birthday"
                        type="date"
                        placeholder="Choose Date"
                    >
                    </el-date-picker>
                    <label for="inputPassword">MOSTLY INTERESTED IN:</label>
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="inlineRadioOptions"
                            id="inlineRadio1"
                            value="F"
                            v-model="user[0].sex"
                        />
                        <label class="form-check-label" for="inlineRadio1"
                            >Womanswear</label
                        >
                    </div>
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="inlineRadioOptions"
                            id="inlineRadio2"
                            value="M"
                            v-model="user[0].sex"
                        />
                        <label class="form-check-label" for="inlineRadio2"
                            >Manswear</label
                        >
                    </div>
                    <button class="btn btn-sm btn-dark btn-block" type="submit">
                        SAVE CHANGE
                    </button>
                </form>
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

export default {
    name: "Details",

    data() {
        return {
            uid: this.$store.state.info.id,
            userName: this.$store.state.info.name,
            user: {}
        };
    },
    computed: {
        splitName: function() {
            return this.userName.split("")[0].toUpperCase();
        }
    },
    created() {
        this.getInfo(this.uid);
    },
    methods: {
        getInfo(id) {
            axios.get(`/api/user/info/${id}`).then(res => {
                this.user = res.data.data;
            });
        },
        changeInfo() {
            axios
                .put(`/api/user/changeinfo/${this.uid}`, {
                    email: this.user[0].email,
                    name: this.user[0].name,
                    birthday: this.user[0].birthday,
                    sex: this.user[0].sex
                })
                .then(res => {
                    if(res.data.result === false){
                        this.$notify.error({
                            title: "抱歉",
                            message: res.data.msg
                        });
                    } else {
                        this.$message({
                            message: "恭喜您！資料修改成功",
                            type: "success"
                        });
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
            .far,.fas {
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
        height: 850px;
        background: #fff;
        margin-left: 20px;
        .fa-address-card {
            padding: 20px;
            font-size: 28px;
        }
        h3 {
            font-size: 30px;
            font-weight: bold;
            padding-left: 20px;
        }
        h4 {
            font-size: 20px;
            padding-left: 20px;
        }
        form {
            width: 350px;
            margin: auto;
            margin: 50px;
            label {
                color: #666;
                font-size: 14px;
                display: block;
                margin-top: 40px;
            }
            input {
                background-color: #fff;
                border: 1px solid #000;
                margin-bottom: 30px;
            }
            .btn {
                margin-top: 40px;
                width: 80%;
                margin: auto;
                color: #2d2d2d;
                color: #fff;
                border: none;
                &:hover {
                    background: #aaa;
                }
            }
            .form-check {
                margin: 20px;
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
.ine {
    border-left: 4px solid #0f4c81;
}
</style>
