
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stock In Records</title>
</head>
<body>
    <h1>Stock In Details</h1>
    <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Quantity</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Brand</th>
                    <th>Category</th>
                    <th>Unit</th>
                    <th>Transaction Date</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stockOuts as $stockOut)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td class="quantity">{{ $stockOut['quantity'] }}</td>
                        <td>{{ $stockOut['code'] }}</td>
                        <td>{{ $stockOut['itemName'] }}</td>
                        <td>{{ $stockOut['description'] }}</td>
                        <td>{{ $stockOut['brandName'] }}</td>
                        <td>{{ $stockOut['categoryName'] }}</td>
                        <td>{{ $stockOut['unitName'] }}</td>
                        <td>{{ \Carbon\Carbon::parse($stockCount['transact_date'])->format('Y-m-d')}}</td>
                        <td>{{ $stockOut['createdAt'] }}</td>
                        <td>{{ $stockOut['updatedAt'] }}</td>
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