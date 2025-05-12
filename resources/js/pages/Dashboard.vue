<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { ref, computed } from 'vue';
import { Post } from '@/types/Post';
import Modal from '@/components/ui/modal/Modal.vue';
import PostForm from '@/components/ui/form/PostForm.vue';
import DeleteForm from '@/components/ui/form/DeleteForm.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

// Define props to receive data from Inertia
const props = defineProps<{
  pagination?: {
    data: Array<Post>;
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    links: Array<any>;
  };
  message?: string;
  success?: boolean;
  order_column?: string;
  order_direction?: string;
}>();

const posts = computed(() => props.pagination?.data || []);
const currentPage = computed(() => props.pagination?.current_page || 1);
const lastPage = computed(() => props.pagination?.last_page || 1);
const sortField = computed(() => props.order_column || 'created_at');
const sortDirection = computed(() => props.order_direction || 'desc');

const showPostModal = ref(false);
const showDeleteModal = ref(false);
const deleteId = ref(0);
const selectedPost = ref<Post | null>(null);

const openPostModal = (post: Post | null) => {
    showPostModal.value = true;
    selectedPost.value = post;
};

const closePostModal = () => {
    showPostModal.value = false;
    selectedPost.value = null;
};

const openDeleteModal = (id: number) => {
    showDeleteModal.value = true;
    deleteId.value = id;
};

