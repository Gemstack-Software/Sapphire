<script setup>
    import { ref, onMounted } from 'vue'
    import { Post } from '../../utils/Fetch'
    import { Notify, NotifyRed } from '../../utils/Notifications'   
    import { v4 } from 'uuid' 

    const $emit = defineEmits([ "Update" ])

    const { asset } = defineProps({
        asset: Object
    })

    const isChangingLabel = ref(false)

    const SaveLabel = () => {
        Post('/api/assets/rename', {
            asset_id: asset.id,
            label: asset.label
        })
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) isChangingLabel.value = false
                else Notify(res.response.message, NotifyRed, 'fas fa-exclamation-triangle')

                $emit("Update")
            })
    }

    const DeleteAsset = () => {
        Post('/api/assets/delete', {
            asset_id: asset.id
        })
            .then(res => res.json())
            .then(res => {
                console.log(res)

                $emit("Update")
            })
    }

    // Small vanilla javascript DOM Manipulation
    const uuid = v4()
    const maxWidth = ref(0)

    onMounted(() => {
        const image = document.querySelector(`#asset-${uuid}`)

        image.addEventListener('load', () => {
            const imageBoundings = image.getBoundingClientRect()

            maxWidth.value = imageBoundings.width
        })
    })
</script>

<template>
    <div class="asset">
        <button class="button-small delete-asset-btn danger" @click="DeleteAsset">
            <em class="fas fa-times"></em>
        </button>

        <a :href="asset.filename" target="_blank" data-aos="zoom-in">
            <img class="asset-image" :src="asset.filename" :alt="asset.label" :id="`asset-${uuid}`">
        </a>
       
        <div class="asset-bottom" data-aos="flip-up">
            <span 
                class="asset-bottom__label" 
                :style="{ width: maxWidth + 'px' }"
                v-if="!isChangingLabel" 
                @click="isChangingLabel = !isChangingLabel">
                {{ asset.label }}
            </span>

            <div class="asset-bottom__change-label form flex" v-else>
                <input class="form-input" type="text" v-model="asset.label">

                <button class="button-small" @click="isChangingLabel = false">
                    <em class="fas fa-times"></em>
                </button>

                <button class="button-small" @click="SaveLabel">
                    <em class="fas fa-check"></em>
                </button>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .asset {
        margin-right: 16px;
        margin-bottom: 16px;

        position: relative;

        .delete-asset-btn {
            position: absolute;
            top: 8px;
            right: 8px;

            text-shadow: 1px 1px #000, -1px -1px #000, -1px 1px #000, 1px -1px #000;
        }

        .asset-image {
            height: 100%;
            max-height: 256px;
        }

        .asset-bottom {
            .asset-bottom__label {
                display: block;
                text-align: center;

                padding: 8px;
                font-size: 20px;

                width: 100%;
                display: block;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .form-input {
                width: 100%;
                margin-top: 0;
            }

            .button-small {
                margin: 0 6px;
            }
        }
    }
</style>