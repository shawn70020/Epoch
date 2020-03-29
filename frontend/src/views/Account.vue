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
                        <h5>{{ spiltName }}</h5>
                    </div>
                    <div class="name">
                        <h5>Hi,</h5>
                        <h5>{{ userName }}</h5>
                    </div>
                </div>
                <router-link to="/account">
                    <div class="item leftline">
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
                <div class="slogan">
                    <h5>WELCOME TO</h5>
                    <h5>YOUR ACCOUNT</h5>
                </div>
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
    name: "Account",
    data() {
        return {
            userName: this.$store.state.info.name,
            spiltName: ""
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
                this.spiltName = aInfo.name.split("")[0].toUpperCase();
                this.uid = aInfo.id;
                this.getMyOrders(this.uid);
            },
            immediate: true
        }
    },
    methods: {
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
                .catch(err => {
                    console.log(err);
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
    a {
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
        a {
            color: #2d2d2d;
        }
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
        margin-left: 20px;
        width: 620px;
        height: 820px;
        background-image: url(../assets/image/camera.jpg);
        background-repeat: no-repeat;
        background-size: cover;
        position: relative;
        .slogan {
            position: absolute;
            color: #fff;
            top: 70px;
            left: 40px;
            h5 {
                border: 1px solid #fff;
                border-radius: 10px;
                font-size: 36px;
                font-weight: bold;
                padding: 12px;
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
.leftline {
    border-left: 4px solid #0f4c81;
}
</style>
