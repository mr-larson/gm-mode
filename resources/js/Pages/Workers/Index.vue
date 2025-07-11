<script setup>
import { ref } from 'vue'
import {Link, router} from '@inertiajs/vue3'

const props = defineProps({
    workers: Array,
    brands: Array,
    categories: Array,
    styles: Array,
    filters: Object,
})

// Filtres
const brandFilter = ref(props.filters.brand_id || '')
const categoryFilter = ref(props.filters.category || '')
const styleFilter = ref(props.filters.style || '')
const sort = ref(props.filters.sort || 'lastname')
const direction = ref(props.filters.direction || 'asc')

// Appliquer les filtres
function applyFilters() {
    router.get(route('workers.index'), {
        brand_id: brandFilter.value,
        category: categoryFilter.value,
        style: styleFilter.value,
        sort: sort.value,
        direction: direction.value,
    }, {
        preserveScroll: true,
        preserveState: true,
    })
}

// Tri dynamique
function sortBy(column) {
    if (sort.value === column) {
        direction.value = direction.value === 'asc' ? 'desc' : 'asc'
    } else {
        sort.value = column
        direction.value = 'asc'
    }

    applyFilters()
}
</script>

<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Workers</h1>

        <!-- Filtres -->
        <div class="flex flex-wrap gap-4 mb-4">
            <div>
                <label class="mr-2 font-semibold">Brand:</label>
                <select v-model="brandFilter" @change="applyFilters" class="border p-1 rounded">
                    <option value="">-- Toutes --</option>
                    <option v-for="brand in brands" :key="brand.id" :value="brand.id">
                        {{ brand.name }}
                    </option>
                </select>
            </div>

            <div>
                <label class="mr-2 font-semibold">Catégorie:</label>
                <select v-model="categoryFilter" @change="applyFilters" class="border p-1 rounded">
                    <option value="">-- Toutes --</option>
                    <option v-for="cat in categories" :key="cat.value" :value="cat.value">
                        {{ cat.label }}
                    </option>
                </select>
            </div>

            <div>
                <label class="mr-2 font-semibold">Style:</label>
                <select v-model="styleFilter" @change="applyFilters" class="border p-1 rounded">
                    <option value="">-- Tous --</option>
                    <option v-for="style in styles" :key="style.value" :value="style.value">
                        {{ style.label }}
                    </option>
                </select>
            </div>
        </div>

        <!-- Tableau -->
        <div class="overflow-auto">
            <table class="min-w-full text-sm border">
                <thead class="bg-gray-100">
                <tr>
                    <th @click="sortBy('lastname')" class="cursor-pointer p-2 border">Nom</th>
                    <th @click="sortBy('category')" class="cursor-pointer p-2 border">Catégorie</th>
                    <th @click="sortBy('style')" class="cursor-pointer p-2 border">Style</th>
                    <th @click="sortBy('popularity')" class="cursor-pointer p-2 border">Popularité</th>
                    <th class="p-2 border">Brand</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="worker in workers" :key="worker.id" class="hover:bg-gray-50">
                    <td class="p-2 border">
                        <Link :href="route('workers.show', worker.id)">
                            {{ worker.firstname }} {{ worker.lastname }}
                        </Link>
                    </td>
                    <td class="p-2 border">{{ worker.category }}</td>
                    <td class="p-2 border">{{ worker.style }}</td>
                    <td class="p-2 border">{{ worker.popularity }}</td>
                    <td class="p-2 border">{{ worker.brand?.name ?? 'Libre' }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
