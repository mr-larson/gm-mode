<script setup>
import { onMounted, onBeforeUnmount } from 'vue'

const props = defineProps({
    show: Boolean,
    worker: Object,
})

const emit = defineEmits(['close'])

function handleEscape(event) {
    if (event.key === 'Escape') emit('close')
}

onMounted(() => document.addEventListener('keydown', handleEscape))
onBeforeUnmount(() => document.removeEventListener('keydown', handleEscape))
</script>

<template>
    <div
        v-if="show"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm"
        @click.self="emit('close')"
    >
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-2xl w-full mx-4 overflow-hidden">
            <!-- Header -->
            <div class="flex justify-between items-center border-b p-4 bg-slate-700 text-white">
                <h2 class="text-lg font-semibold">
                    {{ worker.fullName }}
                </h2>
                <button @click="emit('close')" class="text-white hover:text-gray-300">
                    &times;
                </button>
            </div>

            <!-- Content -->
            <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-800 dark:text-gray-100">
                <div>
                    <p><strong>Surnom :</strong> {{ worker.nickname || 'N/A' }}</p>
                    <p><strong>Genre :</strong> {{ worker.gender }}</p>
                    <p><strong>Âge :</strong> {{ worker.age }}</p>
                    <p><strong>Catégorie :</strong> {{ worker.category }}</p>
                    <p><strong>Style :</strong> {{ worker.style }}</p>
                    <p><strong>Alignement :</strong> {{ worker.alignment }}</p>
                    <p><strong>Statut :</strong> {{ worker.status }}</p>
                </div>

                <div>
                    <p><strong>Taille :</strong> {{ worker.height }} cm</p>
                    <p><strong>Poids :</strong> {{ worker.weight }} kg</p>
                    <p><strong>Popularité :</strong> {{ worker.popularity }}</p>
                    <p><strong>Promo :</strong> {{ worker.promo_skill }}</p>
                    <p><strong>Endurance :</strong> {{ worker.endurance }}</p>
                    <p><strong>Overall :</strong> {{ worker.overall }}</p>
                    <p><strong>W/D/L :</strong> {{ worker.wins }} / {{ worker.draws }} / {{ worker.losses }}</p>
                    <p><strong>Brand :</strong>
                        {{ worker.current_contract?.brand?.name ?? 'Libre' }}
                    </p>
                </div>
            </div>

            <div v-if="worker.note" class="px-4 pb-4 text-gray-700 dark:text-gray-300 text-sm">
                <p class="mt-2 border-t pt-2 whitespace-pre-line">
                    {{ worker.note }}
                </p>
            </div>

            <!-- Footer -->
            <div class="flex justify-end border-t px-4 py-2 bg-gray-50 dark:bg-gray-700">
                <button
                    @click="emit('close')"
                    class="px-4 py-1 text-sm font-medium bg-blue-600 text-white rounded hover:bg-blue-700"
                >
                    Fermer
                </button>
            </div>
        </div>
    </div>
</template>
