<script setup>
import {Head} from '@inertiajs/vue3';
import Post from "@/Components/Post.vue";
import {useQuery} from '@vue/apollo-composable'
import {gql} from 'graphql-tag'
import {ref, watch} from "vue";
import SpinLoader from "@/Components/SpinLoader.vue";
import {useInfiniteScroll} from "@vueuse/core";

const wall = ref();

const POST_QUERY = gql`
    query getPosts($page: Int!){
        posts(page: $page)  {
            data {
                id
                shortcode
                display_url
                video_url
                description
                likes
                is_video
            }
            paginatorInfo {
                currentPage
                lastPage
            }
        }
    }
`;

const { result, loading, fetchMore } = useQuery(POST_QUERY, () => ({
    page: 1
}));

function loadMore () {
    fetchMore({
        variables: {
            page: result.value.posts.paginatorInfo.currentPage + 1,
        },
        updateQuery: (previousResult, { fetchMoreResult }) => {
            if (!fetchMoreResult) return previousResult

            let mergedData = {
                posts: {
                    data: [
                        ...previousResult.posts.data,
                        ...fetchMoreResult.posts.data,
                    ],
                    paginatorInfo: fetchMoreResult.posts.paginatorInfo
                }
            };

            return mergedData;
        },
    })
}

useInfiniteScroll(
    wall,
    () => {
        if(result.value.posts.paginatorInfo.currentPage !== result.value.posts.paginatorInfo.lastPage && !loading.value) {
            loadMore();
        }
    },
    { distance: 10 }
)

</script>

<template>
    <Head title="My social wall" />

    <div v-if="loading && !result" class="w-full h-full flex justify-center items-center">
        <SpinLoader class="h-10 w-10 text-white" />
    </div>
    <div v-if="result && result.posts" ref="wall" class="w-full h-full flex flex-col justify-center items-center p-12 overflow-y-auto">
        <ul role="list" class="w-full max-w-screen-2xl h-full grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            <li v-for="(post, index) in result.posts.data" :key="post.id" class="col-span-1 cursor-pointer transition-all duration-500 ease-in-out hover:scale-105">
                <a :href="'https://instagram.com/p/'+post.shortcode" target="_blank" ><Post :data="post" /></a>
            </li>
            <li class="self-center justify-self-center col-span-1 sm:col-span-2 md:col-span-3 lg:col-span-4 p-6">
                <SpinLoader v-if="result.posts.paginatorInfo.currentPage !== result.posts.paginatorInfo.lastPage" @click="loadMore" class="h-6 w-6 text-white" />
                <span v-else >that's all folks !</span>
            </li>
        </ul>
    </div>
</template>
