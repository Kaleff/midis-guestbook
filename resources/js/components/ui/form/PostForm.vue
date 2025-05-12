<template>
    <form
        @submit.prevent="submitForm"
        class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg dark:bg-[#161615] dark:text-[#EDEDEC]"
    >
        <!-- Name Input -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-[#706f6c] dark:text-[#A1A09A]">
                Name <span class="text-red-500">*</span>
            </label>
            <input
                id="name"
                v-model="form.name"
                type="text"
                maxlength="255"
                required
                class="mt-1 w-full rounded-sm border border-[#e3e3e0] bg-white px-3 py-2 text-sm text-[#1b1b18] placeholder-[#706f6c] focus:outline-none focus:ring-2 focus:ring-[#f53003] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC]"
                placeholder="Enter your name"
            />
            <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
        </div>

        <!-- Email Input -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-[#706f6c] dark:text-[#A1A09A]">
                Email Address <span class="text-red-500">*</span>
            </label>
            <input
                id="email"
                v-model="form.email"
                type="email"
                maxlength="255"
                required
                class="mt-1 w-full rounded-sm border border-[#e3e3e0] bg-white px-3 py-2 text-sm text-[#1b1b18] placeholder-[#706f6c] focus:outline-none focus:ring-2 focus:ring-[#f53003] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC]"
                placeholder="Enter your email"
            />
            <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</div>
        </div>

        <!-- Message Input -->
        <div class="mb-4">
            <label for="message" class="block text-sm font-medium text-[#706f6c] dark:text-[#A1A09A]">
                Message <span class="text-red-500">*</span>
            </label>
            <textarea
                id="text"
                v-model="form.text"
                maxlength="1000"
                required
                class="mt-1 w-full rounded-sm border border-[#e3e3e0] bg-white px-3 py-2 text-sm text-[#1b1b18] placeholder-[#706f6c] focus:outline-none focus:ring-2 focus:ring-[#f53003] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC]"
                placeholder="Enter your message"
                rows="4"
            ></textarea>
           <div v-if="form.errors.text" class="text-red-500 text-sm mt-1">{{ form.errors.text }}</div>
        </div>

        <!-- Image Input -->
        <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-[#706f6c] dark:text-[#A1A09A]">
                Image (optional)
            </label>
            <input
                id="image"
                type="file"
                accept=".jpg,.jpeg,.png"
                @change="handleImageUpload"
                class="mt-1 w-full text-sm text-[#706f6c] file:mr-4 file:rounded-sm file:border file:border-[#e3e3e0] file:bg-white file:px-3 file:py-2 file:text-sm file:text-[#1b1b18] hover:file:border-[#1915014a] dark:file:border-[#3E3E3A] dark:file:bg-[#161615] dark:file:text-[#EDEDEC]"
            />
            <div v-if="form.errors.image" class="text-red-500 text-sm mt-1">{{ form.errors.image }}</div>
        </div>

        <!-- CAPTCHA -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-[#706f6c] dark:text-[#A1A09A]">
                CAPTCHA <span class="text-red-500">*</span>
            </label>
            <div class="mt-1 flex items-center justify-center h-16 bg-gray-100 dark:bg-[#3E3E3A]">
                <!-- Replace this with your CAPTCHA implementation -->
                <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">[CAPTCHA Placeholder]</p>
            </div>
        </div>

        <!-- Submit Button -->
        <footer class="flex justify-end gap-2">
            <button
                type="reset"
                class="rounded-sm border border-[#e3e3e0] bg-white px-4 py-2 text-sm text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
            >
                Reset
            </button>
            <button type="submit">Submit</button>
        </footer>
    </form>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

// Replace reactive object with Inertia useForm
const form = useForm({
    name: '',
    email: '',
    text: '',
    captcha: '',
    image: {},
});

const submitForm = () => {
    form.post(route('post.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        }
    });
};

const handleImageUpload = (event: Event) => {
    const file = (event.target as HTMLInputElement).files?.[0];
    if (file) {
        if (file.size > 4 * 1024 * 1024) {
            alert('File size exceeds 4 MB.');
            return;
        }
        form.image = file;
    }
};
</script>
