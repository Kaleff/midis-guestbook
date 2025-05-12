<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Modal from '@/components/ui/modal/Modal.vue';
import AdminForm from '@/components/ui/form/AdminForm.vue';
import DeleteAdminForm from '@/components/ui/form/DeleteAdminForm.vue';

// Define Admin type
type Admin = {
    id: number;
    name: string;
    email: string;
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Admin Users',
        href: '/admin/users',
    },
];

// Define props to receive data from Inertia
const props = defineProps<{
    admins: Array<Admin>;
}>();

// Modal state management
const showEditModal = ref(false);
const showDeleteModal = ref(false);
const selectedAdmin = ref<Admin | null>(null);

const openEditModal = (admin: Admin | null) => {
    showEditModal.value = true;
    selectedAdmin.value = admin;
};

const closeEditModal = () => {
    showEditModal.value = false;
    selectedAdmin.value = null;
};

const openDeleteModal = (admin: Admin) => {
    showDeleteModal.value = true;
    selectedAdmin.value = admin;
};

const closeDeleteModal = () => {
    showDeleteModal.value = false;
    selectedAdmin.value = null;
};
</script>

<template>
    <Head title="Admin Users" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="w-full rounded-lg bg-white p-6 text-[13px] leading-[20px] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:bg-[#161615] dark:text-[#EDEDEC] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
                <div class="mb-6 flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Admin Users</h2>
                    <button
                        @click="openEditModal(null)"
                        class="rounded-sm border border-[#f53003] bg-[#f53003] px-4 py-2 text-sm text-white hover:bg-[#d92b02] hover:border-[#d92b02] dark:bg-[#FF4433] dark:border-[#FF4433] dark:text-white dark:hover:bg-[#e53e2e] dark:hover:border-[#e53e2e]"
                    >
                        Add New Admin
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="pb-2 text-left font-medium">Name</th>
                                <th class="pb-2 text-left font-medium">Email</th>
                                <th class="pb-2 text-left font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="admin in props.admins" :key="admin?.id" class="border-b border-[#e3e3e0] hover:bg-[#FDFDFC] dark:border-[#3E3E3A] dark:hover:bg-[#1C1C1A]">
                                <td class="py-3 pr-4">{{ admin?.name }}</td>
                                <td class="py-3 pr-4">{{ admin?.email }}</td>
                                <td class="py-3">
                                    <div class="flex space-x-2">
                                        <!-- Edit Icon -->
                                        <button
                                            class="rounded-full p-1.5 hover:bg-gray-100 dark:hover:bg-gray-800 text-blue-600 dark:text-blue-400"
                                            title="Edit Admin"
                                            @click="openEditModal(admin)"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <!-- Delete Icon -->
                                        <button
                                            class="rounded-full p-1.5 hover:bg-gray-100 dark:hover:bg-gray-800 text-red-600 dark:text-red-400"
                                            title="Delete Admin"
                                            @click="openDeleteModal(admin)"
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

                <div v-if="!props.admins || props.admins.length === 0" class="py-8 text-center text-gray-500 dark:text-gray-400">
                    No admin users found
                </div>
            </div>
        </div>

        <!-- Modal for editing admin -->
        <Modal
            :isOpen="showEditModal"
            title="Edit Admin User"
            @close="closeEditModal"
        >
            <AdminForm
                :admin="selectedAdmin"
                @close="closeEditModal"
            />
        </Modal>

        <!-- Modal for deleting admin -->
        <Modal
            :isOpen="showDeleteModal"
            title="Delete Admin User"
            @close="closeDeleteModal"
        >
            <DeleteAdminForm
                :id="selectedAdmin?.id"
                @close="closeDeleteModal"
            />
        </Modal>
    </AppLayout>
</template>
