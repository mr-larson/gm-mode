<script setup>
import { router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import FilterSelect from '@/Components/FilterSelect.vue'
import WorkerModal from './Partials/WorkerModal.vue'

const props = defineProps({
    workers: Array,
    brands: Array,
    categories: Array,
    styles: Array,
    filters: Object,
})

const brandFilter = ref(props.filters.brand_id || '')
const categoryFilter = ref(props.filters.category || '')
const styleFilter = ref(props.filters.style || '')
const sort = ref(props.filters.sort || 'lastname')
const direction = ref(props.filters.direction || 'asc')

const selectedWorker = ref(null)
const showModal = ref(false)

function openModal(worker) {
    selectedWorker.value = worker
    showModal.value = true
}

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
            <div class="flex items-center gap-4">
                <h2 class="text-xl font-semibold leading-tight text-slate-700 dark:text-slate-200">
                    Workers
                </h2>
            </div>
        </template>

        <div class="p-6 space-y-6">
            <!-- Filtres -->
            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow text-slate-600 dark:text-gray-100">
                <div class="flex flex-wrap items-center justify-between gap-6">
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
                    <div v-if="hasActiveFilters">
                        <button
                            @click="resetFilters"
                            class="px-4 py-2 text-sm text-white bg-blue-600 rounded hover:bg-blue-700"
                        >
                            🔄 Réinitialiser
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tableau -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-x-auto">
                <table class="min-w-full text-sm text-slate-700 dark:text-gray-200">
                    <thead class="bg-slate-600 text-white">
                    <tr>
                        <th @click="sortBy('lastname')" class="p-3 text-left cursor-pointer">Nom</th>
                        <th @click="sortBy('category')" class="p-3 text-left cursor-pointer">Catégorie</th>
                        <th @click="sortBy('style')" class="p-3 text-left cursor-pointer">Style</th>
                        <th @click="sortBy('popularity')" class="p-3 text-left cursor-pointer">Popularité</th>
                        <th @click="sortBy('brand')" class="p-3 text-left cursor-pointer">Brand</th>
                        <th @click="sortBy('endurance')" class="p-3 text-left cursor-pointer">Endurance</th>
                        <th @click="sortBy('performanceScore')" class="p-3 text-left cursor-pointer">Score</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="worker in workers"
                        :key="worker.id"
                        class="hover:bg-gray-50 dark:hover:bg-gray-700 border-t"
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
                        <td class="p-3">
                            <span
                                class="inline-block px-2 py-1 rounded text-xs font-medium"
                                :class="{
                                    'bg-green-100 text-green-800': worker.endurance >= 70,
                                    'bg-yellow-100 text-yellow-800': worker.endurance >= 40 && worker.endurance < 70,
                                    'bg-red-100 text-red-800': worker.endurance < 40,
                                }"
                                :title="`${worker.endurance ?? 'Inconnu'} d’endurance`"
                            >
                                {{ worker.endurance ?? '—' }}
                            </span>
                        </td>
                        <td
                            class="p-3"
                            :title="`W/D/L : ${worker.wins} / ${worker.draws} / ${worker.losses}`"
                        >
                            {{ worker.performanceScore }}
                        </td>
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
