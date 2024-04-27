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
    <table class="table-hover table table-striped table-bordered" data-toggle="table" data-search="true"
            data-show-columns="true">
            <thead class="sticky-top top-0 z-0">
                <tr>
                    <th scope="col" data-sortable="true">#</th>
                    <th scope="col" data-sortable="true">Name</th>
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