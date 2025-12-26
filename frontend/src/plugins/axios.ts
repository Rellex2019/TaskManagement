import type { App } from 'vue';
import axios, { api } from '@/api/axios';

export default {
  install: (app: App) => {
    app.config.globalProperties.$axios = axios;
    app.provide('axios', axios);
    
    app.config.globalProperties.$api = api;
    app.provide('api', api);
  },
};
