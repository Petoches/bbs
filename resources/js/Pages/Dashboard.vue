<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router, useForm, Link} from '@inertiajs/vue3';

const props = defineProps({
    pages: {
        type: Object,
        default: {}
    }
})

const form = useForm({
    token: null,
})

function submit() {
    form.post(route('page.store'));
}

function fetch(page) {
    router.post(route('page.fetch'), {
        page: page
    });
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form id="store" @submit.prevent="submit">
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Token</label>
                            <div class="mt-2 flex gap-x-4">
                                <input v-model="form.token" type="text" name="token" id="token" class="block flex-grow rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="token" />
                                <button type="submit" class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :disabled="form.processing">Add page</button>
                            </div>
                            <div v-if="form.errors.token" class="text-red-500">{{ form.errors.token }}</div>
                        </form>
                    </div>
                </div>
                <div v-if="Object.keys(props.pages).length > 0" class="mt-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="font-semibold text-xl text-gray-800 leading-tight mb-6">My pages</h3>
                        <div v-for="page in props.pages" :key="page.id" class="flex gap-x-4 items-center">
                            <span>id : {{ page.instagram_id }}</span>
                            <span>username : {{ page.username }}</span>
                            <span>account type : {{ page.account_type }}</span>
                            <form id="fetch" @submit.prevent="fetch(page)" class="ml-auto">
                                <button type="submit" class="rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Fetch medias</button>
                            </form>
                            <Link :href="route('page.show', {page: page.username})" as="button" type="button" class="rounded-md bg-teal-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-teal-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-600">
                                Visit
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
