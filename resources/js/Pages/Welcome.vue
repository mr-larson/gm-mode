<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3'

const { auth, canLogin, canRegister } = usePage().props
const user = auth.user
</script>

<template>
    <Head title="Accueil – GM Mode" />

    <div class="min-h-screen flex flex-col bg-gray-50 dark:bg-gray-900">
        <!-- Header simplifié -->
        <header class="py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">GM Mode</h1>
            <nav class="space-x-4">
                <Link
                    v-if="user"
                    href="/sessions"
                    class="text-gray-700 dark:text-gray-200 hover:underline"
                >
                    Sessions
                </Link>
                <Link
                    v-else-if="canLogin"
                    :href="route('login')"
                    class="text-gray-700 dark:text-gray-200 hover:underline"
                >
                    Connexion
                </Link>
                <Link
                    v-if="!user && canRegister"
                    :href="route('register')"
                    class="text-gray-700 dark:text-gray-200 hover:underline"
                >
                    Inscription
                </Link>
            </nav>
        </header>

        <!-- Main minimaliste -->
        <main class="flex flex-grow items-center justify-center px-4">
            <div class="max-w-xl text-center">
                <h2 class="text-4xl font-extrabold mb-4 text-gray-800 dark:text-gray-100">
                    Bienvenue dans GM Mode
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">
                    Gérez votre promotion de catch, construisez votre carte, vendez des shows et créez votre légende.
                </p>

                <div class="space-x-4">
                    <Link
                        v-if="user"
                        href="/sessions"
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium shadow"
                    >
                        ▶️ Accéder aux Sessions
                    </Link>

                    <Link
                        v-else
                        :href="route('login')"
                        class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-md font-medium shadow"
                    >
                        🔐 Se connecter
                    </Link>
                </div>
            </div>
        </main>

        <!-- Footer simple -->
        <footer class="py-4 text-center text-sm text-gray-500 dark:text-gray-400">
            © {{ new Date().getFullYear() }} GM Mode
        </footer>
    </div>
</template>
