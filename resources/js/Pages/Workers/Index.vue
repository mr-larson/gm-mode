<script setup>
import { router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import FilterSelect from '@/Components/FilterSelect.vue'
import WorkerModal from './Partials/WorkerModal.vue'

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

// Modale
const selectedWorker = ref(null)
const showModal = ref(false)

function openModal(worker) {
    selectedWorker.value = worker
    showModal.value = true
}

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

const hasActiveFilters = computed(() => {
    return brandFilter.value || categoryFilter.value || styleFilter.value
})

function resetFilters() {
    brandFilter.value = ''
    categoryFilter.value = ''
    styleFilter.value = ''
    sort.value = 'lastname'
    direction.value = 'asc'
    applyFilters()
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
    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-wrap items-end gap-4">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    Workers
                </h2>
            </div>
        </template>

        <div class="p-6">
            <!-- Filtres -->
            <div class="bg-white p-4 rounded-lg shadow mb-6">
                <div class="flex flex-wrap justify-between items-center gap-6">
                    <div class="flex flex-wrap gap-6">
                        <FilterSelect
                            label="Brand"
                            v-model="brandFilter"
                            :options="brands.map(b => ({ value: b.id, label: b.name, color: b.color }))"
                            placeholder="-- Toutes --"
                            :onChange="applyFilters"
                        />
                        <FilterSelect
                            label="Catégorie"
                            v-model="categoryFilter"
                            :options="categories"
                            placeholder="-- Toutes --"
                            :onChange="applyFilters"
                        />
                        <FilterSelect
                            label="Style"
                            v-model="styleFilter"
                            :options="styles"
                            :onChange="applyFilters"
                        />
                    </div>

                    <div v-if="hasActiveFilters" class="ml-auto">
                        <button
                            @click="resetFilters"
                            class="px-4 py-2 text-sm text-white bg-blue-600 rounded hover:bg-blue-700"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 2a8 8 0 00-7.938 7H1l3.5 4L8 9H5.067A6 6 0 1110 16a1 1 0 000 2 8 8 0 100-16z" clip-rule="evenodd" />
                            </svg>
                            Réinitialiser
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tableau -->
            <div class="bg-white rounded-lg shadow overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-600 text-white">
                    <tr>
                        <th @click="sortBy('lastname')" class="p-3 text-left cursor-pointer">Nom</th>
                        <th @click="sortBy('category')" class="p-3 text-left cursor-pointer">Catégorie</th>
                        <th @click="sortBy('style')" class="p-3 text-left cursor-pointer">Style</th>
                        <th @click="sortBy('popularity')" class="p-3 text-left cursor-pointer">Popularité</th>
                        <th class="p-3 text-left">Brand</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="worker in workers"
                        :key="worker.id"
                        class="hover:bg-gray-50 border-t"
                    >
                        <td class="p-3">
                            <button @click="openModal(worker)" class="text-blue-600 hover:underline">
                                {{ worker.firstname }} {{ worker.lastname }}
                            </button>
                        </td>
                        <td class="p-3">{{ worker.category }}</td>
                        <td class="p-3">{{ worker.style }}</td>
                        <td class="p-3">{{ worker.popularity }}</td>
                        <td class="p-3">{{ worker.current_contract?.brand?.name ?? 'Libre' }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Modal -->
            <WorkerModal
                :show="showModal"
                :worker="selectedWorker"
                @close="showModal = false"
            />
        </div>
    </AuthenticatedLayout>
</template>
