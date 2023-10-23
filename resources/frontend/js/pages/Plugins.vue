<script setup>
    import { ref } from 'vue'
    import { Get } from '../utils/Fetch'
    import Loader from '../components/Loader.vue'
    import Plugin from '../components/Plugin/Plugin.vue'

    const isLoading = ref(false)
    const plugins = ref([])

    const GetPlugins = () => {
        isLoading.value = true

        Get(`/api/plugins/all`)
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) {
                    isLoading.value = false
                    plugins.value = res.response.content
                }
            })
    }

    GetPlugins()
</script>

<template>
    <div class="plugins">
        <div class="plugins-topbar padding border-bottom">
            <h1 class="medium-header">
                Plugins
            </h1> 
        </div>

        <div class="plugins-body">
            <div class="plugins-loader padding" v-if="isLoading">
                <Loader />
            </div>

            <div class="plugins-loaded padding" v-else>
                <Plugin 
                    v-for="plugin in plugins"
                    :key="plugin"
                    :plugin="plugin" />

                <span class="more-about">More of Plugins will become avaliable soon!</span>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .more-about {
        text-align: center;
        display: block;
        
        margin: 20px 0;
        font-size: 20px;
    }
</style>