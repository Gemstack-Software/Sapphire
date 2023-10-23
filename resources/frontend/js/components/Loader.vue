<template>
    <div class="loader-root">
        <div class="loader-spinner"></div>
    </div>
</template>

<style lang="scss" scoped>
    @keyframes spinner {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

    .loader-root {
        display: flex;
        justify-content: center;
        align-items: center;

        .loader-spinner {
            width: 32px;
            height: 32px;

            border-radius: 50%;
            border: 3px solid #fff1;
            border-bottom-color: $theme;

            animation: spinner .33s infinite linear;
        }
    }
</style>