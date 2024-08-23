
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <h2 class="page_header" style="text-align: center;">Products</h2>
    <div class="container">
        <button type="button" id="" class="btn btn-success" data-toggle="modal" data-target="#myModal">Add product</button>
        <input type="text" class="product_list_search" id="search_for_product" placeholder="Search...">
        @if (count($products) > 0)
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($products as $key => $product)
                        <tr class="product_data">
                            <td>{{$product->name}}</td>
                            <td>{{$product->description}}</td>
                            <td>{{$product->price}}</td>
                            <td>
                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal" onclick='editproduct({{$product->id}})'>Edit</button>
                                <a href='#' onclick='confirmDelete({{"$product->id"}})'>
                                    <button type="button" class="btn btn-danger">Delete</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>products are not available</p>
        @endif
        {{ $products->links() }}
    </div>

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content" id="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add product</h4>
            </div>
            <div class="modal-body" id="">
                <div class="form-container">
                    <form >
                        <div class="input-group">
                            <label for="name">Name</label>
                            <input class="form-control" type="text" id="name" name="name" required>
                        </div>
                        <div class="input-group">
                            <label for="description">Description</label>
                            <input class="form-control" type="text" id="description" name="description" required>
                        </div>
                        <div class="input-group">
                            <label for="price">Price</label>
                            <input class="form-control" type="number" id="price" name="price" required>
                        </div>
                        <br>
                        <p style="color: red" id="add-product-message"></p>
                        <br>
                        <button type="button" id="add-product-btn">Submit</button>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    
        </div>
    </div>

    <script>

        $("#add-product-btn").click(function(){
            var name = $('#name').val();
            var description = $('#description').val();
            var price = $('#price').val();
            if (!name || !description || !price) {
                $('#add-product-message').html('Please fill all fields');
                setTimeout(function() {
                    $('#add-product-message').html('');
                }, 1000);
                return;
            }
            $.ajax({
                type: 'POST',
                url: "{{url('add-product')}}",
                data: {name: name, description: description, price: price, _token: '{{csrf_token()}}'},
                success: function (data) {
                    $('#add-product-message').html(data.message);
                    setTimeout(function() {
                        $('#add-product-message').html('');
                        location.reload();
                    }, 2000);
                },
            });
        });

        function editproduct(ProductId) {
            $.ajax({
                type: 'POST',
                url: "{{url('fetch-product-data')}}",
                data: {ProductId: ProductId, _token: '{{csrf_token()}}'},
                success: function (data) {
                    $('#modal-content').html(data);
                    
                },
            });
        }

        function confirmDelete(productId) {
            if (confirm("Are you sure you want to delete this product?")) {
                $.ajax({
                    type: 'POST',
                    url: "{{url('delete-product')}}",
                    data: {productId: productId, _token: '{{csrf_token()}}'},
                    success: function (data) {
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    },
                });
            }
        }

        (function($) {
            $.fn.donetyping = function(callback){
            var _this = $(this);
            var x_timer;    
            _this.keyup(function (){
                clearTimeout(x_timer);
                x_timer = setTimeout(clear_timer, 1000);
            }); 

            function clear_timer(){
                clearTimeout(x_timer);
                callback.call(_this);
            }
            }
        })(jQuery);

        $('#search_for_product').donetyping(function(callback){
            searchUsers();
        });

        jQuery.expr[":"].Contains = jQuery.expr.createPseudo(function(arg) {
            return function( elem ) {
                return jQuery(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
            };
        });

        function searchUsers() {
            var search_content = $("#search_for_product").val();
            if (search_content.length > 0) {
                $('.product_data').hide();
                $('.product_data:Contains("'+search_content+'")').show();
            }
            else if (!search_content) {
                $(".product_data").show();
            }
            else {
                // do nothing
            }
        }

    
    </script>
</body>
</html>