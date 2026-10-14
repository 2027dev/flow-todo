import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.data('taskList', (initialTasks) => ({
    tasks: initialTasks,
    newTitle: '',
    saving: false,

    get remaining() {
        return this.tasks.filter((task) => !task.completed).length;
    },

    async addTask() {
        const title = this.newTitle.trim();

        if (!title || this.saving) {
            return;
        }

        this.saving = true;

        try {
            const response = await fetch('/tasks', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ title }),
            });

            const task = await response.json();
            this.tasks.push(task);
            this.newTitle = '';
        } finally {
            this.saving = false;
        }
    },

    async toggleTask(task) {
        task.completed = !task.completed;

        await fetch(`/tasks/${task.id}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ completed: task.completed }),
        });
    },

    async deleteTask(task) {
        this.tasks = this.tasks.filter((t) => t.id !== task.id);

        await fetch(`/tasks/${task.id}`, {
            method: 'DELETE',
            headers: {
                Accept: 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        });
    },
}));

Alpine.start();
