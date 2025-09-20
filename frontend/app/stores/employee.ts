import { defineStore } from 'pinia'
import {useNuxtApp} from "nuxt/app";
import type {Employee, Department} from "@/types/types";

export const useEmployeeStore = defineStore('employee', () => {
    const { $api } = useNuxtApp()
    const employees = ref<Employee[]>([])
    const departments = ref<Department[]>([])
    const loading = ref(false)
    const error = ref<string | null>(null)

    const page = ref(1)
    const perPage = ref(10)
    const total = ref(0)
    const lastPage = ref(1)

    const department = ref<number|null>(null)
    const sort = ref<'asc' | 'desc'>('asc')

    const fetchEmployees = async () => {
        loading.value = true
        error.value = null

        try {
            const { data } = await $api.get('/employees', {
                params: {
                    page: page.value,
                    per_page: perPage.value,
                    department_id: department.value,
                    sort: sort.value,
                },
            })

            // Paginated response from Laravel
            employees.value = data.data.data
            total.value = data.data.total
            lastPage.value = data.data.last_page
            page.value = data.data.current_page
            perPage.value = data.data.per_page
        } catch (err: any) {
            error.value = err.response?.data?.message || 'Failed to fetch employees'
        } finally {
            loading.value = false
        }
    }

    const fetchDepartments = async () => {
        try {
            const { data } = await $api.get('/departments')
            departments.value = data.data
        } catch (err) {
            console.error('Failed to load departments', err)
        }
    }

    const setDepartment = async (deptId: number | null) => {
        department.value = deptId
        page.value = 1
        await fetchEmployees()
    }

    const setSort = async (order: 'asc' | 'desc') => {
        sort.value = order
        page.value = 1
        await fetchEmployees()
    }

    const setPage = async (newPage: number) => {
        if (newPage < 1 || newPage > lastPage.value) return
        page.value = newPage
        await fetchEmployees()
    }

    return {
        employees,
        departments,
        loading,
        error,
        page,
        perPage,
        total,
        lastPage,
        department,
        sort,
        fetchEmployees,
        fetchDepartments,
        setDepartment,
        setSort,
        setPage,
    }
})
