<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    worker: Object
})
</script>

<template>
    <div class="p-6 space-y-6">
        <Link href="/workers" class="text-blue-600 hover:underline">&larr; Retour à la liste</Link>

        <h1 class="text-2xl font-bold">{{ worker.firstname }} {{ worker.lastname }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                <p><strong>Victoire/Égalité/Défaites :</strong>
                    {{ worker.wins }} / {{ worker.draws }} / {{ worker.losses }}
                </p>
                <p><strong>Brand :</strong> {{ worker.current_contract?.brand?.name || 'Libre' }}</p>
            </div>
        </div>

        <div v-if="worker.note" class="mt-4">
            <h2 class="font-semibold">Note</h2>
            <p class="text-sm text-gray-700 whitespace-pre-line">{{ worker.note }}</p>
        </div>
    </div>
</template>
