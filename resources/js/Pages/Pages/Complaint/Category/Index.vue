<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { Table } from "@protonemedia/inertiajs-tables-laravel-query-builder";

defineProps(["categorycomplaints", "flash"]);
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Category complaint
            </h2>
        </template>

        <!-- create message  -->
        <div
            v-if="flash.message"
            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
            role="alert"
        >
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ flash.message }}</span>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <!-- button new category -->
                        <div class="flex justify-end mb-3">
                            <button
                                class="btn btn-primary"
                                @click="isOpen = true"
                            >
                                New Category
                            </button>
                        </div>
                        <Table :resource="categorycomplaints" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <!-- modal new category -->
    <div
        v-show="isOpen"
        class="absolute inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50"
    >
        <div class="modal-box bg-white">
            <h3 class="font-bold text-lg text-black mb-4">
                New Category Complaint
            </h3>
            <form @submit.prevent="submit">
                <input
                    type="text"
                    placeholder="Name"
                    class="input input-bordered w-full max-w-xs"
                    v-model="name"
                />
                <div class="modal-action">
                    <label for="my-modal" class="btn" @click="isOpen = false"
                        >Cancel</label
                    >
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isOpen: false,
        };
    },

    methods: {
        submit() {
            this.$inertia.post("/complaint/category", {
                name: this.name,
            });

            this.isOpen = false;
        },
    },
};
</script>
