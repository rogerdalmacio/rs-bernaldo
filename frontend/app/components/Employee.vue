<template>
  <div
      class="bg-white rounded-2xl shadow hover:shadow-lg transition p-6 flex flex-col gap-3 border border-gray-200"
  >
    <!-- Top row: Avatar + Name + Role -->
    <div class="flex items-start justify-between gap-3">
      <div class="flex items-center gap-3">
        <!-- Avatar -->
        <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-800 font-bold text-lg">
          {{ employee.name.charAt(0).toUpperCase() }}
        </div>

        <div>
          <h2 class="text-lg font-semibold text-gray-900 truncate">{{ employee.name }}</h2>
          <div class="text-sm text-gray-500">{{ employee.department?.department || 'N/A' }}</div>
        </div>
      </div>
    </div>

    <!-- Department info -->
    <div class="text-sm text-gray-500 flex items-center gap-2 mt-1">
      <span class="font-medium text-gray-700">Department:</span>
      <span>{{ employee.department?.department || 'N/A' }}</span>
    </div>

    <!-- Projects as badges -->
    <div class="flex flex-wrap gap-2 mt-2">
    <span
        v-for="project in employee.projects || []"
        :key="project.id"
        class="inline-block bg-gray-100 text-gray-800 text-xs font-medium px-2 py-1 rounded-full"
    >
      {{ project.project }} - <strong>{{ project.role }}</strong>
    </span>
    </div>
  </div>
</template>

<script setup lang="ts">
import type {Employee} from "../types/types";

const props = defineProps<{
  employee: Employee
}>()
</script>