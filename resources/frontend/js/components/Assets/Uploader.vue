<script setup>
    import { ref } from 'vue'
    import { FormDataFetch } from '../../utils/Fetch'
    import { Notify, NotifyRed } from '../../utils/Notifications'   

    const $emit = defineEmits([ "Upload" ])

    const Change = (e) => {
        const { files } = e.target
        if(files.length === 0) return

        const formData = new FormData()
        formData.append('file', files[0])

        FormDataFetch('/api/assets/upload', formData)
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) $emit("Upload")
                else Notify(res.response.message, NotifyRed, 'fas fa-exclamation-triangle')
            })
    }
</script> 

<template>
    <div class="assets-uploader">
        <label 
            for="asset-input" 
            class="assets-uploader__label">

            <input @change="Change" type="file" id="asset-input" class="" accept=".pdf,.jpg,.jpeg,.png">
            <span class="assets-header">Click here to upload asset</span>
        
        </label>
    </div>
</template>

<style lang="scss" scoped>
    .assets-uploader {
        display: flex;
        justify-content: center;

        .assets-uploader__label {
            width: 800px;
            height: 140px;

            border: 10px dashed;
            color: #888;

            text-align: center;

            transition: .225s;
            display: block;
            cursor: pointer;
            position: relative;

            input {
                width: 100%;
                height: 100%;
                visibility: hidden;
            }

            .assets-header {
                font-size: 32px;
                pointer-events: none;

                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }

            &:hover {
                color: #999;
            }

            &:focus, &:active {
                color: $theme;
            }
        }
    }
</style>