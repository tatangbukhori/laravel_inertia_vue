<script setup>
    import { router } from '@inertiajs/vue3';
    import { ref, watch } from 'vue';
    import PaginationLinks from './Components/PaginationLinks.vue';
    import { debounce } from 'lodash';

    const props = defineProps({
        users: Object,
        searchTerm: String,
    });

    const search = ref(props.searchTerm);

    watch(search, debounce(
        (q) => router.get('/', { search: q }, { preserveState: true }),
        500)
    );

    // Format date
    const getDate = (date) =>
        new Date(date).toLocaleDateString('en-us', {
            year: "numeric",
            month: "long",
            day: "numeric",
        });
</script>

<template>
    <Head :title="$page.component" />

    <div>
        <div class="flex justify-end mb-4">
            <div class="w-1/4">
                <input type="search" placeholder="Search" v-model="search" />
            </div>
        </div>

        <table>
            <thead>
                <tr class="bg-slate-40">
                    <th>Avatar</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Registration Date</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="user in users.data" :key="user.id">
                    <td>
                        <img :src="user.avatar ? ('Storage/' + user.avatar) : ('Storage/avatars/default.png')" class="avatar" alt="">
                    </td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ getDate(user.created_at) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination Links -->
        <PaginationLinks :paginator="users"/>

    </div>
</template>