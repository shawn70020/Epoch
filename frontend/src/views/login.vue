<template>
    <div class="wrap">
        <div class="title">
            <h2>VueStore</h2>
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
                <form class="form-signin" @submit.prevent="login">
                    <label for="inputEmail">EMAIL ADDRESS:</label>
                    <input
                        type="email"
                        id="inputEmail"
                        class="form-control"
                        v-model="user.email"
                    />
                    <label for="inputPassword">PASSWORD:</label>
                    <div class="password-group">
                        <input
                            :type="type"
                            id="inputPassword"
                            class="form-control"
                            v-model="user.password"
                        />
                        <button @click.prevent="showPassword">
                            {{ btnText }}
                        </button>
                    </div>
                    <button class="btn btn-sm btn-dark btn-block" type="submit">
                        SIGN IN
                    </button>
                </form>
            </div>
            <div class="txt">
                <h5>WELCOME</h5>
                <h5>TO</h5>
                <h5>VueSTORE</h5>
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
            user: {
                email: "",
                password: ""
            }
        };
    },
    methods: {
        login() {
            const vm = this;
            vm.isLoading = true;
            axios
                .post("/api/login", {
                    email: vm.user.email,
                    password: vm.user.password
                })
                .then(res => {
                    vm.isLoading = false;
                    if (res.data.result === true) {
                        localStorage.setItem("token", res.data.token);
                        this.$store.state.isLogin = true;
                        if (res.data.level === "member") {
                            vm.$router.push("/men");
                        } else {
                            vm.$router.push("/admin");
                        }
                    } else {
                        vm.showError = 1;
                    }
                })
                .catch(err => {
                    console.log(err);
                });
        },
        showPassword() {
            if(this.type === 'password'){
                this.type = 'text';
                this.btnText = 'HIDE'
            } else {
                this.type = 'password';
                this.btnText = 'SHOW'
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
