export interface Department {
    id: number
    department: string
    created_at?: string
    updated_at?: string
}

export interface Project {
    id: number
    project: string
    role: string
    created_at?: string
    updated_at?: string
}

export interface Employee {
    id: number
    name: string
    department_id?: number
    department?: Department
    projects?: Project[]
    role?: string
    created_at?: string
    updated_at?: string
}