<template>
    <div class="wrap">
        <div class="title">
            <router-link to="/">
            <h2>Epoch</h2>
            </router-link>
        </div>
        <div class="container">
            <div class="tabs">
                <div class="left">
                    <router-link to="/register" class="link"
                        >NEW TO HERE?
                    </router-link>
                </div>
                <div class="right">
                    <h5>ALREADY REGISTERED?</h5>
                </div>
            </div>
            <div class="sign-form">
                <h3>SIGN IN WITH EMAIL</h3>
                <div class="error" :style="{ opacity: showError }">
                    <i class="fas fa-info-circle"></i>
                    <div class="msg">
                        <h5>
                            Looks like either your email address or password
                            were incorrect. Wanna try again?
                        </h5>
                    </div>
                </div>
                <el-form
                    :model="ruleForm"
                    :rules="rules"
                    ref="ruleForm"
                    label-width="120px"
                    class="demo-ruleForm form"
                    status-icon
                >
                    <el-form-item label="Email" prop="email">
                        <el-input v-model="ruleForm.email"></el-input>
                    </el-form-item>
                    <el-form-item label="Password" prop="password">
                        <el-input
                            type="password"
                            v-model="ruleForm.password"
                            autocomplete="off"
                            @keyup.enter.native="submitForm('ruleForm')"
                        ></el-input>
                    </el-form-item>
                    <el-form-item class="btn">
                        <el-button
                            type="primary"
                            @click="submitForm('ruleForm')"
                            >SIGN IN</el-button
                        >
                        <el-button @click="resetForm('ruleForm')"
                            >RESET</el-button
                        >
                    </el-form-item>
                </el-form>
            </div>
            <div class="txt">
                <h5>WELCOME</h5>
                <h5>TO</h5>
                <h5>Epoch</h5>
                <h5>&copy; 2020</h5>
            </div>
        </div>
        <loading :active.sync="isLoading"></loading>
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "Login",
    data() {
        return {
            isLoading: false,
            showError: 0,
            type: "password",
            btnText: "SHOW",
            ruleForm: {
                email: "",
                password: ""
            },
            rules: {
                email: [
                    {
                        required: true,
                        message: "Please Enter Your Email",
                        trigger: "blur"
                    },
                    {
                        type: "email",
                        message: "Your Email Type is not correct",
                        trigger: ["blur", "change"]
                    }
                ],
                password: [
                    {
                        required: true,
                        message: "Please Enter Your Password",
                        trigger: "blur"
                    }
                ]
            }
        };
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate(valid => {
                if (valid) {
                    const vm = this;
                    vm.isLoading = true;
                    axios
                        .post("/api/login", {
                            email: vm.ruleForm.email,
                            password: vm.ruleForm.password
                        })
                        .then(res => {
                            vm.isLoading = false;
                            if (res.data.result === true) {
                                localStorage.setItem("token", res.data.token);
                                this.$store.state.isLogin = true;
                                if (res.data.level === "member") {
                                    if (res.data.sex === "M") {
                                        vm.$router.push("/men");
                                    } else {
                                        vm.$router.push("/women");
                                    }
                                } else {
                                    vm.$router.push("/admin/dashboard");
                                }
                            } else if (res.data.result === "frozen") {
                                this.$notify.error({
                                    title: "Sorry",
                                    message: "This Account Has Been Frozen",
                                    duration: 1800
                                });
                            } else {
                                vm.showError = 1;
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
                    return false;
                }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
        },
        showPassword() {
            if (this.type === "password") {
                this.type = "text";
                this.btnText = "HIDE";
            } else {
                this.type = "password";
                this.btnText = "SHOW";
            }
        }
    }
};
</script>

<style lang="scss" scoped>
.wrap {
    background: #eee;
    height: 100vh;
}
.title {
    padding: 20px 0;
    a{
        text-decoration: none;
        color: #2d2d2d;
    }
    h2 {
        text-align: center;
        font-size: 38px;
        font-weight: bold;
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
            border-bottom: 1px solid #000;
            .link {
                color: #999;
                font-size: 16px;
                text-decoration: none;
            }
        }
        .right {
            width: 305px;
            height: 60px;
            text-align: center;
            border-top: 1px solid #000;
            border-right: 1px solid #000;
            border-left: 1px solid #000;
            h5 {
                font-size: 16px;
                line-height: 60px;
            }
        }
    }
    .sign-form {
        margin-top: 35px;
        h3 {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
        }
        .error {
            margin: auto;
            padding-top: 10px;
            width: 90%;
            height: 75px;
            background: #fae7ec;
            display: flex;
            align-items: center;
            text-align: center;
            .fas {
                font-size: 20px;
                padding-left: 10px;
            }
            .msg {
                h5 {
                    font-size: 15px;
                    font-family: "Roboto Mono";
                }
            }
        }
        form {
            padding-top: 20px;
            width: 75%;
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
            }
            .password-group {
                display: flex;
                position: relative;
                button {
                    position: absolute;
                    right: 2px;
                    top: 10px;
                    border: none;
                    background-color: #fff;
                    font-size: 16px;
                    font-family: "IM Fell Great Primer SC";
                    &:focus {
                        //focus藍框移除
                        outline: none;
                    }
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
