<template>
    <div>
        <h2>Login</h2>
        <input v-model="login" placeholder="Login" />
        <input v-model="password" type="password" placeholder="Password" />
        <button @click="loginUser">Login</button>
        <p v-if="error">{{ error }}</p>
    </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue';
import { api } from '@/api/axios';
import { isAxiosError } from 'axios';
import { authService } from '@/services/authService';
import { useRouter } from 'vue-router';

export default defineComponent({
    setup() {
        const login = ref<string>('');
        const password = ref<string>('');
        const error = ref<string>('');
        const router = useRouter();

        const loginUser = async () => {
            try {
                await  authService.login({ login: login.value, password: password.value });
                router.push({name: 'statistic'});
                error.value = '';
            } catch (err: unknown) {
                if (isAxiosError(err)) {
                    switch (err.response?.status) {
                        case 401:
                        case 422:
                            error.value = 'Неверные учетные данные';
                            break;
                        default:
                            error.value = 'Произошла ошибка. Попробуйте еще раз.';
                            break;
                    }
                } else {
                    error.value = 'Сетевая ошибка.';
                }
            }
        };

        return {
            login,
            password,
            error,
            loginUser,
        };
    },
});
</script>