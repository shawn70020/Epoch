<template>
    <div class="body">
        <div class="title">
            <router-link to="/">
                <h4>EPOCH</h4>
            </router-link>
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
                    <div class="item">
                        <i class="far fa-address-card"></i>
                        <h5>My details</h5>
                    </div>
                </router-link>
                <router-link to="/mypassword">
                    <div class="item line">
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
                <div class="item">
                    <i class="fas fa-sign-out-alt"></i>
                    <h5 @click="signout" class="pointer">Sign out</h5>
                </div>
            </div>
            <div class="right">
                <i class="fas fa-lock"></i>
                <h3>CHANGE PASSWORD</h3>
                <h4>
                    Feel free to update your password so your EPOCH account
                    stays secure.
                </h4>
                <el-form
                    :model="ruleForm"
                    status-icon
                    :rules="rules"
                    ref="ruleForm"
                    label-width="150px"
                    class="demo-ruleForm"
                >
                    <el-form-item label="OLD PASSWORD :" prop="old">
                        <el-input
                            type="password"
                            v-model="ruleForm.old"
                            autocomplete="off"
                        ></el-input>
                    </el-form-item>
                    <el-form-item label="NEW PASSWORD :" prop="new">
                        <el-input
                            type="password"
                            v-model="ruleForm.new"
                            autocomplete="off"
                        ></el-input>
                    </el-form-item>
                    <el-form-item label="PASSWORD CHECK :" prop="checkPass">
                        <el-input
                            type="password"
                            v-model="ruleForm.checkPass"
                            autocomplete="off"
                        ></el-input>
                    </el-form-item>
                    <el-form-item
                        ><div class="btn">
                            <el-button
                                type="primary"
                                @click="submitForm('ruleForm')"
                                >CHANGE PASSWORD</el-button
                            >
                        </div>
                    </el-form-item>
                </el-form>
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
    name: "Password",

    data() {
        var validatePass = (rule, value, callback) => {
            if (value === "") {
                callback(new Error("Please Enter Password"));
            } else {
                if (this.ruleForm.check !== "") {
                    this.$refs.ruleForm.validateField("checkPass");
                }
                callback();
            }
        };
        var validatePass2 = (rule, value, callback) => {
            if (value === "") {
                callback(new Error("Please Enter Password Again"));
            } else if (value !== this.ruleForm.new) {
                callback(new Error("Two Paossword Not Match!"));
            } else {
                callback();
            }
        };
        return {
            uid: this.$store.state.info.id,
            userName: this.$store.state.info.name,
            ruleForm: {
                old: "",
                new: "",
                checkPass: ""
            },
            rules: {
                old: [
                    {
                        required: true,
                        message: "Please Enter Your Password",
                        trigger: "blur"
                    }
                ],
                new: [{ validator: validatePass, trigger: "blur" }],
                checkPass: [{ validator: validatePass2, trigger: "blur" }]
            }
        };
    },
    computed: {
        splitName: function() {
            return this.userName.split("")[0].toUpperCase();
        }
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate(valid => {
                if (valid) {
                    axios
                        .put(`/api/user/password/${this.uid}`, {
                            oldpass: this.ruleForm.old,
                            newpass: this.ruleForm.new
                        })
                        .then(res => {
                            if (res.data.result === false) {
                                this.$notify.error({
                                    title: "抱歉",
                                    message: res.data.msg
                                });
                            } else {
                                this.$notify({
                                    title: "Success",
                                    message: "Change Your Password !",
                                    type: "success"
                                });
                                this.ruleForm.old = "";
                                this.ruleForm.new = "";
                                this.ruleForm.checkPass = "";
                            }
                        });
                } else {
                    console.log("error submit!!");
                    return false;
                }
            });
        },
        changePassword() {
            axios
                .put(`/api/user/password/${this.uid}`, {
                    oldpass: this.user.old,
                    newpass: this.user.new
                })
                .then(res => {
                    if (res.data.result === false) {
                        this.$notify.error({
                            title: "抱歉",
                            message: res.data.msg
                        });
                    } else {
                        this.$message({
                            message: "恭喜您！密碼修改成功",
                            type: "success"
                        });
                        this.user.old = "";
                        this.user.new = "";
                    }
                });
        },
        signout() {
            let uid = this.$store.state.info.id;
            axios
                .put("/api/user/logout", {
                    user: uid
                })
                .then(res => {
                    if (res.data.result === true) {
                        localStorage.removeItem("token");
                        localStorage.removeItem("isLogin");
                        this.$router.push("/login");
                    }
                })
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
    a{
        color: #2d2d2d;
        text-decoration: none;
    }
}
.fa-sign-out-alt {
    transform: scalex(-1);
}
.pointer {
    cursor: pointer;
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
            .far,
            .fas {
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
        height: 700px;
        background: #fff;
        margin-left: 20px;
        .fa-lock {
            padding: 20px;
            font-size: 28px;
        }
        h3 {
            font-size: 30px;
            font-weight: bold;
            padding-left: 20px;
        }
        h4 {
            width: 95%;
            font-size: 20px;
            padding-left: 20px;
        }
        form {
            width: 500px;
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
                margin: auto;
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
.line {
    border-left: 4px solid #0f4c81;
}
</style>
