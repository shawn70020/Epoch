<template>
    <div class="wrap">
        <chart ref="chart1" :options="orgOptions" :auto-resize="true"></chart>
    </div>
</template>
<script>
export default {
    name: "Dashboard",
    data() {
        return {
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
                left: 10,
                data: [
                    "直接访问",
                    "邮件营销",
                    "联盟广告",
                    "视频广告",
                    "搜索引擎"
                ]
            },
            series: [
                {
                    name: "访问来源",
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
                        { value: 335, name: "直接访问" },
                        { value: 310, name: "邮件营销" },
                        { value: 234, name: "联盟广告" },
                        { value: 135, name: "视频广告" },
                        { value: 1548, name: "搜索引擎" }
                    ]
                }
            ]
        };
    }
};
</script>
<style lang="scss" scoped>
// .wrap {
//     position: relative;
//     background: linear-gradient(90deg, #bdc3c7, #2c3e50);
//     h2 {
//         color: #fff;
//         line-height: 100vh;
//         font-family: "Roboto Mono";
//         position: absolute;
//         right: 10%;
//     }
// }
</style>
