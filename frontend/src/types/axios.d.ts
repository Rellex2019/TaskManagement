import type { AxiosInstance } from 'axios';

declare module 'axios' {
    export interface AxiosRequestConfig {
    }
  }
  
  declare module '@vue/runtime-core' {
    interface ComponentCustomProperties {
      $axios: typeof import('axios').default;
      $api: AxiosInstance;
    }
  }

export {};