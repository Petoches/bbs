<script setup>
import {Head, Link} from '@inertiajs/vue3';
import Post from "@/Components/Post.vue";
import SpinLoader from "@/Components/SpinLoader.vue";
import Media from "@/Components/Media.vue";

const props = defineProps({
    page: {
        type: Object,
        required: true
    },
    medias: {
        type: Object,
        default: {}
    }
})

</script>

<template>
    <Head title="My social wall" />

    <div class="w-full h-full flex flex-col justify-center items-center p-12 overflow-y-auto">
        <ul role="list" class="w-full max-w-screen-2xl h-full grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            <li v-for="(media, index) in props.medias" :key="media.id" class="col-span-1 cursor-pointer transition-all duration-500 ease-in-out hover:scale-105">
                <a :href="media.permalink" target="_blank" >
                    <Media :media="media" />
                </a>
            </li>
        </ul>
    </div>
</template>
