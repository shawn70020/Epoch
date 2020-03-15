<template>
    <div class="wrap">
        <div class="title">
            <h2>Epoch</h2>
        </div>
        <div class="container">
            <div class="tabs">
                <div class="left">
                    <h5>NEW TO HERE?</h5>
                </div>
                <div class="right">
                    <router-link to="/login" class="link"
                        >ALREADY REGISTERED?
                    </router-link>
                </div>
            </div>
            <div class="sign-form">
                <h3>{{ datee }}</h3>
                <h3>SIGN UP USING YOUR EMAIL ADDRESS</h3>
                <form class="form-signin" @submit.prevent="signin">
                    <label for="inputEmail">EMAIL ADDRESS:</label>
                    <validation-provider rules="required" v-slot="{ errors }">
                        <input
                            type="email"
                            id="inputEmail"
                            name="email"
                            class="form-control"
                            v-model="user.email"
                        />
                        <span>{{ errors[0] }}</span>
                    </validation-provider>
                    <label for="inputPassword">PASSWORD:</label>
                    <input
                        type="password"
                        id="inputPassword"
                        class="form-control"
                        v-model="user.password"
                    />
                    <label for="inputName">NAME:</label>
                    <input
                        type="name"
                        id="inputName"
                        class="form-control"
                        v-model="user.username"
                    />
                    <label for="inputPassword">DATE OF BIRTH:</label><br />
                    <vue-datepicker-local v-model="user.time" />
                    <label for="inputPassword">MOSTLY INTERESTED IN:</label
                    ><br />
                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="inlineRadioOptions"
                            id="inlineRadio1"
                            value="F"
                            v-model="user.sex"
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
                            v-model="user.sex"
                        />
                        <label class="form-check-label" for="inlineRadio2"
                            >Manswear</label
                        >
                    </div>
                    <h5>
                        By creating your account, you agree to our Terms and
                        Conditions & Privacy Policy
                    </h5>
                    <button class="btn btn-sm btn-dark btn-block" type="submit">
                        JOIN
                    </button>
                </form>
            </div>
            <div class="txt">
                <h5>&copy; 2020</h5>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import VueDatepickerLocal from "vue-datepicker-local";

export default {
    name: "Register",
    components: {
        VueDatepickerLocal
    },
    data() {
        return {
            datee: "",
            user: {
                email: "",
                username: "",
                password: "",
                time: "",
                sex: ""
            }
        };
    },
    created() {
        this.getdate();
    },
    methods: {
        success() {
            this.$notify({
                title: "成功",
                message: "註冊會員",
                type: "success"
            });
        },
        error() {
            this.$notify.error({
                title: "抱歉",
                message: "註冊失敗！請重新嘗試"
            });
        },
        signin() {
            const vm = this;
            axios
                .post("/api/signin", {
                    email: vm.user.email,
                    password: vm.user.password,
                    name: vm.user.username,
                    date: vm.user.time,
                    sex: vm.user.sex
                })
                .then(res => {
                    if (res.data.result === true) {
                        this.$message({
                            message: "恭喜您！註冊會員成功",
                            type: "success"
                        });
                        setTimeout(() => {
                            vm.$router.push("/login");
                        }, 1500);
                    } else {
                        this.$notify.error({
                            title: "抱歉",
                            message: res.data.msg
                        });
                    }
                })
                .catch(err => {
                    console.log(err);
                });
        }
    }
};
</script>

<style lang="scss" scoped>
.wrap {
    background: #eee;
    height: 100%;
}
.title {
    padding: 20px 0;
    h2 {
        text-align: center;
        font-size: 28px;
        font-family: "Krona One", sans-serif;
    }
}
.container {
    background: #fff;
    width: 650px;
    .tabs {
        display: flex;
        justify-content: center;
        padding-top: 30px;
        .left {
            width: 305px;
            height: 60px;
            text-align: center;
            line-height: 60px;
            border-top: 1px solid #000;
            border-right: 1px solid #000;
            border-left: 1px solid #000;
            h5 {
                font-size: 16px;
                line-height: 60px;
            }
        }
        .right {
            width: 305px;
            height: 60px;
            text-align: center;
            line-height: 60px;
            border-bottom: 1px solid #000;
            .link {
                color: #999;
                font-size: 16px;
                text-decoration: none;
            }
        }
    }
    .sign-form {
        margin-top: 30px;
        h3 {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
        }
        h5 {
            padding-top: 20px;
            padding-bottom: 20px;
            font-size: 12px;
        }
        form {
            width: 350px;
            margin: auto;
            label {
                color: #666;
                font-size: 14px;
            }
            input {
                background-color: #fff;
                border: 1px solid #000;
                margin-bottom: 30px;
            }
            .btn {
                width: 80%;
                margin: auto;
                color: #2d2d2d;
                color: #fff;
                border: none;
                &:hover {
                    background: #aaa;
                }
            }
        }
    }
    .txt {
        margin-top: 40px;
        padding-bottom: 40px;
        text-align: center;
        h5 {
            font-size: 24px;
            &:last-child {
                font-size: 20px;
                padding-top: 30px;
            }
        }
    }
}
</style>
