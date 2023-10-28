<script setup>
    import { Post } from '../../utils/Fetch'
    import { ref } from 'vue'

    const { Types, Selected } = defineProps({
        Types: Array,
        Selected: Array
    })

    const allArrays = ref([ ...Selected ])
    const $emit = defineEmits([ "ArraySelect" ])

    const modelArray = (value, key) => {
        allArrays.value[key] = value
        $emit("ArraySelect", allArrays.value)
    }

    const deleteItem = (key) => {
        allArrays.value.splice(key, 1)
        $emit("ArraySelect", allArrays.value)
    } 
</script>

<template>
    <div class="mixed-array__selector">
        <div class="mixed-array__topbar">
            <button class="button-small" @click="allArrays.push('')">
                <em class="fas fa-plus"></em>
            </button>
        </div>

        <div class="mixed-array__contents form">
            <div class="mixed-array__content" v-for="(item, key) in allArrays" :key="item">
                <input type="text" class="form-input" @change="(e) => modelArray(e.target.value, key)" :value="allArrays[key]">

                <button class="button-small" @click="deleteItem(key)">
                    <em class="fas fa-trash"></em>
                </button>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .mixed-array__selector {
        .mixed-array__topbar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .mixed-array__contents {
            .mixed-array__content {
                display: flex;
                justify-content: space-between;
                align-items: center;

                .form-input {
                    margin-top: 0px;
                }

                .button-small {
                    display: block;
                    margin: 0 8px;
                }
            }
        }
    }
</style>