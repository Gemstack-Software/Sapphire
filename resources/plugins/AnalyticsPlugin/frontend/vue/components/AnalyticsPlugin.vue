<script setup>
    import { ref, getCurrentInstance } from 'vue'
    import InfoBox from './InfoBox'
    import AnalyticsChart from './AnalyticsChart'

    ///////////////////////////////////
    // Props
    ///////////////////////////////////
    const { 
        weekly_views,
        weekly_new_visitors,
        weekly_visitors,
        month_views,
        month_new_visitors,
        month_visitors
    } = defineProps({
        weekly_views: Number,
        weekly_new_visitors: Number,
        weekly_visitors: Number,
        month_views: Array,
        month_new_visitors: Array,
        month_visitors: Array
    }) 
</script>

<template>
    <div class="analytics-container">   
        <div class="analytics-topbar padding border-bottom">  
            <h1 class="analytics-header">Sapphire Analytics</h1>
        </div>

        <div class="analytics-tiles-container padding border-bottom">
            <InfoBox
                title="Views per Visitors (per week)"
                icon="fa-solid fa-eye"
                color="rgb(250, 250, 67)"
                :value="weekly_views / weekly_visitors"
                placeholder="See more"
            ></InfoBox>

            <InfoBox
                title="New visitors per Visitors (per week)"
                icon="fa-solid fa-user"
                color="#009977"
                :value="weekly_new_visitors != 0 ? (weekly_visitors / weekly_new_visitors) : 0"
                placeholder="See more"
            ></InfoBox>
        </div>

        <div class="chart padding border-bottom">
            <AnalyticsChart
                :views="month_views"
                :newVisitors="month_new_visitors"
                :visitors="month_visitors"
            />
        </div>
    </div>
</template>

<style lang="scss">
    .analytics-container {
        height: calc(100vh - 50px);
        overflow-x: hidden;
        overflow-y: auto;
    }
</style>