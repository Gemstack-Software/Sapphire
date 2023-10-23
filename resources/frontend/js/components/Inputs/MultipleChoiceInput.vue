<script setup>
    import { ref } from 'vue'

    const { label, choices, values } = defineProps({
        label: String,
        choices: Array,
        values: Object
    })

    const $emit = defineEmits([
        "onChange"
    ])

    const all = ref(values)
    const Toggle = (_value) => {
        // Toggles option
        all.value[_value] = !all.value[_value]

        $emit("onChange", { values: all, value: _value })
    }
</script>

<template>
    <div class="multiple-choice__root form">
        <label class="form-label">{{ label }}</label>

        <div class="multiple-choice__container">
            <button 
                v-for="choice in choices"
                :key="choice"
                :class="`multiple-choice__button ${all[choice] ? 'active' : ''}`"
                @click="Toggle(choice)">
                {{ choice }}
            </button>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .multiple-choice__root {
        .multiple-choice__container {

            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-top: 24px;

            .multiple-choice__button {
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