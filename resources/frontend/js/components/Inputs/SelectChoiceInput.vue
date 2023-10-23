<script setup>
    import { ref } from 'vue'

    const { label, choices, value } = defineProps({
        label: String,
        choices: Array,
        value: String
    })

    const $emit = defineEmits([
        "onChange"
    ])

    const selection = ref(value)
    const Select = (_value) => {
        selection.value = _value
        $emit("onChange", _value)
    }
</script>

<template>
    <div class="select-choice__root form">
        <label class="form-label">{{ label }}</label>

        <div class="select-choice__container">
            <button 
                v-for="choice in choices"
                :key="choice"
                :class="`select-choice__button ${choice === selection ? 'active' : ''}`"
                @click="Select(choice)">
                {{ choice }}
            </button>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .select-choice__root {
        .select-choice__container {

            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-top: 24px;

            .select-choice__button {
                padding: 4px 8px;
                
                border: 0;
                margin: 0;
                outline: 0;

                cursor: pointer;
                transition: .225s;

                background: $background-color-lighten;
                color: $font-color;

                &:hover {
                    background: rgba($theme, 0.2);
                    color: $theme;
                }

                &.active {
                    background: rgba($theme, 0.15);
                    color: $theme;
                }
            }

        }
    }
</style>