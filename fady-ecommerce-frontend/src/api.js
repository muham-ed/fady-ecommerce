import axios from 'axios'

const token = localStorage.getItem('token')
const api = axios.create({
  baseURL: import.meta.env.VITE_API_BASE || 'http://localhost:8000/api/v1',
  withCredentials: true,
})
if (token) {
  api.defaults.headers.common['Authorization'] = `Bearer ${token}`
}

export default api
