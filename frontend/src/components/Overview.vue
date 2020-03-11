<template>
    <div class="wrap">
        <div class="slogan">
            <h5>WELCOME TO</h5>
            <h5>YOUR ACCOUNT</h5>
        </div>
    </div>
</template>
<style lang="scss" scoped>
.wrap {
    width: 620px;
    height: 860px;
    background-image: url(./assets/image/camera.jpg);
    background-repeat: no-repeat;
    background-size: cover;
    position: relative;
    .slogan{
        position: absolute;
        color: #2d2d2d;
        top: 70px;
        left: 40px;
        h5{
            border: 1px solid #fff;
            border-radius: 10px;
            font-size: 36px;
            font-weight: bold;
            padding: 12px;
        }
    }
}
</style>
