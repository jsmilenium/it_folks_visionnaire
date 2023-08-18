<!DOCTYPE html>
<html>
<head>
    <title>Documento</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Name: {{ $data['name'] }}</h1>
    <p>Description: {{ $data['description'] }}</p>
    
    <table>
        <thead>
            <tr>
                <th>Column Name</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            @foreach(json_decode($data['columns_and_fields'], true) as $columnName => $columnData)
                <tr>
                    <td>{{ $columnName }}</td>
                    <td>{{ $columnData['value'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
