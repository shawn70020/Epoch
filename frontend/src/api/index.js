import epochApi from './axios';
//Get
export const MenProducts = () => epochApi.get('/products/men');
export const ProductsPage = (sex,page) => epochApi.get(`/products/${sex}/page=${page}`);
//Post
export const UserSignUp = params => epochApi.post('/signin', params);
export const UserLogin = params => epochApi.post('/login', params);
