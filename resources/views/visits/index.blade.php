<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Unique Visits per Page</title>

    <!-- Flatpickr CSS -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"
    />

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 2rem;
            background-color: #f9f9f9;
        }
        h1 {
            margin-bottom: 1rem;
        }
        form {
            margin-bottom: 2rem;
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: flex-end;
        }
        label {
            display: flex;
            flex-direction: column;
            font-weight: bold;
            font-size: 0.9rem;
        }
        input[type="text"] {
            padding: 0.5rem;
            font-size: 1rem;
            width: 200px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 0.6rem 1.2rem;
            font-size: 1rem;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
            transition: background-color 0.25s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 5px rgb(0 0 0 / 0.1);
        }
        th, td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #eee;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        tbody tr:hover {
            background-color: #fafafa;
        }
        @media (max-width: 600px) {
            form {
                flex-direction: column;
                align-items: stretch;
            }
            input[type="text"] {
                width: 100%;
            }
            button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<h1>Unique Visits per Page</h1>

<form method="GET" action="{{ route('visits.index') }}">
    <label for="start_datetime">
        Start Date & Time:
        <input
            type="text"
            id="start_datetime"
            name="start_datetime"
            value="{{ old('start_datetime', $start ?? now()->subDays(7)->format('Y-m-d H:i:s')) }}"
            autocomplete="off"
            required
        />
    </label>

    <label for="end_datetime">
        End Date & Time:
        <input
            type="text"
            id="end_datetime"
            name="end_datetime"
            value="{{ old('end_datetime', $end ?? now()->format('Y-m-d H:i:s')) }}"
            autocomplete="off"
            required
        />
    </label>

    <button type="submit">Filter</button>
</form>

@if($errors->any())
    <div style="color: red; margin-bottom: 1rem;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(count($visits) === 0)
    <p>No visits found for the selected period.</p>
@else
    <table>
        <thead>
        <tr>
            <th>Page</th>
            <th>Unique Visits</th>
        </tr>
        </thead>
        <tbody>
        @foreach($visits as $visit)
            <tr>
                <td>{{ $visit->page }}</td>
                <td>{{ $visit->unique_visits }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#start_datetime", {
        enableTime: true,
        enableSeconds: true,
        dateFormat: "Y-m-d H:i:S",
        time_24hr: true,
        maxDate: "{{ $end ?? now()->format('Y-m-d H:i:s') }}",
    });
    flatpickr("#end_datetime", {
        enableTime: true,
        enableSeconds: true,
        dateFormat: "Y-m-d H:i:S",
        time_24hr: true,
        minDate: "{{ $start ?? now()->subDays(7)->format('Y-m-d H:i:s') }}",
    });
</script>
</body>
</html>
