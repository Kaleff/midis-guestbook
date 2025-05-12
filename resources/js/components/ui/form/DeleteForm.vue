<template>
    <form
        @submit.prevent="submitForm"
    >
        <!-- Success Alert -->
        <div
            v-if="showSuccess"
            class="mb-6 rounded-sm border border-[#9be679] bg-[#f2ffed] px-4 py-3 text-sm text-[#2e7b15] dark:border-[#3e8728] dark:bg-[#071f04] dark:text-[#9be679]"
        >
            <div class="flex items-center">
                <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="11" stroke="currentColor" stroke-width="2"></circle>
                    <path d="M7 13L10 16L17 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                <span>{{ successMessage }}</span>
            </div>
        </div>
        <input
            type="hidden"
            name="id"
            v-model="form.id"
        />
        <div class="mb-4">
            <h3 class="">Are you sure you want to delete your message?</h3>
        </div>
        <div v-if="form.errors.id" class="text-red-500 text-sm mt-1">{{ form.errors.id }}</div>

        <!-- Submit Button -->
        <footer class="flex justify-end gap-2">
            <button
                type="button"
                class="rounded-sm border border-[#e3e3e0] bg-white px-4 py-2 text-sm text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                @click="emit('close')"
                :disabled="showSuccess"
            >
                Cancel
            </button>
            <button
                type="submit"
                class="rounded-sm border border-[#f53003] bg-[#f53003] px-4 py-2 text-sm text-white hover:bg-[#d92b02] hover:border-[#d92b02] dark:bg-[#FF4433] dark:border-[#FF4433] dark:text-white dark:hover:bg-[#e53e2e] dark:hover:border-[#e53e2e]"
                :disabled="showSuccess"
            >
                Delete
            </button>
        </footer>
    </form>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref, defineEmits } from 'vue';

const emit = defineEmits(['close']);

// Success message state
const showSuccess = ref(false);
const successMessage = ref('');

const props = defineProps<{
    id: number;
}>();

const form = useForm<{
    id: number;
}>({
    id: props.id,
});

const submitForm = () => {
    form.post(route('post.destroy'), {
        preserveScroll: true,
        onSuccess: () => {
            successMessage.value = 'Post deleted successfully';
            showSuccess.value = true;
            form.reset();

            // Close the modal after a short delay
            window.setTimeout(() => {
                showSuccess.value = false;
                emit('close');
            }, 3000);
        },
    });
};
</script>
