<!-- FILEPATH: /e:/test_app/op/ope/resources/views/products/index.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Product List</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Email</th>
                    <th>Category ID</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            
            @foreach($products as $product)
                <tr>
                    <td>{{ $product['id'] }}</td>
                    <td>{{ $product['title'] }}</td>
                    <td>{{ $product['email'] }}</td>
                    <td>{{ $product['categoryId'] }}</td>
                    <td><img src="{{ asset('uploads/products/' . $product['profile_image']) }}" width="100px;" height="100px;" alt="Image"></td>
                    <td>
                        <a href="{{ route('products.edit', $product['id']) }}" class="btn btn-primary">Update</a>
                        <form action="{{ route('products.destroy', $product['id']) }}" method="POST" style="display: inline;">
                            @csrf  
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
        <a href="{{ route('products.create') }}" class="btn btn-success">Create</a>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
