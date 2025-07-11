<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, usePage, router } from '@inertiajs/vue3'
import { onMounted, ref, computed, nextTick } from 'vue'
import Chart from 'chart.js/auto'
import ChartDataLabels from 'chartjs-plugin-datalabels'

Chart.register(ChartDataLabels)

// Props reçues du controller
const props = defineProps({
    brands: Array,
    workers: Array, // workers avec fullName, performanceScore, brand info
})

// 🎯 Pour le select de brand
const selectedBrandId = ref(null)

// Tri et données graphiques
const sortedByBudget = computed(() => [...props.brands].sort((a, b) => b.money - a.money))
const sortedByPopularity = computed(() => [...props.brands].sort((a, b) => b.popularity - a.popularity))

const budgetData = computed(() => ({
    labels: sortedByBudget.value.map(b => b.name),
    datasets: [{
        label: 'Budget',
        data: sortedByBudget.value.map(b => b.money),
        backgroundColor: sortedByBudget.value.map(b => b.color || '#34d399'),
    }],
}))

const popularityData = computed(() => ({
    labels: sortedByPopularity.value.map(b => b.name),
    datasets: [{
        label: 'Popularité',
        data: sortedByPopularity.value.map(b => b.popularity),
        backgroundColor: sortedByPopularity.value.map(b => b.color || '#60a5fa'),
    }],
}))

// CSRF token requis pour POST manuel
const csrfToken = usePage().props.csrf_token

function submitReset() {
    const brandName = props.brands.find(b => b.id === +selectedBrandId.value)?.name || 'cette brand'

    if (confirm(`Confirmer la réinitialisation des stats pour "${brandName}" ?`)) {
        router.post(route('brands.resetStats', selectedBrandId.value), {}, {
            preserveScroll: true,
            onSuccess: () => {
                alert('✅ Statistiques réinitialisées avec succès.')
            }
        })
    }
}

// Canvas refs & charts
const budgetCanvas = ref(null)
const popularityCanvas = ref(null)
let budgetChart = null
let popularityChart = null

function renderChart(canvasEl, data) {
    if (canvasEl.chart) canvasEl.chart.destroy()
    const chart = new Chart(canvasEl.getContext('2d'), {
        type: 'bar',
        data,
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    color: '#333',
                    font: { weight: 'bold' },
                    formatter: Math.round,
                }
            },
            scales: { y: { beginAtZero: true } }
        },
        plugins: [ChartDataLabels]
    })
    canvasEl.chart = chart
}

// 🎨 Render charts on mount
onMounted(() => {
    nextTick(() => {
        renderChart(budgetCanvas.value, budgetData.value)
        renderChart(popularityCanvas.value, popularityData.value)
    })
})

// 📊 Workers filtrés et triés
const rankedWorkers = computed(() => {
    if (!selectedBrandId.value) return []
    return props.workers
        .filter(w => w.brand_id === +selectedBrandId.value)
        .sort((a, b) => b.performanceScore - a.performanceScore)
})

// 🔄 Reset stats
function confirmReset(e) {
    if (!confirm("Confirmer la réinitialisation des statistiques de cette brand ?")) {
        e.preventDefault()
    }
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Dashboard
            </h2>
        </template>

        <div class="p-4 space-y-8">

            <!-- 📊 Graphiques Budget & Popularité -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="border border-green-300 bg-white rounded-lg p-4">
                    <div class="bg-green-100 px-3 py-2 rounded text-green-700 font-semibold mb-2">
                        Classement par Budget
                    </div>
                    <canvas ref="budgetCanvas" class="w-full h-80"></canvas>
                </div>

                <div class="border border-blue-300 bg-white rounded-lg p-4">
                    <div class="bg-blue-100 px-3 py-2 rounded text-blue-700 font-semibold mb-2">
                        Classement par Popularité
                    </div>
                    <canvas ref="popularityCanvas" class="w-full h-80"></canvas>
                </div>
            </div>

            <!-- 🏆 Classement des Workers par Brand -->
            <div class="border border-gray-400 rounded-lg p-4 bg-white dark:bg-gray-800 shadow">
                <div class="flex justify-between items-center mb-4 bg-gray-200 px-3 py-2 rounded text-gray-600 font-semibold">
                    <h3 class="text-lg font-semibold">
                        Classement par Promotion
                    </h3>
                    <select v-model="selectedBrandId" class="border rounded px-2 py-1">
                        <option value="">-- Sélectionner une brand --</option>
                        <option v-for="b in props.brands" :key="b.id" :value="b.id">{{ b.name }}</option>
                    </select>
                </div>

                <div v-if="rankedWorkers.length">
                    <table class="w-full text-sm border-collapse">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-white">
                        <tr>
                            <th class="p-2 border">#</th>
                            <th class="p-2 border">Worker</th>
                            <th class="p-2 border">Score</th>
                            <th class="p-2 border">W / D / L</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(w, idx) in rankedWorkers" :key="w.id" class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="p-2 border">{{ idx + 1 }}</td>
                            <td class="p-2 border">
                                <Link :href="route('workers.show', w.id)" class="text-blue-600 hover:underline">
                                    {{ w.fullName }}
                                </Link>
                            </td>
                            <td class="p-2 border">{{ w.performanceScore }}</td>
                            <td class="p-2 border">{{ w.wins }} / {{ w.draws }} / {{ w.losses }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <p v-else class="text-gray-500 dark:text-gray-400 text-center py-6">
                    Sélectionnez une brand pour afficher son classement.
                </p>

                <div v-if="selectedBrandId" class="mt-4 flex justify-end">
                    <form
                        :action="route('brands.resetStats', selectedBrandId)"
                        method="POST"
                        @submit.prevent="submitReset"
                    >
                        <input type="hidden" name="_token" :value="csrfToken">
                        <button type="submit" class="text-sm text-red-600 hover:underline">
                            🔄 Réinitialiser les stats de cette brand
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>
