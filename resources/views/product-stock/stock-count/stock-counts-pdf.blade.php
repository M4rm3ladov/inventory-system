<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stock Adjust Records</title>
</head>
<body>
    <h1>Stock Adjust Details</h1>
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
                    <th>Period From</th>
                    <th>Period To</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stockCounts as $stockCount)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td class="quantity">{{ $stockCount['quantity'] }}</td>
                        <td>{{ $stockCount['code'] }}</td>
                        <td>{{ $stockCount['itemName'] }}</td>
                        <td>{{ $stockCount['description'] }}</td>
                        <td>{{ $stockCount['brandName'] }}</td>
                        <td>{{ $stockCount['categoryName'] }}</td>
                        <td>{{ $stockCount['unitName'] }}</td>
                        <td>{{ \Carbon\Carbon::parse($stockCount['transact_date'])->format('Y-m-d')}}</td>
                        <td>{{ \Carbon\Carbon::parse($stockCount['period_from'])->format('Y-m-d')}}</td>
                        <td>{{ \Carbon\Carbon::parse($stockCount['period_to'])->format('Y-m-d')}}</td>
                        <td>{{ $stockCount['createdAt'] }}</td>
                        <td>{{ $stockCount['updatedAt'] }}</td>
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