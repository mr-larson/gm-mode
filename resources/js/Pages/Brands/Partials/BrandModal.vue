<script setup>
import { onMounted, onBeforeUnmount, computed } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    show: Boolean,
    brand: Object,
})

const emit = defineEmits(['close'])

function handleEscape(event) {
    if (event.key === 'Escape') emit('close')
}

onMounted(() => document.addEventListener('keydown', handleEscape))
onBeforeUnmount(() => document.removeEventListener('keydown', handleEscape))

const topWorkers = computed(() => {
    if (!props.brand?.workers) return []
    return [...props.brand.workers]
        .sort((a, b) => b.performanceScore - a.performanceScore)
        .slice(0, 3)
})
</script>

<template>
    <div
        v-if="show"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm"
        @click.self="emit('close')"
    >
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-2xl w-full mx-4 overflow-hidden">
            <!-- Header -->
            <div class="border-b p-4 bg-slate-700 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-lg font-semibold">{{ brand.name }}</h2>
                        <p v-if="brand.description" class="text-sm text-slate-200 mt-1">
                            {{ brand.description }}
                        </p>
                    </div>
                    <button @click="emit('close')" class="text-white hover:text-gray-300 text-2xl leading-none">
                        &times;
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-800 dark:text-gray-100">
                <div>
                    <p><strong>Style :</strong> {{ brand.style }}</p>
                    <p><strong>Popularité :</strong> {{ brand.popularity }}</p>
                    <p><strong>Budget :</strong> {{ brand.money }}</p>
                    <p><strong>Fondé :</strong> {{ brand.founded_formatted }}</p>
                    <p><strong>Booker :</strong> {{ brand.booker }}</p>
                </div>
                <div>
                    <p><strong>Propriétaire :</strong> {{ brand.owner }}</p>
                    <p><strong>Basé à :</strong> {{ brand.based_in }}</p>
                    <p><strong>Pays :</strong> {{ brand.country }}</p>
                    <p><strong>Workers :</strong> {{ brand.workers_count }}</p>
                    <p><strong>ID :</strong> #{{ brand.id }}</p>
                </div>
            </div>

            <!-- Top Performers -->
            <div v-if="topWorkers.length" class="px-4 pb-4 text-sm text-slate-700 dark:text-slate-100">
                <h3 class="mt-4 mb-2 text-md font-semibold border-t pt-2">
                    ⭐ Top Performers
                </h3>
                <ul class="space-y-1">
                    <li v-for="(w, idx) in topWorkers" :key="w.id" class="flex justify-between">
                        <span>
                            {{ idx + 1 }}.
                            <span>
                                {{ w.firstname }} {{ w.lastname }}
                            </span>
                        </span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ w.performanceScore }} pts ({{ w.wins }}/{{ w.draws }}/{{ w.losses }})
                        </span>
                    </li>
                </ul>
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