const closeDeleteModal = () => {
    showDeleteModal.value = false;
    deleteId.value = 0;
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

const changeSort = (field: string) => {
    // If clicking on the current sort field, toggle direction
    const direction = field === sortField.value
        ? (sortDirection.value === 'asc' ? 'desc' : 'asc')
        : 'asc'; // Default to ascending for a new sort field

    window.location.href = route('dashboard', {
        page: 1,
        order_column: field,
        order_direction: direction
    });
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="w-full rounded-lg bg-white p-6 text-[13px] leading-[20px] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:bg-[#161615] dark:text-[#EDEDEC] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
                <h2 class="mb-4 text-xl font-semibold text-gray-800 dark:text-white">Guest Messages</h2>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="pb-2 text-left font-medium">
                                    <div class="flex items-center gap-1">
                                        <span>Name</span>
                                            <button
                                                @click="changeSort('name')"
                                                class="rounded-full p-1 hover:bg-gray-100 dark:hover:bg-gray-800"
                                                title="Sort by name"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    :class="{'text-[#f53003] dark:text-[#FF4433]': sortField === 'name'}">
                                                    <!-- Triangle pointing up (for ascending) -->
                                                    <path v-if="sortField === 'name' && sortDirection === 'asc'"
                                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 15l7-7 7 7" />
                                                    <!-- Triangle pointing down (for descending) -->
                                                    <path v-else-if="sortField === 'name' && sortDirection === 'desc'"
                                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 9l-7 7-7-7" />
                                                    <!-- Default (neutral) triangle icon -->
                                                    <path v-else
                                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 15l7-7 7 7" />
                                                </svg>
                                            </button>
                                    </div>
                                </th>
                                <th class="pb-2 text-left font-medium">
                                    <div class="flex items-center gap-1">
                                        <span>Email</span>
                                        <button
                                            @click="changeSort('email')"
                                            class="rounded-full p-1 hover:bg-gray-100 dark:hover:bg-gray-800"
                                            title="Sort by email"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                :class="{'text-[#f53003] dark:text-[#FF4433]': sortField === 'email'}">
                                                <!-- Triangle pointing up (for ascending) -->
                                                <path v-if="sortField === 'email' && sortDirection === 'asc'"
                                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 15l7-7 7 7" />
                                                <!-- Triangle pointing down (for descending) -->
                                                <path v-else-if="sortField === 'email' && sortDirection === 'desc'"
                                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                                <!-- Default (neutral) triangle icon -->
                                                <path v-else
                                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 15l7-7 7 7" />
                                            </svg>
                                        </button>
                                    </div>
                                </th>
                                <th class="pb-2 text-left font-medium">
                                    <div class="flex items-center gap-1">
                                        <span>IP Address</span>
                                            <button
                                                @click="changeSort('ip_address')"
                                                class="rounded-full p-1 hover:bg-gray-100 dark:hover:bg-gray-800"
                                                title="Sort by ip address"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    :class="{'text-[#f53003] dark:text-[#FF4433]': sortField === 'ip_address'}">
                                                    <!-- Triangle pointing up (for ascending) -->
                                                    <path v-if="sortField === 'ip_address' && sortDirection === 'asc'"
                                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 15l7-7 7 7" />
                                                    <!-- Triangle pointing down (for descending) -->
                                                    <path v-else-if="sortField === 'ip_address' && sortDirection === 'desc'"
                                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 9l-7 7-7-7" />
                                                    <!-- Default (neutral) triangle icon -->
                                                    <path v-else
                                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 15l7-7 7 7" />
                                                </svg>
                                            </button>
                                    </div>
                                </th>
                                <th class="pb-2 text-left font-medium">Message</th>
                                <th class="pb-2 text-left font-medium">
                                    <div class="flex items-center gap-1">
                                        <span>Posted</span>
                                            <button
                                                @click="changeSort('created_at')"
                                                class="rounded-full p-1 hover:bg-gray-100 dark:hover:bg-gray-800"
                                                title="Sort by date"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    :class="{'text-[#f53003] dark:text-[#FF4433]': sortField === 'created_at'}">
                                                    <!-- Triangle pointing up (for ascending) -->
                                                    <path v-if="sortField === 'created_at' && sortDirection === 'asc'"
                                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 15l7-7 7 7" />
                                                    <!-- Triangle pointing down (for descending) -->
                                                    <path v-else-if="sortField === 'created_at' && sortDirection === 'desc'"
                                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 9l-7 7-7-7" />
                                                    <!-- Default (neutral) triangle icon -->
                                                    <path v-else
                                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 15l7-7 7 7" />
                                                </svg>
                                            </button>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="post in posts" :key="post?.id" class="border-b border-[#e3e3e0] hover:bg-[#FDFDFC] dark:border-[#3E3E3A] dark:hover:bg-[#1C1C1A]">
                                <td class="py-3 pr-4">{{ post?.name || 'Anonymous' }}</td>
                                <td class="py-3 pr-4">{{ post?.email || 'N/A' }}</td>
                                <td class="py-3 pr-4">{{ post?.ip_address || 'N/A' }}</td>
                                <td class="py-3 pr-4">
                                    <div class="flex items-start gap-3 flex-col-reverse">
                                        <a
                                            v-if="post?.image_url"
                                            :href="post.image_url"
                                            target="_blank"
                                            class="flex items-center justify-center">
                                            <img
                                                :src="post.image_url"
                                                alt="Post image"
                                                class="h-12 w-12 rounded object-cover border border-gray-200 dark:border-gray-700 mt-1 mb-1"
                                                style="cursor: pointer;"
                                            />
                                        </a>
                                        <span>{{ post?.text || 'No message content' }}
                                            <template v-if="post.created_at != post.updated_at">
                                                <br />
                                                <span class="text-[#f53003]">Updated at: {{ formatDate(post?.updated_at) }}</span>
                                            </template>
                                        </span>
                                    </div>
                                </td>
                                <td class="py-3 text-gray-500 dark:text-gray-400">
                                    {{ formatDate(post?.created_at) }}
                                    <div class="mt-2 flex space-x-2">
                                        <!-- Edit Icon -->
                                        <button
                                            class="rounded-full p-1.5 hover:bg-gray-100 dark:hover:bg-gray-800 text-blue-600 dark:text-blue-400"
                                            title="Edit"
                                            @click="openPostModal(post)"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <!-- Delete Icon -->
                                        <button
                                            class="rounded-full p-1.5 hover:bg-gray-100 dark:hover:bg-gray-800 text-red-600 dark:text-red-400"
                                            title="Delete"
                                            @click="openDeleteModal(post.id)"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="posts && posts.length > 0" class="mt-4 flex justify-center">
                    <!-- Pagination controls -->
                    <div class="flex items-center space-x-1 text-sm">
                        <!-- First Page -->
                        <Link
                            :href="route('dashboard', {page: 1, order_column: sortField, order_direction: sortDirection})"
                            :class="[
                                'rounded-md p-2 flex items-center justify-center',
                                currentPage === 1
                                    ? 'text-gray-400 dark:text-gray-600 cursor-not-allowed'
                                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
                            ]"
                            :disabled="currentPage === 1"
                        >
                            <span class="sr-only">First page</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M15.707 15.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                <path fill-rule="evenodd" d="M9.707 15.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 111.414 1.414L5.414 10l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                        </Link>

                        <!-- Previous Page -->
                        <Link
                            :href="route('dashboard', {page: currentPage - 1, order_column: sortField, order_direction: sortDirection})"
                            :class="[
                                'rounded-md p-2 flex items-center justify-center',
                                currentPage === 1
                                    ? 'text-gray-400 dark:text-gray-600 cursor-not-allowed'
                                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
                            ]"
                            :disabled="currentPage === 1"
                        >
                            <span class="sr-only">Previous page</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </Link>
                        <p class="rounded-md p-2 flex items-center justify-center text-gray-700 dark:text-gray-300">{{ currentPage }}</p>

                        <!-- Next Page -->
                        <Link
                            :href="route('dashboard', {page: currentPage + 1, order_column: sortField, order_direction: sortDirection})"
                            :class="[
                                'rounded-md p-2 flex items-center justify-center',
                                currentPage === lastPage
                                    ? 'text-gray-400 dark:text-gray-600 cursor-not-allowed'
                                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
                            ]"
                            :disabled="currentPage === lastPage"
                        >
                            <span class="sr-only">Next page</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </Link>

                        <!-- Last Page -->
                        <Link
                            :href="route('dashboard', {page: lastPage, order_column: sortField, order_direction: sortDirection})"
                            :class="[
                                'rounded-md p-2 flex items-center justify-center',
                                currentPage === lastPage
                                    ? 'text-gray-400 dark:text-gray-600 cursor-not-allowed'
                                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
                            ]"
                            :disabled="currentPage === lastPage"
                        >
                            <span class="sr-only">Last page</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 15.707a1 1 0 001.414 0l5-5a1 1 0 000-1.414l-5-5a1 1 0 00-1.414 1.414L8.586 10 4.293 14.293a1 1 0 000 1.414z" clip-rule="evenodd" />
                                <path fill-rule="evenodd" d="M10.293 15.707a1 1 0 001.414 0l5-5a1 1 0 000-1.414l-5-5a1 1 0 00-1.414 1.414L14.586 10l-4.293 4.293a1 1 0 000 1.414z" clip-rule="evenodd" />
                            </svg>
                        </Link>
                    </div>
                </div>

                <div v-if="!posts || posts.length === 0" class="py-8 text-center text-gray-500 dark:text-gray-400">
                    No guest entries found
                </div>
            </div>
        </div>
        <!-- Modal for PostForm  -->
        <Modal
            :isOpen="showPostModal"
            title="Send us a message"
            @close="closePostModal"
        >
            <PostForm
                :post="selectedPost"
                @close="closePostModal"
                :as_admin="true"
            />
        </Modal>

        <!-- Modal for delete confirmations -->
        <Modal
            :isOpen="showDeleteModal"
            title="Message deletion"
            @close="closeDeleteModal"
        >
            <DeleteForm
                @close="closeDeleteModal"
                :id="deleteId"
                :as_admin="true"
            />
        </Modal>
    </AppLayout>
</template>
