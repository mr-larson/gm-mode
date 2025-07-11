<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    brands: Array,
})
</script>

<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Liste des Brands</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div
                v-for="brand in brands"
                :key="brand.id"
                class="border rounded-lg p-4 shadow"
                :style="{ borderColor: brand.color ?? '#ccc' }"
            >
                <h2 class="text-xl font-semibold mb-2">
                    <Link :href="route('brands.show', brand.id)" class="text-blue-600 hover:underline">
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
</template>
