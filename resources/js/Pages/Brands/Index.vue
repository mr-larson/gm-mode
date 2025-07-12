<script setup>
import { Head, Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue"
import BrandModal from './Partials/BrandModal.vue'

defineProps({
    brands: Array,
})

const showModal = ref(false)
const selectedBrand = ref(null)

function openModal(brand) {
    selectedBrand.value = brand
    showModal.value = true
}

</script>

<template>
    <Head title="Brands" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Promotions
            </h2>
        </template>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    v-for="brand in brands"
                    :key="brand.id"
                    class="rounded-xl bg-white shadow hover:shadow-md transition border-l-8 p-4"
                    :style="{ borderColor: brand.color ?? '#888' }"
                >
                    <!-- Header -->
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-bold text-slate-700">
                            {{ brand.name }}
                        </h2>
                        <span
                            class="inline-block w-3 h-3 rounded-full"
                            :style="{ backgroundColor: brand.color ?? '#888' }"
                        ></span>
                    </div>

                    <!-- Description -->
                    <p class="text-sm text-gray-500 mt-1 line-clamp-2">
                        {{ brand.description || 'Aucune description disponible.' }}
                    </p>

                    <!-- Stats -->
                    <div class="mt-4 grid grid-cols-2 gap-3 text-sm text-slate-600">
                        <p><strong>Popularité :</strong> {{ brand.popularity }}</p>
                        <p><strong>Style :</strong> {{ brand.style }}</p>
                        <p><strong>Workers :</strong> {{ brand.workers_count }}</p>
                        <p><strong>Budget :</strong> {{ brand.money }}</p>
                    </div>

                    <!-- Action -->
                    <!-- Action -->
                    <div class="mt-4 text-right">
                        <button
                            @click="openModal(brand)"
                            class="text-sm px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                        >
                            Voir détails →
                        </button>
                    </div>
                </div>
            </div>

            <!-- 📌 Modal -->
            <BrandModal
                :show="showModal"
                :brand="selectedBrand"
                @close="showModal = false"
            />
        </div>
    </AuthenticatedLayout>
</template>
