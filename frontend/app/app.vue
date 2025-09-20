<template>
  <div class="min-h-screen bg-gray-50 py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
        <h1 class="text-3xl font-extrabold text-gray-900">Employees</h1>

        <div class="flex gap-3 flex-wrap">
          <select
              v-model="employeeStore.department"
              @change="employeeStore.setDepartment(employeeStore.department)"
              class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
          >
            <option :value="null">All Departments</option>
            <option
                v-for="dept in employeeStore.departments"
                :key="dept.id"
                :value="dept.id"
            >
              {{ dept.department }}
            </option>
          </select>

          <select
              v-model="employeeStore.sort"
              @change="employeeStore.setSort(employeeStore.sort)"
              class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
          >
            <option value="asc">Sort A–Z</option>
            <option value="desc">Sort Z–A</option>
          </select>
        </div>
      </div>

      <div v-if="employeeStore.loading" class="text-center text-gray-500 py-12 text-lg">
        Loading employees...
      </div>

      <div v-else-if="employeeStore.error" class="text-center text-red-500 py-12 text-lg">
        {{ employeeStore.error }}
      </div>

      <div v-else-if="employeeStore.employees.length === 0" class="text-center text-gray-400 py-12 text-lg">
        No employees found.
      </div>

      <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <template
            v-for="employee in employeeStore.employees"
            :key="employee.id"
        >
          <Employee :employee="employee" />
        </template>
      </div>

      <div class="flex items-center justify-between mt-8">
        <button
            class="px-5 py-2 rounded-lg bg-white border border-gray-300 text-gray-700 shadow-sm hover:bg-gray-100 disabled:opacity-50 transition"
            :disabled="employeeStore.page === 1"
            @click="employeeStore.setPage(employeeStore.page - 1)"
        >
          Prev
        </button>

        <span class="text-gray-600 text-sm">
          Page {{ employeeStore.page }} of {{ employeeStore.lastPage }} | Total: {{ employeeStore.total }}
        </span>

        <button
            class="px-5 py-2 rounded-lg bg-white border border-gray-300 text-gray-700 shadow-sm hover:bg-gray-100 disabled:opacity-50 transition"
            :disabled="employeeStore.page >= employeeStore.lastPage"
            @click="employeeStore.setPage(employeeStore.page + 1)"
        >
          Next
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useEmployeeStore } from '@/stores/employee'
import Employee from "./components/Employee.vue";

const employeeStore = useEmployeeStore()

onMounted(() => {
  employeeStore.fetchDepartments()
  employeeStore.fetchEmployees()
})
</script>
