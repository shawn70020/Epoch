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
                <h3>SIGN UP USING YOUR EMAIL ADDRESS</h3>
                <el-form
                    :model="ruleForm"
                    :rules="rules"
                    ref="ruleForm"
                    label-width="120px"
                    class="demo-ruleForm form"
                    status-icon="true"
                >
                    <el-form-item label="Email" prop="email">
                        <el-input v-model="ruleForm.email"></el-input>
                    </el-form-item>
                    <el-form-item label="Password" prop="password">
                        <el-input
                            type="password"
                            v-model="ruleForm.password"
                            autocomplete="off"
                        ></el-input>
                    </el-form-item>
                    <el-form-item label="Name" prop="username">
                        <el-input
                            type="text"
                            v-model="ruleForm.username"
                            autocomplete="off"
                        ></el-input>
                    </el-form-item>
                    <el-form-item label="DATE OF BIRTH" required>
                        <el-col>
                            <el-form-item prop="time">
                                <el-date-picker
                                    type="date"
                                    placeholder="Choose Date"
                                    v-model="ruleForm.time"
                                    style="width: 100%;"
                                ></el-date-picker>
                            </el-form-item>
                        </el-col>
                    </el-form-item>
                    <el-form-item label="INTERESTED IN" prop="sex">
                        <el-radio-group v-model="ruleForm.sex">
                            <el-radio label="F">Womenswear</el-radio>
                            <el-radio label="M">Menswear</el-radio>
                        </el-radio-group>
                    </el-form-item>
                    <el-form-item class="btn">
                        <el-button
                            type="primary"
                            @click="submitForm('ruleForm')"
                            >JOIN</el-button
                        >
                        <el-button @click="resetForm('ruleForm')"
                            >RESET</el-button
                        >
                    </el-form-item>
                </el-form>
            </div>
            <div class="txt">
                <h5>&copy; 2020</h5>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    name: "Register",
    data() {
        return {
            ruleForm: {
                email: "",
                password: "",
                username: "",
                time: "",
                sex: ""
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
                ],
                username: [
                    {
                        required: true,
                        message: "Please Enter Your Name",
                        trigger: "blur"
                    }
                ],
                time: [
                    {
                        type: "date",
                        required: true,
                        message: "Please Choose A Date",
                        trigger: "change"
                    }
                ],
                sex: [
                    {
                        required: true,
                        message: "Please Choose A Option",
                        trigger: "change"
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
                    axios
                        .post("/api/signin", {
                            email: vm.ruleForm.email,
                            password: vm.ruleForm.password,
                            name: vm.ruleForm.username,
                            date: vm.ruleForm.time,
                            sex: vm.ruleForm.sex
                        })
                        .then(res => {
                            if (res.data.result === true) {
                                this.$notify({
                                    title: "Success !",
                                    message: "Lead You To Login",
                                    type: "success",
                                    duration: 1600
                                });
                                setTimeout(() => {
                                    vm.$router.push("/login");
                                }, 1800);
                            } else {
                                this.$notify.error({
                                    title: "Sorry",
                                    message: res.data.msg,
                                    duration: 1800
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
                } else {
                    return false;
                }
            });
        },
        resetForm(formName) {
            this.$refs[formName].resetFields();
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
        width: 100%;
        h3 {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 50px;
        }
        .form {
            width: 80%;
            margin: auto;
            // label {
            //     color: #666;
            //     font-size: 14px;
            // }
            input {
                background-color: #fff;
                border: 1px solid #000;
                margin-bottom: 30px;
            }
            .btn {
                width: 80%;
                margin: auto;
                border: none;
            }
        }
    }
    .txt {
        margin-top: 25px;
        padding-bottom: 35px;
        text-align: center;
        h5 {
            font-size: 20px;
        }
    }
}
</style>
