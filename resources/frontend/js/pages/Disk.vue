<script setup>
    import { onMounted, ref } from 'vue'
    import { Get } from '../utils/Fetch'
    import Loader from '../components/Loader.vue'

    /////////////////////////////////////////
    // Disk
    /////////////////////////////////////////
    const isLoading = ref(false)
    const disk = ref(null)

    const GetDisk = () => {
        isLoading.value = true

        Get('/api/disk/data')
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) {
                    disk.value = res.response.content
                    isLoading.value = false
                }
            })
    }

    onMounted(() => GetDisk())

    /////////////////////////////////////////
    // Format space
    /////////////////////////////////////////
    const FormatSpace = (space) => {
        const kb = space / 1024;
        const mb = kb / 1024;

        if(mb >= 1) return `${mb.toFixed(2)} MB`;
        if(kb >= 1) return `${kb.toFixed(2)} KB`;

        return `${space} B`;
    }

    /////////////////////////////////////////
    // Scrolling by buttons
    /////////////////////////////////////////
    const scroll = ref(0)

    const scrollBy = (index, round = true) => {
        scroll.value += index

        if(scroll.value < 0) scroll.value = 0;
        if(scroll.value > 3) scroll.value = 3;

        if(round) scroll.value = Math.round(scroll.value)
    }

    /////////////////////////////////////////
    // Scrolling by mouse
    /////////////////////////////////////////
    const isMouseDown = ref(false)

    const mouseDown = () => isMouseDown.value = true
    const mouseUp = () => isMouseDown.value = false
    const mouseMove = (e) => {
        if(!isMouseDown.value) return;

        scrollBy(-e.movementX / 500, false)
    }
</script>

<template>
    <div class="disk">
        <div class="disk-topbar padding border-bottom">
            <h1 class="medium-header">
                <em class="fas fa-memory"></em> Disk management
            </h1> 
        </div>

        <div class="disk-body">
            <div class="disk-loader" v-if="isLoading">
                <Loader />
            </div>

            <div class="disk-loaded" v-else>
                <div class="disk-item__buttons">
                    <button class="disk-item__button" @click="scrollBy(-1)"><em class="fas fa-arrow-left-long"></em></button>
                    <button class="disk-item__button" @click="scrollBy(1)"><em class="fas fa-arrow-right-long"></em></button>
                </div>

                <div :class="`disk-item-container__outer ${isMouseDown ? 'grab' : ''}`">
                    <div class="disk-item-container" :style="{ 'margin-left': (scroll * -33.3) + '%' }" @mousedown="mouseDown" @mouseup="mouseUp" @mousemove="mouseMove">
                        <div class="disk-item">
                            <h1 class="header">Components</h1>
                            <h3 class="quick-header">{{ FormatSpace(disk?.components) }}</h3>
                        </div>

                        <div class="disk-item">
                            <h1 class="header">Collections</h1>
                            <h3 class="quick-header">{{ FormatSpace(disk?.collections) }}</h3>
                        </div>

                        <div class="disk-item">
                            <h1 class="header">Layouts</h1>
                            <h3 class="quick-header">{{ FormatSpace(disk?.layouts) }}</h3>
                        </div>

                        <div class="disk-item">
                            <h1 class="header">Plugins</h1>
                            <h3 class="quick-header">{{ FormatSpace(disk?.plugins) }}</h3>
                        </div>

                        <div class="disk-item">
                            <h1 class="header">Styles</h1>
                            <h3 class="quick-header">{{ FormatSpace(disk?.styles) }}</h3>
                        </div>

                        <div class="disk-item">
                            <h1 class="header">Node Modules</h1>
                            <h3 class="quick-header">{{ FormatSpace(disk?.node_modules) }}</h3>
                        </div>
                    </div>
                </div>

                <div class="disk-item__buttons border-bottom">
                    <button class="disk-item__button" @click="scrollBy(-1)"><em class="fas fa-arrow-left-long"></em></button>
                    <button class="disk-item__button" @click="scrollBy(1)"><em class="fas fa-arrow-right-long"></em></button>
                </div>

                <!-- Actions -->

                <div class="trash-actions padding">
                    <button class="button danger">
                        <em class="fas fa-trash"></em> <span>Clear trash</span> ({{ FormatSpace(disk?.trash) }})
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .disk {
        .disk-topbar {
            .medium-header {
                em {
                    margin-right: 12px;
                }
            }
        }

        .disk-body {
            height: calc(100vh - 131px);
            overflow-y: auto; 

            .disk-loader {
                margin-top: 32px;
            }

            .disk-loaded {
                height: 100%;
                
                .disk-item__buttons {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;

                    .disk-item__button {
                        width: 50%;
                        height: 100%;
                        padding: 8px;

                        border: 0;
                        outline: 0;
                        background: $background-color-lighten;
                        color: $font-color;

                        font-size: 20px;
                        cursor: pointer;
                        transition: .225s;

                        &:hover {
                            background: $theme;
                        }
                    }
                }

                .disk-item-container__outer {
                    overflow-x: hidden;
                    overflow-y: hidden;
                    height: 400px;

                    cursor: grab;

                    &.grab {
                        cursor: grabbing;
                    }
                
                    .disk-item-container {
                        display: flex;
                        justify-content: flex-start;
                        align-items: flex-start;

                        width: 200%;
                        height: 400px;

                        transition: .225s;

                        .disk-item {
                            width: 33.3%;
                            height: 400px;

                            border-bottom: 1px solid $background-color-lighten;
                            border-right: 1px solid $background-color-lighten;

                            display: flex;
                            justify-content: center;
                            align-items: center;
                            flex-direction: column;

                            transition: .225s;

                            .quick-header {
                                margin-top: 24px;
                                font-size: 20px;
                            }

                            &:hover {
                                background: $theme;

                                .quick-header {
                                    color: $background-color;
                                }
                            }
                        }
                    }
                }

                .trash-actions {
                    display: flex;
                    justify-content: flex-start;
                    align-items: center;

                    .button {
                        margin-right: 16px;

                        em {
                            margin-right: 4px;
                        }

                        span {
                            margin: 0 4px;
                        }
                    }
                }
            }
        }
    }
</style>