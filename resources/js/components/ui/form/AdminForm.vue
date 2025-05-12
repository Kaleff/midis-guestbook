<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    admin: {
        type: Object({
            id: Number,
            name: String,
            email: String,
        }),
        default: null,
        required: false,
    },
});

// Form for editing admin
const form = useForm({
    id: props.admin?.id || null,
    name: props.admin?.name || '',
    email: props.admin?.email || '',
    password: '',
    password_confirmation: ''
});



const showSuccess = ref(false);
const successMessage = ref('');

const emit = defineEmits(['close', 'submit']);

const submitForm = () => {
    form.post(route('admin.store'), {
        preserveScroll: true,
        onSuccess: () => {
            successMessage.value = 'Post created successfully';
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

<template>
    <form @submit.prevent="submitForm">
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
        <div class="mb-4">
            <label for="name" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
            <input type="text" id="name" v-model="form.name"
                class="w-full rounded-sm border border-[#e3e3e0] bg-white p-2 text-sm text-[#1b1b18] focus:border-[#f53003] focus:outline-none focus:ring-1 focus:ring-[#f53003] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] dark:focus:border-[#FF4433] dark:focus:ring-[#FF4433]"
                required />
            <span v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</span>
        </div>
        <div class="mb-4">
            <label for="email" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
            <input type="email" id="email" v-model="form.email"
                class="w-full rounded-sm border border-[#e3e3e0] bg-white p-2 text-sm text-[#1b1b18] focus:border-[#f53003] focus:outline-none focus:ring-1 focus:ring-[#f53003] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] dark:focus:border-[#FF4433] dark:focus:ring-[#FF4433]"
                required />
            <span v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</span>
        </div>
        <div class="mb-4">
            <label for="password" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">New Password
                (leave blank to keep current)</label>
            <input type="password" id="password" v-model="form.password"
                class="w-full rounded-sm border border-[#e3e3e0] bg-white p-2 text-sm text-[#1b1b18] focus:border-[#f53003] focus:outline-none focus:ring-1 focus:ring-[#f53003] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] dark:focus:border-[#FF4433] dark:focus:ring-[#FF4433]" />
            <span v-if="form.errors.password" class="text-red-500 text-sm">{{ form.errors.password }}</span>
        </div>
        <div class="mb-4">
            <label for="password_confirmation"
                class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm New Password</label>
            <input type="password" id="password_confirmation" v-model="form.password_confirmation"
                class="w-full rounded-sm border border-[#e3e3e0] bg-white p-2 text-sm text-[#1b1b18] focus:border-[#f53003] focus:outline-none focus:ring-1 focus:ring-[#f53003] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] dark:focus:border-[#FF4433] dark:focus:ring-[#FF4433]" />
        </div>
        <div class="flex justify-end gap-2">
            <button type="button"
                class="rounded-sm border border-[#e3e3e0] bg-white px-4 py-2 text-sm text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                @click="emit('close')">
                Cancel
            </button>
            <button type="submit"
                class="rounded-sm border border-[#f53003] bg-[#f53003] px-4 py-2 text-sm text-white hover:bg-[#d92b02] hover:border-[#d92b02] dark:bg-[#FF4433] dark:border-[#FF4433] dark:text-white dark:hover:bg-[#e53e2e] dark:hover:border-[#e53e2e]"
                :disabled="form.processing">
                Update Admin
            </button>
        </div>
    </form>
</template>
