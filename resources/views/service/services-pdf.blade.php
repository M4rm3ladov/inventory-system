<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Services</title>
</head>
<body>
    <h1>Services Details</h1>
    <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Price A</th>
                    <th scope="col">Price B</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $service)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td>{{ $service['code'] }}</td>
                        <td>{{ $service['serviceName'] }}</td>
                        <td>{{ $service['categoryName'] }}</td>
                        <td class="price">{{ $service['price_A'] }}</td>
                        <td class="price">{{ $service['price_B'] }}</td>
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

    .price {
        text-align: right;
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