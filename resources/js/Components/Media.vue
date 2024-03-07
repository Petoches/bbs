<script setup>
import { HeartIcon, VideoCameraIcon } from "@heroicons/vue/24/solid";

const props = defineProps({
    media: {
        type: Object,
        required: true
    }
})
</script>

<template>
    <div class="flex flex-col rounded-lg bg-white text-center shadow-md overflow-hidden animate__animated animate__flipInY">
        <div class="relative h-80">
            <img
                class="absolute w-full h-full object-cover"
                :src="media.media_url"
                alt=""
            />
        </div>
    </div>
</template>
