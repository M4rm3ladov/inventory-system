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
    <table class="table-hover table table-striped table-bordered" data-toggle="table" data-search="true"
            data-show-columns="true">
            <thead class="sticky-top top-0 z-0">
                <tr>
                    <th scope="col" data-sortable="true">#</th>
                    <th scope="col" data-sortable="true">Code</th>
                    <th scope="col" data-sortable="true">Name</th>
                    <th scope="col" data-sortable="true">Description</th>
                    <th scope="col" data-sortable="true">Brand</th>
                    <th scope="col">Category</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Supplier Price</th>
                    <th scope="col">Price A</th>
                    <th scope="col">Price B</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td>{{ $item['code'] }}</td>
                        <td class="text-nowrap">{{ $item['itemName'] }}</td>
                        <td class="text-nowrap">{{ $item['description'] }}</td>
                        <td>{{ $item['brandName'] }}</td>
                        <td>{{ $item['categoryName'] }}</td>
                        <td>{{ $item['unitName'] }}</td>
                        <td>{{ $item['unit_price'] }}</td>
                        <td>{{ $item['price_A'] }}</td>
                        <td>{{ $item['price_B'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</body>
</html>