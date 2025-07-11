<script setup>
defineProps({
    brand: Object,
})
</script>

<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold">{{ brand.name }}</h1>
        <p class="text-gray-600 mb-4">{{ brand.description }}</p>

        <h2 class="text-lg font-semibold mt-6 mb-2">Workers</h2>
        <table class="w-full table-auto border text-sm">
            <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-2 border">Nom</th>
                <th class="p-2 border">Style</th>
                <th class="p-2 border">Catégorie</th>
                <th class="p-2 border">Popularité</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="worker in brand.workers" :key="worker.id">
                <td class="p-2 border">
                    {{ worker.firstname }} {{ worker.lastname }}
                </td>
                <td class="p-2 border">{{ worker.style }}</td>
                <td class="p-2 border">{{ worker.category }}</td>
                <td class="p-2 border">{{ worker.popularity }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
