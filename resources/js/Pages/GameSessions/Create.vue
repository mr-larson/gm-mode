<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    brands: Array,
})

const name = ref('')
const selectedBrand = ref(null)
const errors = ref({})

function startSession() {
    router.post('/sessions', {
        name: name.value,
        brand_id: selectedBrand.value,
    }, {
        onError: (err) => {
            errors.value = err
        }
    })
}
</script>

<template>
    <div class="max-w-2xl mx-auto p-6 space-y-6 bg-white rounded-lg shadow">
        <h1 class="text-2xl font-bold text-slate-800">Nouvelle Partie</h1>

        <div>
            <label class="block text-sm font-medium text-gray-700">Nom de la partie</label>
            <input v-model="name" type="text" class="w-full mt-1 border rounded p-2" />
            <p v-if="errors.name" class="text-red-600 text-sm">{{ errors.name }}</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Choisir une Brand</label>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                <div
                    v-for="brand in brands"
                    :key="brand.id"
                    class="border rounded p-3 cursor-pointer hover:shadow transition"
                    :class="{
                        'ring-2 ring-blue-500': selectedBrand === brand.id,
                    }"
                    @click="selectedBrand = brand.id"
                >
                    <h3 class="text-lg font-semibold">{{ brand.name }}</h3>
                    <p class="text-sm text-gray-500">💰 Budget : {{ brand.money }} — ⭐ Popularité : {{ brand.popularity }}</p>
                </div>
            </div>
            <p v-if="errors.brand_id" class="text-red-600 text-sm mt-1">{{ errors.brand_id }}</p>
        </div>

        <div class="text-right">
            <button @click="startSession" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                🚀 Démarrer
            </button>
        </div>
    </div>
</template>
