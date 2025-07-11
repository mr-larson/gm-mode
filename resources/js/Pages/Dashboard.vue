<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'
import { onMounted, ref, computed, nextTick } from 'vue'
import Chart from 'chart.js/auto'
import ChartDataLabels from 'chartjs-plugin-datalabels'

Chart.register(ChartDataLabels)

const props = defineProps({
    brands: Array,
})

// 🎯 Tri des brands
const sortedByBudget = computed(() => [...props.brands].sort((a, b) => b.money - a.money))
const sortedByPopularity = computed(() => [...props.brands].sort((a, b) => b.popularity - a.popularity))

// 📊 Données graphiques
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

// 🖼️ Références canvas
const budgetCanvas = ref(null)
const popularityCanvas = ref(null)

let budgetChart = null
let popularityChart = null

// 📈 Création du graphique
function renderChart(canvas, data, chartRef) {
    const ctx = canvas.getContext('2d')
    if (chartRef) {
        chartRef.destroy()
    }

    return new Chart(ctx, {
        type: 'bar',
        data: data,
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
            scales: {
                y: { beginAtZero: true }
            }
        },
        plugins: [ChartDataLabels]
    })
}

// 🔄 On mount
onMounted(() => {
    nextTick(() => {
        if (budgetCanvas.value && popularityCanvas.value) {
            budgetChart = renderChart(budgetCanvas.value, budgetData.value, budgetChart)
            popularityChart = renderChart(popularityCanvas.value, popularityData.value, popularityChart)
        }
    })
})
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Dashboard
            </h2>
        </template>

        <div class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">

                <!-- Budget -->
                <div class="border-2 border-green-300 rounded-lg p-4">
                    <div class="bg-green-100 px-3 py-2 rounded text-green-700 font-semibold mb-2">
                        Classement par Budget
                    </div>
                    <canvas ref="budgetCanvas" class="w-full h-80"></canvas>
                </div>

                <!-- Popularité -->
                <div class="border-2 border-blue-300 rounded-lg p-4">
                    <div class="bg-blue-100 px-3 py-2 rounded text-blue-700 font-semibold mb-2">
                        Classement par Popularité
                    </div>
                    <canvas ref="popularityCanvas" class="w-full h-80"></canvas>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
