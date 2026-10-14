<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Flow &mdash; a modern to-do list</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-[#0b0b0f] text-white antialiased">
    <div class="flex min-h-full items-center justify-center px-4 py-16">
        <div
            x-data="taskList(@js($tasks))"
            class="w-full max-w-md rounded-2xl border border-white/5 bg-[#111116] p-8 shadow-2xl shadow-black/40"
        >
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-zinc-500">{{ now()->format('l, F j') }}</p>
                    <h1 class="mt-1 text-2xl font-bold tracking-tight">Today</h1>
                </div>
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-violet-600/10 text-violet-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 11l3 3L22 4"></path>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                    </svg>
                </div>
            </div>

            <ul class="space-y-1" x-show="tasks.length">
                <template x-for="task in tasks" :key="task.id">
                    <li class="group flex items-center gap-3 rounded-lg px-1 py-3 transition hover:bg-white/5">
                        <button
                            type="button"
                            @click="toggleTask(task)"
                            class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full border-2 transition"
                            :class="task.completed ? 'border-violet-500 bg-violet-500' : 'border-zinc-600 hover:border-violet-400'"
                        >
                            <svg x-show="task.completed" xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 6L9 17l-5-5"></path>
                            </svg>
                        </button>

                        <span
                            class="flex-1 font-semibold transition"
                            :class="task.completed ? 'text-zinc-600 line-through' : 'text-white'"
                            x-text="task.title"
                        ></span>

                        <button
                            type="button"
                            @click="deleteTask(task)"
                            class="shrink-0 text-zinc-600 opacity-0 transition hover:text-red-400 group-hover:opacity-100"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 6h18"></path>
                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                            </svg>
                        </button>
                    </li>
                </template>
            </ul>

            <p x-show="!tasks.length" class="py-6 text-sm text-zinc-500">No tasks yet &mdash; add your first one below.</p>

            <form @submit.prevent="addTask" class="mt-4 border-t border-white/5 pt-5">
                <input
                    type="text"
                    x-model="newTitle"
                    placeholder="Add task..."
                    autocomplete="off"
                    class="w-full border-b border-zinc-700 bg-transparent pb-3 font-semibold text-zinc-300 placeholder-zinc-600 outline-none transition focus:border-violet-500"
                >

                <button
                    type="submit"
                    :disabled="saving || !newTitle.trim()"
                    class="mt-5 w-full rounded-xl bg-violet-600 py-3 font-semibold text-white transition hover:bg-violet-500 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    Add Task
                </button>
            </form>

            <p class="mt-5 text-center text-xs text-zinc-600" x-show="tasks.length" x-text="remaining + ' task' + (remaining === 1 ? '' : 's') + ' remaining'"></p>
        </div>
    </div>
</body>
</html>
