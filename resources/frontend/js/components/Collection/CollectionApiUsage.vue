<script setup>
    import { CreateCodeUsageBoilerplate } from '../../utils/Code'

    const { collection } = defineProps({
        collection: Object
    })

    const boilerplate = CreateCodeUsageBoilerplate(collection)
</script>

<template>
    <div class="api-usage">
       
        <!-- <div class="api-usage-container border-bottom padding">
             <h3 class="subheader">Via API</h3>

            <h4 class="subheader">Fetch records</h4>
            <div class="code">
                <div class="code-orange">POST</div>

                <div class="padding">
                    http://localhost:2000/api/records/fetch/{{ collection.info.id }}
                </div>
            </div>

            <h4 class="subheader">Add records</h4>
            <div class="code">
                <div class="code-orange">POST</div>

                <div class="padding">
                    http://localhost:2000/api/records/insert/{{ collection.info.id }}
                </div>
            </div>

            <h4 class="subheader">Delete records</h4>
            <div class="code">
                <div class="code-danger">DELETE</div>

                <div class="padding">
                    http://localhost:2000/api/records/delete/{{ collection.info.id }}
                </div>
            </div>

            <a class="link" href="#">See how to create request and modify it to obtain collection data which you want</a>
        </div>-->

        <div class="code-usage-container padding">
            <h3 class="subheader">Via Code</h3>

            <textarea 
                class="code-textarea" 
                v-html="boilerplate" 
                spellcheck="false" 
                disabled></textarea>

            <a class="link" href="#">See how to obtain data from collections using Sapphire</a>
        </div>

    </div>
</template>

<style lang="scss" scoped>
    .link {
        margin-top: 16px;
        display: block;
    }

    h4.subheader {
        margin-top: 16px;
        margin-bottom: -8px!important;
        display: block;
    }
</style>