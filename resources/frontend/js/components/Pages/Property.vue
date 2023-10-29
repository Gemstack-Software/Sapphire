<script setup>
    import { Get, Post } from '../../utils/Fetch'

    const { property } = defineProps({
        property: Object
    })

    const $emit = defineEmits([ "OnUpdate" ])

    /////////////////////////////////////////
    // Updates properties
    /////////////////////////////////////////
    const DeleteProperty = () => {
        Get('/api/pages/delete-property/' + property.id)
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) $emit("OnUpdate")
            })
    }

    const UpdateProperty = () => {
        Post('/api/pages/save-property', {
            id: property.id,
            value: property.value
        })
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) $emit("OnUpdate")
            })
    }
</script>

<template>
    <div class="property">
        <div class="property__left">
            {{ property.name }}
        </div>

        <div class="property__right">
            <input type="text" class="form-input" v-model="property.value" placeholder="Value" @change="UpdateProperty">

            <button class="button-small" @click="DeleteProperty">
                <em class="fas fa-trash"></em>
            </button>
        </div>   
    </div>
</template>

<style lang="scss" scoped>
    .property {
        display: flex;
        justify-content: space-between;
        align-items: center;
        
        background: #0003;
        padding: 8px 16px;

        &:nth-child(2n) {
            background: #0001;
        }

        .property__right {
            display: flex;
            justify-content: space-between;
            align-items: center;

            .form-input {
                margin: 0px;
                width: 300px;
                border-bottom: 0px;
            }

            .button-small {
                margin: 0 16px;
            }
        }
    }
</style>