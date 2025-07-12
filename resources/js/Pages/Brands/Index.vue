<script setup>
import {Head, Link} from '@inertiajs/vue3'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps({
    brands: Array,
})
</script>

<template>
    <Head title="Brands" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Brands
            </h2>
        </template>

        <div class="p-6">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    v-for="brand in brands"
                    :key="brand.id"
                    class="border rounded-lg bg-white p-4 shadow"
                    :style="{ borderColor: brand.color ?? '#ccc' }"
                >
                    <h2 class="text-xl font-semibold mb-2">
                        <Link :href="route('brands.show', brand.id)" class="hover:underline">
                            {{ brand.name }}
                        </Link>
                    </h2>
                    <p class="text-sm text-gray-600">{{ brand.description }}</p>
                    <p class="mt-2 text-sm"><strong>Popularité :</strong> {{ brand.popularity }}</p>
                    <p class="text-sm"><strong>Style :</strong> {{ brand.style }}</p>
                    <p class="text-sm"><strong>Workers :</strong> {{ brand.workers_count }}</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
