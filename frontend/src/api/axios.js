import axios from 'axios';
const epochApi = axios.create({
    baseURL: 'https://spa.test/api',
    headers: { 'Content-Type': 'application/json' },
});
export default epochApi;