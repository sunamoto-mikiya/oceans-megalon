<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <p>{{ $taskOptions[$task->type] }}</p>
        <p>{{ $task->title }}</p>
        <p>{{ $task->user?->name }}</p>
        <p>{{ $task->description }}</p>
        <p>{{ $statusOptions[$task->status] }}</p>
        <p>{{ $task->start_date }}</p>
        <p>{{ $task->end_date }}</p>
    </div>
</body>
</html>
