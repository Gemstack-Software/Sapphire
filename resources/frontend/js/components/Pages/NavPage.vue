<script setup>
    import { ref, onMounted } from 'vue'
    import { GetPagesByParentId } from '../../utils/Pages'
    import NavPage from './NavPage.vue'

    const { page, index, pages } = defineProps({
        page: Object,
        index: Number,
        pages: Array
    })

    const isOpen = ref(false)

    const ToggleOpen = () => {
        isOpen.value = !isOpen.value
        window.pagesNavMenu[page.id] = isOpen.value
    }

    // Check nav state
    onMounted(() => {
        isOpen.value = window.pagesNavMenu[page.id]
    })

    // Add new pages
    const $emit = defineEmits([ "AddSubpage", "EditPage" ])

    const AddSubpage = () => {
        $emit("AddSubpage", page.id) 
        ToggleOpen()
    }
    const OnAddSubpage = (id) => $emit("AddSubpage", id)

    // Edit page
    const EditPage = () => {
        $emit("EditPage", page.id)
        ToggleOpen()
    }
    const OnEditPage = (id) => $emit("EditPage", id)
</script>

<template>
    <div :class="`nav-page ${isOpen ? 'open' : ''}`">
        <div class="nav-page__topbar top-flex" @click="ToggleOpen" :style="{ 'padding-left': (24 + (index) * 8) + 'px' }">
            <span :class="`nav-page__title text-overflow`" data-aos="flip-up" :style="{ color: isOpen ? '#0099ff' : 'inherit' }" @click="EditPage">
                {{ page.name }}
            </span>

            <div class="nav-page__buttons">
                <button class="button-small" @click="AddSubpage">
                    <em class="fas fa-plus"></em>
                </button>
                
                <button class="button-small">
                    <em :class="{ 'fas': true, 'fa-chevron-right': !isOpen, 'fa-chevron-down': isOpen }"></em>
                </button>
            </div>
        </div>

        <div class="nav-page__content" v-if="isOpen">
            <div class="nav-page__subpages">
                <NavPage 
                    v-for="_page in GetPagesByParentId(pages, page.id)"
                    :key="_page"
                    :page="_page"
                    :index="index+1"
                    :pages="pages"
                    @AddSubpage="OnAddSubpage"
                    @EditPage="OnEditPage"
                />
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .nav-page {
        width: 100%;
        border-bottom: 1px solid transparent;

        cursor: pointer;
        transition: .225s;

        .nav-page__topbar {
            padding: 8px;
            padding-right: 32px;

            font-size: 20px;

            .nav-page__buttons {
                width: 96px;
                display: flex;
                justify-content: flex-end;
                align-items: center;

                .button-small {
                    width: 32px;
                    text-align: right;
                }
            }
        }

        .nav-page__content {
            margin-top: 0px;
        }

        &:hover, &.open {
            border-bottom: 1px solid rgba(#000, 0.1); 
            background: rgba(#000, 0.05);

            .nav-page__title.open {
                color: $theme;
            }
        }
    }
</style>