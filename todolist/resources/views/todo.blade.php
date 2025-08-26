
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>ToDoList</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>

<body>
    <div x-data="tasks()" class="bg-white h-screen w-[700px] flex flex-col mx-auto">

        <div class="flex justify-between items-center p-6">

            <div>
                <div class="flex items-center">
                    <p class="text-l font-bold mr-1">To Dos: </p>
                    <span x-text="tasks.filter(t => !t.completed).length" class="mr-1 text-l font-bold"></span>
                    <span class="text-gray-500">|</span>
                    <p class="text-l font-bold ml-1 mr-1">Completed: </p>
                    <span x-text="tasks.filter(t => t.completed).length" class="text-l font-bold"></span>
                </div>

                <div class="flex items-center mt-2">
                    <template x-if="tasks.length === 0">
                        <p class="mt-6 text-xl font-bold">No tasks yet!</p>
                    </template>
                    <template x-if="tasks.filter(t => !t.completed).length">
                        <p class="mt-6 text-xl font-bold"
                            x-text="tasks.filter(t => !t.completed).length + ' more to go!'"></p>
                    </template>
                    <template x-if="tasks.filter(t=>t.completed).length == tasks.length && tasks.length > 0">

                        <p class="mt-6 text-xl font-bold">Congrats you finished your list!</p>
                    </template>
                </div>
            </div>

            {{-- <div class="flex items-center border border-gray-300 rounded-md p-2"> <input class="focus:outline-none"
                    type="text" placeholder="Search tasks..."><span class="material-symbols-outlined">
                    search
                </span>
            </div> --}}

            <select x-model="filter" class="border border-gray-300 rounded-md p-2">
                <option>All</option>
                <option>To Dos</option>
                <option>Completed</option>
            </select>

        </div>

        <div class="flex-1 overflow-y-auto p-6 mt-8">
            <template x-for="(task, index) in filteredTasks" :key="index" class="space-y-4">

                <div class="bg-white p-4 rounded-lg shadow mt-2">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" @click="taskCompleted(index)" :checked="task.completed"
                                class="cursor-pointer peer mr-2 h-4 w-4 appearance-none rounded bg-gray-200
           checked:bg-white checked:before:content-['✓']
           checked:before:text-black checked:before:text-lg
           checked:before:flex checked:before:justify-center
           checked:before:items-center checked:before:w-full
           checked:before:h-full">
                            <p x-text="task.task" :class="{ 'line-through': task.completed }"
                                class="ml-2 text-gray-800 text-l"></p>
                        </div>
                        <span @click="deleteTask(index)" class="text-gray-400 text-sm cursor-pointer">Remove.</span>
                    </div>
                </div>
            </template>
        </div>

        <div class="bg-white p-4 rounded-lg shadow mx-6 my-6">
            <form>
                <div class="flex items-center">
                    <input x-ref="newTask" x-model="newTask" @keydown.enter.prevent="addNewTask()" type="text"
                        placeholder="Add to do item" class="flex-1 p-2 mr-2">
                    <span @click="addNewTask()" class="material-symbols-outlined">
                        add_circle
                    </span>
                </div>
            </form>
        </div>
    </div>

    <script>
        function tasks() {
            return {
                tasks: Alpine.$persist([]),
                newTask: '',
                filter: 'All',
                get filteredTasks() {
                    if (this.filter === 'All') {
                        return this.tasks;
                    } else if (this.filter === 'To Dos') {
                        return this.tasks.filter(task => !task.completed);
                    } else if (this.filter === 'Completed') {
                        return this.tasks.filter(task => task.completed);
                    }
                },
                addNewTask() {
                    if (this.newTask.trim() !== '') {
                        this.tasks.push({
                            task: this.newTask,
                            completed: false,
                        });
                        this.newTask = '';
                        this.$refs.newTask.focus();
                    }
                    return false;
                },
                deleteTask(index) {
                    this.tasks = this.tasks.filter((_, i) => i !== index);
                },
                taskCompleted(index) {
                    this.tasks[index].completed = !this.tasks[index].completed;
                },
            }
        }
    </script>

</body>

</html>
