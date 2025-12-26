<template>
    <div>
        <h2>Список задач</h2>
        <TaskForm @task-created="fetchTasks" />
        <ul>
            <li v-for="task in tasks" :key="task.id">
                {{ task.title }} - {{ task.status }}
                <button @click="changeStatus(task)">Изменить статус</button>
            </li>
        </ul>

        <h3>Факт о кошках:</h3>
        <p v-if="catFact">{{ catFact }}</p>
        <p v-else>Загрузка факта о кошаках)</p>
    </div>
</template>

<script lang="ts">
import { defineComponent, onMounted, ref } from 'vue';
import TaskForm from './TaskForm.vue';
import { api } from '@/api/axios';
import type { Task } from '@/models/Task';

export default defineComponent({
    components: { TaskForm },
    setup() {
        const tasks = ref<Task[]>([]);
        const catFact = ref<string | null>(null);

        const fetchTasks = async () => {
            try {
                const response = await api.get('/tasks');
                tasks.value = response.data;
            } catch (error) {
                console.error('Ошибка при получении задач:', error);
            }
        };

        const changeStatus = async (task: Task) => {
            const status = task.status === 'new' ? 'working' : 'completed';
            try {
                await api.patch(`task/${task.id}/change/status`, { 'status': status });
                fetchTasks();
            } catch (error) {
                console.error('Ошибка при обновлении статуса:', error);
            }
        };

        const fetchCatFact = async () => {
            try {
                const response = await api.get('/cat-fact'); // Используем локальный маршрут
                catFact.value = response.data.fact; // Сохраняем факт о кошках
            } catch (error) {
                console.error('Ошибка при получении факта о кошках:', error);
            }
        };

        onMounted(async () => {
            await fetchTasks();
            await fetchCatFact();
        });

        return {
            tasks,
            fetchTasks,
            changeStatus,
            catFact
        };
    },
});
</script>

<style scoped></style>
