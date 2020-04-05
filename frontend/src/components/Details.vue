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
                <div class="item">
                    <i class="fas fa-sign-out-alt"></i>
                    <h5 @click="signout" class="pointer">Sign out</h5>
                </div>
            </div>
            <div class="right">
                <i class="far fa-address-card"></i>
                <h3>MY DETAILS</h3>
                <h4>
                    Feel free to edit any of your details below so your EPOCH
                    account is totally up to date.
                </h4>
                <el-form
                    :model="ruleForm"
                    :rules="rules"
                    ref="ruleForm"
                    label-width="150px"
                    class="demo-ruleForm form"
                    status-icon
                >
                    <el-form-item label="Email :" prop="email">
                        <el-input v-model="ruleForm.email"></el-input>
                    </el-form-item>
                    <el-form-item label="Name :" prop="name">
                        <el-input
                            type="text"
                            v-model="ruleForm.name"
                            autocomplete="off"
                        ></el-input>
                    </el-form-item>
                    <el-form-item label="DATE OF BIRTH :" required>
                        <el-col>
                            <el-form-item prop="birthday">
                                <el-date-picker
                                    type="date"
                                    placeholder="Choose Date"
                                    v-model="ruleForm.birthday"
                                    style="width: 100%;"
                                ></el-date-picker>
                            </el-form-item>
                        </el-col>
                    </el-form-item>
                    <el-form-item label="INTERESTED IN :" prop="sex">
                        <el-radio-group v-model="ruleForm.sex">
                            <el-radio label="F">Womenswear</el-radio>
                            <el-radio label="M">Menswear</el-radio>
                        </el-radio-group>
                    </el-form-item>
                    <el-form-item class="btn">
                        <el-button
                            type="primary"
                            @click="submitForm('ruleForm')"
                            >SAVE</el-button
                        >
                        <el-button @click="resetForm('ruleForm')"
                            >RESET</el-button
                        >
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
    name: "Details",

    data() {
        return {
            uid: this.$store.state.info.id,
            userName: this.$store.state.info.name,
            splitName: "",
            ruleForm: {},
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
                name: [
                    {
                        required: true,
                        message: "Please Enter Your Name",
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
    computed: {
        userInfo() {
            return this.$store.state.info;
        }
    },
    watch: {
        userInfo: {
            handler(aInfo) {
                this.userName = aInfo.name;
                this.splitName = aInfo.name.split("")[0].toUpperCase();
                this.uid = aInfo.id;
                this.getInfo(this.uid);
            },
            immediate: true,
            deep: true
        }
    },
    methods: {
        submitForm(formName) {
            this.$refs[formName].validate(valid => {
                if (valid) {
                    axios
                        .put(`/api/user/changeinfo/${this.uid}`, {
                            email: this.ruleForm.email,
                            name: this.ruleForm.name,
                            birthday: this.ruleForm.birthday,
                            sex: this.ruleForm.sex
                        })
                        .then(res => {
                            if (res.data.result === false) {
                                this.$notify.error({
                                    title: "Sorry !",
                                    message: res.data.msg,
                                    duration: 1800
                                });
                            } else {
                                let token = localStorage.getItem("token");
                                this.$notify({
                                    title: "Success !",
                                    message: "Change Your Profiles",
                                    type: "success",
                                    duration: 1800
                                });
                                this.$store.commit("getUserInfo", token);
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
        getInfo(id) {
            axios
                .get(`/api/user/info/${id}`)
                .then(res => {
                    this.ruleForm = res.data.data[0];
                })
                .catch(() => {
                    this.$notify.error({
                        title: "Something Goes Wrong ...",
                        message: "Please refresh your page again",
                        duration: 6800
                    });
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
                    if (res.data.result === false) {
                        this.$notify.error({
                            title: "抱歉",
                            message: res.data.msg,
                            duration: 1800
                        });
                    } else {
                        this.$message({
                            message: "恭喜您！資料修改成功",
                            type: "success"
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
                .catch(() => {
                    this.$notify.error({
                        title: "Something Goes Wrong ...",
                        message: "Please refresh your page again",
                        duration: 6800
                    });
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
    a {
        color: #2d2d2d;
        text-decoration: none;
    }
    h4 {
        line-height: 110px;
        margin-right: 130px;
        font-size: 48px;
        font-family: "IM Fell Great Primer SC";
        font-weight: 700;
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
        height: 750px;
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
            width: 500px;
            margin: auto;
            margin: 50px;
            padding-top: 30px;
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
