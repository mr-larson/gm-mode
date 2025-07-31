<script setup>
import { ref, computed } from 'vue'
import {Head, router} from '@inertiajs/vue3'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    session: Object,
    available: Array,
})

const pick = ref(null)

const currentHumanSlot = computed(() =>
    props.session.pivotBrands.find(slot => slot.is_human && !slot.worker)
)

function nextStepIA() {
    console.log('Lancement IA...');
    router.post(route('sessions.draft.next', props.session.id))
}

function submit(order) {
    if (!pick.value) return
    router.post(route('sessions.draft.pick', props.session.id), {
        draft_order: order,
        worker_id: pick.value,
    })
}
</script>

<template>
    <Head title="Nouvelle partie" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Nouvelle Partie
            </h2>
        </template>
    <div class="p-6 grid grid-cols-12 gap-6 min-h-screen bg-gray-900 text-white">
        <!-- Colonne de gauche -->
        <div class="col-span-4 space-y-4">
            <h2 class="text-xl font-bold border-b border-gray-700 pb-2">Ordre de Draft</h2>
            <div v-for="slot in session.pivotBrands" :key="slot.draft_order"
                 class="bg-gray-800 p-4 rounded shadow flex justify-between items-center">
                <div>
                    <div class="text-sm font-semibold text-gray-400">
                        #{{ slot.draft_order }} — {{ slot.brand.name }}
                        <span class="ml-2 text-xs text-gray-500">
              ({{ slot.is_human ? 'Vous' : 'IA' }})
            </span>
                    </div>
                    <div class="mt-1 text-white font-medium">
                        {{ slot.worker ? slot.worker.fullName : '— en attente —' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonne de droite -->
        <div class="col-span-8 space-y-4">
            <h2 class="text-xl font-bold border-b border-gray-700 pb-2">Catcheurs disponibles</h2>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <div v-for="worker in available" :key="worker.id"
                     @click="pick = worker.id"
                     :class="['cursor-pointer rounded overflow-hidden transition transform hover:scale-105',
                      pick === worker.id ? 'ring-2 ring-blue-500' : '']">
                    <div class="bg-gray-800 hover:bg-gray-700 p-3 h-full flex flex-col items-center text-center">
                        <img v-if="worker.image" :src="worker.image" alt="photo"
                             class="w-20 h-20 object-cover rounded-full mb-2 border border-gray-600">
                        <div class="font-semibold">{{ worker.fullName }}</div>
                        <div class="text-sm text-gray-400">Overall : {{ worker.overall }}</div>
                    </div>
                </div>
            </div>

            <div v-if="currentHumanSlot" class="text-right">
                <button @click="submit(currentHumanSlot.draft_order)"
                        class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Confirmer le choix
                </button>
            </div>
            <button
                v-if="!currentHumanSlot"
                @click="router.post(route('sessions.draft.next', session.id))"
                class="ml-4 px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700"
            >
                Continuer (IA)
            </button>
        </div>
    </div>
    </AuthenticatedLayout>
</template>
