<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Products</title>
</head>
<body>
    <h1>Products Details</h1>
    <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Brand</th>
                    <th>Category</th>
                    <th>Unit</th>
                    <th>Supplier Price</th>
                    <th>Price A</th>
                    <th>Price B</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $item['code'] }}</td>
                        <td class="text-nowrap">{{ $item['itemName'] }}</td>
                        <td class="text-nowrap">{{ $item['description'] }}</td>
                        <td>{{ $item['brandName'] }}</td>
                        <td>{{ $item['categoryName'] }}</td>
                        <td>{{ $item['unitName'] }}</td>
                        <td class="price">{{ $item['unit_price'] }}</td>
                        <td class="price">{{ $item['price_A'] }}</td>
                        <td class="price">{{ $item['price_B'] }}</td>
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