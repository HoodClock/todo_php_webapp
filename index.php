<!-- Frontend  -->
<!-- we use valilla JS with fetch function to talk to api.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Todo</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; max-width: 600px; margin: 40px auto; background: #222; color: #fff; }
        input { padding: 10px; width: 70%; border: none; border-radius: 4px; }
        button { padding: 10px 20px; background: #2ecc71; color: white; border: none; cursor: pointer; border-radius: 4px; }
        ul { list-style: none; padding: 0; }
        li { background: #333; margin: 10px 0; padding: 15px; display: flex; justify-content: space-between; align-items: center; border-radius: 4px; }
        .delete-btn { background: #e74c3c; padding: 5px 10px; font-size: 0.8rem; }
    </style>
</head>
<body>

    <h1>🚀 Task Manager</h1>
    
    <div style="display:flex; gap:10px;">
        <input type="text" id="taskInput" placeholder="Add a new task...">
        <button onclick="addTask()">Add</button>
    </div>

    <ul id="taskList"></ul>

    <script>
        const API_URL = 'api.php';

        // 1. Fetch and Display Tasks
        async function fetchTasks() {
            const res = await fetch(API_URL);
            const data = await res.json();
            const list = document.getElementById('taskList');
            list.innerHTML = '';
            
            data.forEach(task => {
                const li = document.createElement('li');
                li.innerHTML = `
                    ${task.title}
                    <button class="delete-btn" onclick="deleteTask(${task.id})">Delete</button>
                `;
                list.appendChild(li);
            });
        }

        // 2. Add Task
        async function addTask() {
            const input = document.getElementById('taskInput');
            const title = input.value;
            if (!title) return;

            await fetch(API_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ title: title })
            });

            input.value = '';
            fetchTasks(); 
        }

        // 3. Delete Task
        async function deleteTask(id) {
            if(!confirm("Destroy this task?")) return;

            await fetch(API_URL, {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id })
            });

            fetchTasks();
        }

        // First time load
        fetchTasks();
    </script>
</body>
</html>