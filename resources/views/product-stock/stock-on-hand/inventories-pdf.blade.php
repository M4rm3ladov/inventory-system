<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inventories</title>
</head>
<body>
    <h1>Inventories Details</h1>
    <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Branch</th>
                    <th>Quantity</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Brand</th>
                    <th">Category</th>
                    <th>Unit</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inventories as $inventory)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $inventory['branchName'] }}</td>
                        <td class="quantity">{{ $inventory['quantity'] }}</td>
                        <td>{{ $inventory['code'] }}</td>
                        <td>{{ $inventory['itemName'] }}</td>
                        <td>{{ $inventory['description'] }}</td>
                        <td>{{ $inventory['brandName'] }}</td>
                        <td>{{ $inventory['categoryName'] }}</td>
                        <td>{{ $inventory['unitName'] }}</td>
                        <td>{{ $inventory['createdAt'] }}</td>
                        <td>{{ $inventory['updatedAt'] }}</td>
                    </tr>
                @endforeach
            </tbody>
    </table>
</body>
</html>
<style>
    @page {
        size: A4 landscape;
    }

    table {
        border-collapse: collapse;
    }

    .quantity {
        text-align: center;
    }

    th {
        padding: 0 2px;
    }

    table th, td{
        border: 1px solid;
    }
</style>