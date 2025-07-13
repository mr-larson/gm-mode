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

// Pour le select de brand
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

// Render charts on mount
onMounted(() => {
    nextTick(() => {
        renderChart(budgetCanvas.value, budgetData.value)
        renderChart(popularityCanvas.value, popularityData.value)
    })
})

// Workers filtrés et triés
const rankedWorkers = computed(() => {
    if (!selectedBrandId.value) return []
    return props.workers
        .filter(w => w.current_contract?.brand_id === +selectedBrandId.value)
        .sort((a, b) => b.performanceScore - a.performanceScore)
})

// Reset stats
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
            <h2 class="text-xl font-semibold leading-tight text-slate-700 dark:text-slate-200">
                Tableau de bord
            </h2>
        </template>

        <div class="p-6 space-y-10">

            <!-- Graphiques -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="rounded-xl bg-white border-l-8 shadow p-4" style="border-color: #10b981">
                    <h3 class="text-lg font-semibold text-green-700 mb-2">
                        Classement par Budget
                    </h3>
                    <canvas ref="budgetCanvas" class="w-full h-80"></canvas>
                </div>

                <div class="rounded-xl bg-white border-l-8 shadow p-4" style="border-color: #3b82f6">
                    <h3 class="text-lg font-semibold text-blue-700 mb-2">
                        Classement par Popularité
                    </h3>
                    <canvas ref="popularityCanvas" class="w-full h-80"></canvas>
                </div>
            </div>

            <!-- Classement par Brand -->
            <div class="bg-white dark:bg-gray-800 border-l-8 border-slate-600 rounded-xl shadow p-6">
                <div class="flex flex-wrap justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-slate-700 dark:text-slate-100">
                        🏆 Top Performers par Promotion
                    </h3>

                    <select v-model="selectedBrandId" class="border rounded px-3 py-1 text-sm">
                        <option value="">-- Sélectionner une promotion --</option>
                        <option v-for="b in props.brands" :key="b.id" :value="b.id">{{ b.name }}</option>
                    </select>
                </div>

                <div v-if="rankedWorkers.length">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-x-auto">
                        <table class="min-w-full text-sm text-slate-700 dark:text-gray-200">
                            <thead class="bg-slate-600 text-white">
                            <tr>
                                <th class="p-2 text-left">#</th>
                                <th class="p-2 text-left">Worker</th>
                                <th class="p-2 text-left">Score</th>
                                <th class="p-2 text-left">W / D / L</th>
                                <th class="p-2 text-left">Fatigue</th>
                                <th class="p-2 text-left">Overall</th>
                                <th class="p-2 text-left">Popularité</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(w, idx) in rankedWorkers" :key="w.id" class="hover:bg-slate-50 dark:hover:bg-slate-700">
                                <td class="p-2">{{ idx + 1 }}</td>
                                <td class="p-2">
                                    <Link :href="route('workers.show', w.id)" class="text-blue-600 hover:underline">
                                        {{ w.fullName }}
                                    </Link>
                                </td>
                                <td class="p-2">{{ w.performanceScore }}</td>
                                <td class="p-2">{{ w.wins }} / {{ w.draws }} / {{ w.losses }}</td>
                                <td class="p-3">
                            <span
                                class="inline-block px-2 py-1 rounded text-xs font-medium"
                                :class="{
                                    'bg-green-100 text-green-800': w.endurance >= 70,
                                    'bg-yellow-100 text-yellow-800': w.endurance >= 40 && w.endurance < 70,
                                    'bg-red-100 text-red-800': w.endurance < 40,
                                }"
                                :title="`${w.endurance ?? 'Inconnu'} d’endurance`"
                            >
                                {{ w.endurance ?? '—' }}
                            </span>
                                </td>
                                <td class="p-2">{{ w.overall }}</td>
                                <td class="p-2">{{ w.popularity }}</td>
                            </tr>
                            </tbody>
                    </table>
                    </div>
                </div>

                <p v-else class="text-gray-500 dark:text-gray-400 text-center py-6">
                    Sélectionnez une promotion pour afficher les meilleurs workers.
                </p>

                <!-- Bouton de reset -->
                <div v-if="selectedBrandId" class="mt-4 text-right">
                    <form
                        :action="route('brands.resetStats', selectedBrandId)"
                        method="POST"
                        @submit.prevent="submitReset"
                    >
                        <input type="hidden" name="_token" :value="csrfToken">
                        <button
                            type="submit"
                            class="text-sm text-red-600 hover:underline"
                        >
                            🔄 Réinitialiser les stats de cette promotion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
