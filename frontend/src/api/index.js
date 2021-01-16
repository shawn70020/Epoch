import epochApi from './axios';

export const apiUserSignUp = params => epochApi.post('/signin', params);