<script setup>
import { ref } from 'vue'
import { Head, router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const props = defineProps({
    brands: Array,
})

const name           = ref('')
const selectedBrand  = ref(null)
const errors         = ref({})

function startSession() {
    // on vide d’éventuelles erreurs précédentes
    errors.value = {}

    router.post(route('sessions.store'), {
        name:      name.value,
        brand_id:  selectedBrand.value,
    }, {
        onError: (errs) => {
            // errs est un objet { name: [...], brand_id: [...] }
            errors.value = errs
        }
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

        <div class="mt-6 max-w-2xl mx-auto p-6 space-y-6 bg-white rounded-lg shadow">

            <!-- Nom de la session -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Nom de la session</label>
                <input
                    v-model="name"
                    type="text"
                    class="w-full mt-1 border rounded p-2"
                />
                <p v-if="errors.name" class="text-red-600 text-sm">
                    {{ errors.name[0] }}
                </p>
            </div>

            <!-- Sélection de la brand -->
            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Choisir une Brand
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                    <div
                        v-for="brand in props.brands"
                        :key="brand.id"
                        class="border rounded p-3 cursor-pointer hover:shadow transition"
                        :class="{ 'ring-2 ring-blue-500': selectedBrand === brand.id }"
                        @click="selectedBrand = brand.id"
                    >
                        <h3 class="text-lg font-semibold">{{ brand.name }}</h3>
                        <p class="text-sm text-gray-500">
                            💰 Budget : {{ brand.money }} — ⭐ Popularité : {{ brand.popularity }}
                        </p>
                    </div>
                </div>
                <p v-if="errors.brand_id" class="text-red-600 text-sm mt-1">
                    {{ errors.brand_id[0] }}
                </p>
            </div>

            <!-- Bouton démarrer -->
            <div class="text-right">
                <button
                    @click="startSession"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                >
                    🚀 Démarrer
                </button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
