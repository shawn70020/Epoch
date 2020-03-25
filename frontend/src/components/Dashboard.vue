<template>
    <div class="body">
        <div class="top">
            <div class="info">
                <h4>後台總覽</h4>
            </div>
            <div class="today">
                <h4>日期</h4>
                <i class="fas fa-angle-double-right"></i>
                <h4>{{ moment().format("LL") }}</h4>
            </div>
        </div>
        <div class="main-dash">
            <div class="box">
                <div class="left">
                    <div class="title">
                        <h5>今日訂單</h5>
                        <div class="badge">
                            <el-badge :value="12" class="item">
                                <el-button size="small">處理中</el-button>
                            </el-badge>
                            <el-badge :value="3" class="item" type="warning">
                                <el-button size="small">已出貨</el-button>
                            </el-badge>
                            <el-badge :value="1" class="item" type="primary">
                                <el-button size="small">完成</el-button>
                            </el-badge>
                            <el-badge :value="2" class="item" type="info">
                                <el-button size="small">取消</el-button>
                            </el-badge>
                        </div>
                    </div>
                    <div class="chart">
                        <chart
                            ref="chart1"
                            :options="orgOptions"
                            :auto-resize="true"
                        ></chart>
                    </div>
                </div>
                <div class="right">
                    <h5>公司名稱：EPOCH</h5>
                    <h5>總會員數 ： 1000 人</h5>
                    <h5>總商品數 ： 1000 項</h5>
                    <h5>總營業額 ： 100000</h5>
                    <h5>成立時間 ： 2020/01/01</h5>
                </div>
            </div>
            <div class="bottom">
                <div class="order-box">
                    <h5>上線中人數</h5>
                    <div class="info">
                        <div class="icon icon-member">
                            <i class="fas fa-user-clock"></i>
                        </div>
                        <h4>100</h4>
                    </div>
                </div>
                <div class="member-box">
                    <h5>目前訂單量</h5>
                    <div class="info">
                        <div class="icon icon-order">
                            <i class="fas fa-calendar-week"></i>
                        </div>
                        <h4>100</h4>
                    </div>
                </div>
                <div class="product-box">
                    <h5>目前營業額</h5>
                    <div class="info">
                        <div class="icon icon-cash">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <h4>100</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
var moment = require("moment");
moment.locale("zh-tw");
export default {
    name: "Dashboard",
    data() {
        return {
            moment: moment,
            orgOptions: {}
        };
    },
    mounted() {
        this.orgOptions = {
            tooltip: {
                trigger: "item",
                formatter: "{a} <br/>{b}: {c} ({d}%)"
            },
            legend: {
                orient: "vertical",
                left: 35,
                data: ["處理中", "已出貨", "完成", "取消"]
            },
            series: [
                {
                    name: "今日訂單",
                    type: "pie",
                    radius: ["50%", "70%"],
                    avoidLabelOverlap: false,
                    label: {
                        normal: {
                            show: false,
                            position: "center"
                        },
                        emphasis: {
                            show: true,
                            textStyle: {
                                fontSize: "30",
                                fontWeight: "bold"
                            }
                        }
                    },
                    labelLine: {
                        normal: {
                            show: false
                        }
                    },
                    data: [
                        { value: 12, name: "處理中" },
                        { value: 3, name: "已出貨" },
                        { value: 1, name: "完成" },
                        { value: 2, name: "取消" }
                    ]
                }
            ]
        };
    }
};
</script>
<style lang="scss" scoped>
$color: #2d2d2d;
.body {
    font-family: "Noto Serif TC", serif;
    font-weight: 400;
    background: #eee;
}
.top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    height: 85px;
    background: #999;
    .info {
        color: $color;
        h4 {
            margin-left: 30px;
        }
    }
    .today {
        display: flex;
        margin-right: 10px;
        h4 {
            margin-left: 15px;
            font-size: 24px;
        }
        .fa-angle-double-right {
            margin-top: 8px;
            margin-left: 15px;
        }
    }
}
.main-dash {
    width: 100%;
    .box {
        display: flex;
        justify-content: center;
        width: 100%;
        .left,
        .right {
            width: 40%;
            border-radius: 10px;
            margin: 40px;
            background: #fff;
        }
        .left {
            .title {
                padding-top: 15px;
                display: flex;
                justify-content: space-between;
                h5 {
                    margin-left: 15px;
                }
                .badge {
                    margin-right: 15px;
                    .item + .item {
                        margin-left: 25px;
                    }
                }
            }
            .chart {
                margin: auto;
                margin-left: 30px;
                margin-top: 30px;
            }
        }
    }
    .bottom {
        display: flex;
        justify-content: space-around;
        width: 100%;
        .order-box,
        .member-box,
        .product-box {
            width: 28%;
            height: 300px;
            background: #fff;
            border-radius: 10px;
            h5 {
                margin: 15px;
                // &::after{
                //     content: '';
                //     display: block;
                //     height: 1px;
                //     width: 92%;
                //     margin: auto;
                //     margin-top: 20px;
                //     background: #2d2d2d;
                // }
            }
            .info {
                margin: auto;
                text-align: center;
                margin-top: 50px;
                .icon {
                    width: 65px;
                    height: 65px;
                    border-radius: 50%;
                    text-align: center;
                    margin: auto;
                    .fas {
                        line-height: 65px;
                        font-size: 30px;
                        color: #fff;
                    }
                }
                .icon-member {
                    background: linear-gradient(to right, #11998e, #38ef7d);
                }
                .icon-order {
                    background: linear-gradient(to right, #396afc, #2948ff);
                }
                .icon-cash {
                    background: linear-gradient(to right, #f7f8f8, #acbb78);
                }
                h4 {
                    margin-top: 30px;
                    font-weight: bold;
                }
            }
        }
    }
}
</style>
