<script setup>
    import { HeartIcon, VideoCameraIcon } from "@heroicons/vue/24/solid";

    const props = defineProps({
        data: {
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
                :src="props.data.display_url"
                alt=""
            />
            <VideoCameraIcon v-if="props.data.is_video" class="absolute top-2 right-4 w-6 h-6 text-teal-500" />
        </div>
        <div>
            <div class="-mt-px flex divide-gray-200 p-2 justify-center items-center">
                <HeartIcon class="w-6 h-6 text-red-500" />
                <span class="ml-2">{{ props.data.likes }}</span>
            </div>
        </div>
    </div>
</template>
