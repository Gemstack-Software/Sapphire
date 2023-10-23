<script setup>
    import { ref, onMounted } from 'vue'
    import bb, { line } from "billboard.js"
    import { CreateDate } from '../utils/date'

    ///////////////////////////////////
    // Props
    ///////////////////////////////////
    const {
        views,
        newVisitors,
        visitors
    } = defineProps({
        views: Array,
        newVisitors: Array,
        visitors: Array
    })

    ///////////////////////////////////
    // Generating dates 30 days before
    ///////////////////////////////////
    const dates = []
    const dayTime = 1000 * 60 * 60 * 24

    for(let i = 0; i < 30; i++) 
        dates.push(CreateDate(new Date(Date.now() - dayTime * i)))

    ///////////////////////////////////
    // Chart generating
    ///////////////////////////////////
    onMounted(() => {
        const chart = bb.generate({
            bindto: "#chart",
            data: {
                json: {
                    'Views': views,
                    'New visitors': newVisitors,
                    'Visitors': visitors,
                    'x': dates.reverse()
                },
                type: line(),
                x: "x",
                xFormat: "%d-%m-%Y"
            },
            background: {
                color: "rgb(16 16 17)"
            },
            color: {
                pattern: [
                    "rgb(250, 250, 67)",
                    "#009977",
                    "#0099ff",
                ]
            },
            padding: true,
            axis: {
                x: {
                    type: "timeseries",
                    tick: {
                        fit: true,
                        multiline: false,
                        autorotate: false,
                        rotate: 75,
                        culling: false,
                        count: 30,
                        format: "%d-%m-%Y"
                    },
                    clipPath: false
                }
            }
        })

        chart.resize({ height: 500 })
    })
</script>

<template>
    <div id="chart"></div>
</template>

<style lang="scss">
    #chart {
        tspan, text {
            color: white!important;
            fill: white!important;  
        }

        .bb-chart-lines {
            fill: none;
        }

        .domain {
            fill: none;
        }
    }
</style>