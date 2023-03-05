import axios from 'axios';
import {auth} from "./auth";

export const instance = axios.create({
  baseURL: process.env.REACT_APP_API_URL,
});

instance.interceptors.request.use(
  (request) => {
    instance.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    const token = auth.getToken()

    if (token) {
      request.headers.Authorization = `Bearer ${token}`;
    }

    return request;
  },
  (error) => Promise.resolve(error)
);