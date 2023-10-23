<script setup> 
    import { Post } from '../../utils/Fetch'
    import { Notify, NotifyRed } from '../../utils/Notifications'
    import SelectChoiceInput from '../Inputs/SelectChoiceInput.vue'
    import MultipleChoiceInput from '../Inputs/MultipleChoiceInput.vue'

    const { collection } = defineProps({
        collection: Object
    })

    const ChangeAllowedProperties = (newObject) => {
        Post('/api/collections/change-allowed-properties', {
            properties: newObject.values.value,
            collection_id: collection.info.id
        })
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) collection.schema.info = newObject
                else {
                    Notify(res.response.message, NotifyRed, 'fas fa-exclamation-triangle')
                
                    // We need to reset this property because it failed to change it
                    collection.schema.info[newObject.value] = !collection.schema.info[newObject.value]
                }
            })
    }
</script>

<template>
    <div class="form">
        <div class="flex">
            <div class="data-group">
                <MultipleChoiceInput
                    :label="'Collect properties'"
                    :choices="[ 'id', 'uuid', 'name', 'created_at', 'created_by', 'updated_at', 'updated_by' ]"
                    :values="collection.schema.info"
                    @onChange="ChangeAllowedProperties"
                />
                
                <span 
                    class="warning" 
                    v-if="collection.contents.length > 0">
                    <em class="fas fa-exclamation-triangle danger-color"></em> Warning: Collect properties option can be only changed in empty
                </span>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .flex .data-group {
        margin-right: 32px;

        .warning {
            margin-top: 16px;
            display: block;
        }
    }
</style>