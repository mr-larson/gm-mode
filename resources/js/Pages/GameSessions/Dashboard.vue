<template>
    <div class="p-6 space-y-6">
        <h1 class="text-3xl font-bold">🎮 Session : {{ session.name }}</h1>
        <p class="text-gray-500">Semaine {{ session.week }}, Année {{ session.year }}</p>


        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div
                v-for="pivot in session.pivotBrands"
                :key="pivot.id"
                class="border p-2"
            >
                <p>Pivot ID: {{ pivot.id }}</p>
                <p>Brand: {{ pivot.brand?.name || 'brand manquant' }}</p>
                <p>Nb workers: {{ pivot.brand?.workers?.length ?? 'non défini' }}</p>
            </div>

        </div>
    </div>
</template>

<script setup>
defineProps({
    session: Object
})
</script>
