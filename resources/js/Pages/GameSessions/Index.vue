<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Menu principal" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-4">
                <h2 class="text-xl font-semibold leading-tight text-slate-700 dark:text-slate-200">
                    Menu
                </h2>
            </div>
        </template>

        <div class="mt-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row">
                    <!-- Image à gauche -->
                    <div class="hidden md:block flex-1 p-2 bg-contain bg-center bg-no-repeat" style="background-image: url('/images/AWA.png')">
                    </div>

                    <!-- Boutons à droite -->
                    <div class="flex-1 p-2 flex flex-col">
                        <h1 class="text-slate-700 mb-2">GM Mode Wrestling</h1>
                        <h2 class="text-3xl font-bold text-slate-600 mb-6">Choisissez une option</h2>

                        <div class="h-64 mt-6 flex flex-col items-center md:items-start justify-between">
                            <Link
                                :href="route('sessions.create')"
                                class="w-60 h-12 bg-teal-300 hover:bg-teal-400 text-xl text-teal-800 font-bold text-center py-2 px-5 border-2 border-teal-600 rounded-full drop-shadow-md"
                            >
                                Nouvelle Partie
                            </Link>

                            <button
                                class="w-60 h-12 bg-sky-300 hover:bg-sky-400 text-xl text-sky-800 font-bold py-2 px-5 border-2 border-sky-600 rounded-full drop-shadow-md"
                                disabled
                            >
                                Charger Partie
                            </button>

                            <Link
                                :href="route('brands.index')"
                                class="w-60 h-12 bg-purple-300 hover:bg-purple-400 text-xl text-purple-800 font-bold text-center py-2 px-5 border-2 border-purple-600 rounded-full drop-shadow-md"
                            >
                                Éditer les Données
                            </Link>
                        </div>
                    </div>
                </div>

                <div class="h-32 p-2 flex items-end justify-center text-l font-bold text-slate-400">
                    Merci d'utiliser GM Mode Wrestling
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
