<template>
    <transition name="modal-slide">
        <div
            v-if="isOpen"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
        >
            <div
                class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg dark:bg-[#161615] dark:text-[#EDEDEC]"
            >
                <header class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-medium">{{ title }}</h2>
                    <button
                        @click="close"
                        class="text-[#706f6c] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                    >
                        ✕
                    </button>
                </header>
                <div class="mb-4">
                    <slot>
                    </slot>
                </div>
            </div>
        </div>
    </transition>
</template>

<script setup lang="ts">
import { defineProps, defineEmits } from 'vue';

defineProps({
    isOpen: {
        type: Boolean,
        required: true,
    },
    title: {
        type: String,
        default: 'Modal Title',
    },
});

const emit = defineEmits(['close']);

const close = () => emit('close');
</script>

<style scoped>
.modal-slide-enter-active,
.modal-slide-leave-active {
    transition: opacity 0.7s ease;
}
.modal-slide-enter-from,
.modal-slide-leave-to {
    opacity: 0;
}
.modal-slide-enter-to,
.modal-slide-leave-from {
    opacity: 1;
}
</style>
