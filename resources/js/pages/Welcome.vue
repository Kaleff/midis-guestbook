<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Modal from '@/components/ui/modal/Modal.vue';
import PostForm from '@/components/ui/form/PostForm.vue';

// Define props to receive data from Inertia
const props = defineProps<{
  pagination?: {
    data: Array<{
      id: number;
      name: string;
      text: string;
      created_at: string;
      editable?: boolean;
    }>;
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    links: Array<any>;
  };
  message?: string;
  success?: boolean;
}>();

const posts = computed(() => props.pagination?.data || []);

const showModal = ref(false);

const openModal = () => {
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};

const formatDate = (dateString: string): string => {
    if (!dateString) return '';

    const date = new Date(dateString);

    // Format: YYYY.MM.DD HH:MM
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');

    return `${year}.${month}.${day} ${hours}:${minutes}`;
};
</script>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] dark:bg-[#0a0a0a] lg:justify-center lg:p-8">
        <header class="not-has-[nav]:hidden mb-6 w-full max-w-[335px] text-sm lg:max-w-4xl">
            <nav class="flex items-center justify-end gap-4">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                >
                    Dashboard
                </Link>
                <template v-else>
                    <Link
                        :href="route('login')"
                        class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                    >
                        Log in
                    </Link>
                </template>
            </nav>
        </header>
        <div class="duration-750 starting:opacity-0 flex w-full items-center justify-center opacity-100 transition-opacity lg:grow">
            <main class="flex w-full max-w-[335px] flex-col-reverse overflow-hidden rounded-lg lg:max-w-4xl lg:flex-row">
                <div
                    class="flex-1 rounded-bl-lg rounded-br-lg bg-white p-6 pb-12 text-[13px] leading-[20px] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:bg-[#161615] dark:text-[#EDEDEC] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] lg:rounded-br-none lg:rounded-tl-lg lg:p-20"
                >
                    <h1 class="mb-1 font-medium">Hello and welcome!</h1>
                    <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">
                        We are so excited to have you here, please leave a comment or message about your experience with us. We are always looking for ways to improve our service and make it better for you.
                    </p>
                    <ul class="mb-4 flex flex-col lg:mb-6">
                        <li
                            class="relative flex items-center gap-4 py-2 before:absolute before:bottom-0 before:left-[0.4rem] before:top-1/2 before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A]"
                        >
                            <span class="relative bg-white py-1 dark:bg-[#161615]">
                                <span
                                    class="flex h-3.5 w-3.5 items-center justify-center rounded-full border border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]"
                                >
                                    <span class="h-1.5 w-1.5 rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A]" />
                                </span>
                            </span>
                            <span>
                                Leave the
                                <a
                                    href="javascript:void(0)"
                                    @click="openModal"
                                    class="ml-1 inline-flex items-center space-x-1 font-medium text-[#f53003] underline underline-offset-4 dark:text-[#FF4433]"
                                >
                                    <span>message</span>
                                    <svg
                                        width="{10}"
                                        height="{11}"
                                        viewBox="0 0 10 11"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-2.5 w-2.5"
                                    >
                                        <path d="M7.70833 6.95834V2.79167H3.54167M2.5 8L7.5 3.00001" stroke="currentColor" stroke-linecap="square" />
                                    </svg>
                                </a>
                            </span>
                        </li>
                        <li
                            class="relative flex items-center gap-4 py-2 before:absolute before:bottom-1/2 before:left-[0.4rem] before:top-0 before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A]"
                        >
                            <span class="relative bg-white py-1 dark:bg-[#161615]">
                                <span
                                    class="flex h-3.5 w-3.5 items-center justify-center rounded-full border border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]"
                                >
                                    <span class="h-1.5 w-1.5 rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A]" />
                                </span>
                            </span>
                            <span>
                                Edit or delete your message within
                                <span class="ml-1 inline-flex items-center space-x-1 font-medium text-[#f53003] underline underline-offset-4 dark:text-[#FF4433]">5 minutes of posting it.</span>
                            </span>
                        </li>
                        <li
                            class="relative flex items-center gap-4 py-2 before:absolute before:bottom-1/2 before:left-[0.4rem] before:top-0 before:border-l before:border-[#e3e3e0] dark:before:border-[#3E3E3A]"
                        >
                            <span class="relative bg-white py-1 dark:bg-[#161615]">
                                <span
                                    class="flex h-3.5 w-3.5 items-center justify-center rounded-full border border-[#e3e3e0] bg-[#FDFDFC] shadow-[0px_0px_1px_0px_rgba(0,0,0,0.03),0px_1px_2px_0px_rgba(0,0,0,0.06)] dark:border-[#3E3E3A] dark:bg-[#161615]"
                                >
                                    <span class="h-1.5 w-1.5 rounded-full bg-[#dbdbd7] dark:bg-[#3E3E3A]" />
                                </span>
                            </span>
                            <span>
                                After that, it will be permanently stored in our database.
                            </span>
                        </li>
                    </ul>
                    <ul class="flex gap-3 text-sm leading-normal">
                        <li>
                            <a
                                href="javascript:void(0)"
                                @click="openModal"
                                class="inline-block rounded-sm border border-black bg-[#1b1b18] px-5 py-1.5 text-sm leading-normal text-white hover:border-black hover:bg-black dark:border-[#eeeeec] dark:bg-[#eeeeec] dark:text-[#1C1C1A] dark:hover:border-white dark:hover:bg-white"
                            >
                                Leave a message
                            </a>
                        </li>
                    </ul>
                </div>
            </main>
        </div>
        <div class="mt-6 duration-750 starting:opacity-0 flex w-full items-center justify-center opacity-100 transition-opacity lg:grow" v-if="posts">
            <main class="flex w-full max-w-[335px] flex-col-reverse overflow-hidden rounded-lg lg:max-w-4xl lg:flex-row">
                <div class="w-full rounded-lg bg-white p-6 text-[13px] leading-[20px] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:bg-[#161615] dark:text-[#EDEDEC] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
                    <h2 class="mb-4 text-lg font-medium">Recent Messages</h2>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
                                    <th class="pb-2 text-left font-medium">Name</th>
                                    <th class="pb-2 text-left font-medium">Message</th>
                                    <th class="pb-2 text-left font-medium">Posted</th>
                                    <th class="pb-2 text-left font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="post in posts" :key="post?.id" class="border-b border-[#e3e3e0] hover:bg-[#FDFDFC] dark:border-[#3E3E3A] dark:hover:bg-[#1C1C1A]">
                                    <td class="py-3 pr-4">{{ post?.name || 'Anonymous' }}</td>
                                    <td class="py-3 pr-4">{{ post?.text || 'No message content' }}</td>
                                    <td class="py-3 text-[#706f6c] dark:text-[#A1A09A]">{{ formatDate(post?.created_at) }}</td>
                                    <td class="py-3">
                                        <div class="flex space-x-2">
                                            <!-- View Icon -->
                                            <button
                                                class="rounded-full p-1.5 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-300"
                                                title="View"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>

                                            <template v-if="post?.editable">
                                                <!-- Edit Icon -->
                                                <button
                                                    class="rounded-full p-1.5 hover:bg-gray-100 dark:hover:bg-gray-800 text-blue-600 dark:text-blue-400"
                                                    title="Edit"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>

                                                <!-- Delete Icon -->
                                                <button
                                                    class="rounded-full p-1.5 hover:bg-gray-100 dark:hover:bg-gray-800 text-red-600 dark:text-red-400"
                                                    title="Delete"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </template>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div v-if="posts && posts.length > 0" class="mt-4 flex justify-center">
                        <!-- Pagination controls could go here -->
                    </div>
                </div>
            </main>
        </div>
        <div class="h-14.5 hidden lg:block"></div>
    </div>
    <Modal
        :isOpen="showModal"
        title="Send us a message"
        :isForm="true"
        @close="closeModal"
    >
        <PostForm
            @close="closeModal"
        />
    </Modal>
</template>
