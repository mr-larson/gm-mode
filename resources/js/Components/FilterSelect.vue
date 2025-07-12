<template>
    <div class="flex items-center gap-2">
        <label class="text-sm font-medium text-gray-700">{{ label }}</label>
        <select
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            @change="onChange"
            class="block w-40 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
        >
            <option :value="''">{{ placeholder }}</option>
            <option
                v-for="item in options"
                :key="item.value"
                :value="item.value"
                :style="item.color ? { backgroundColor: item.color, color: '#fff' } : {}"
            >
                {{ item.label }}
            </option>
        </select>
    </div>
</template>

<script setup>
defineProps({
    label: String,
    modelValue: [String, Number],
    options: {
        type: Array,
        default: () => [],
    },
    placeholder: {
        type: String,
        default: '-- Tous --',
    },
    onChange: Function,
})

defineEmits(['update:modelValue'])
</script>
