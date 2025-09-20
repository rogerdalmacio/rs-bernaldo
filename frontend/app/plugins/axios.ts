import axios from 'axios'
import { useRuntimeConfig } from '#app'
import {defineNuxtPlugin} from "nuxt/app";

export default defineNuxtPlugin(() => {
    const config = useRuntimeConfig()

    // Create Axios instance with baseURL from .env
    const api = axios.create({
        baseURL: config.public.apiBase,
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
    })

    api.interceptors.request.use((request) => {
        return request
    })

    api.interceptors.response.use(
        (response) => response,
        (error) => {
            const status = error.response?.status

            switch (status) {
                case 401:
                    alert('Unauthorized. Please login again.')
                    break
                case 422:
                    alert('Validation failed.')
                    break
                case 500:
                    alert('Server error. Please try again later.')
                    break
                default:
                    alert(error.response?.data?.message || 'An error occurred.')
            }

            return Promise.reject(error)
        }
    )


    return {
        provide: {
            api,   // accessible as $api
        },
    }
})
