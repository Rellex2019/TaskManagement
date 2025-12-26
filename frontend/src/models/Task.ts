export interface Task {
    id: number;
    title: string;
    status: 'new' | 'working' |'completed';
}
