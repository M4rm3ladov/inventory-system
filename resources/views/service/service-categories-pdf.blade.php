<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Service Category</title>
</head>
<body>
    <h1>Service Category Details</h1>
    <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($serviceCategories as $serviceCategory)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td class="text-nowrap">{{ $serviceCategory['name'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</body>
</html>
<style>
    @page {
        size: A4 portrait;
    }

    table {
        border-collapse: collapse;
    }

    th {
        padding: 0 2px;
    }

    table th, td{
        border: 1px solid;
    }
</style>