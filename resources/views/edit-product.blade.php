<div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit product</h4>
            </div>
            <div class="modal-body" id="">
                <div class="form-container">
                    <form >
                        <div class="input-group">
                            <label for="name">Name</label>
                            <input class="form-control" type="text" id="name" name="name" value="{{$productData->name}}" required>
                        </div>
                        <div class="input-group">
                            <label for="description">Description</label>
                            <input class="form-control" type="text" id="description" name="description" value="{{$productData->description}}" required>
                        </div>
                        <div class="input-group">
                            <label for="price">Price</label>
                            <input class="form-control" type="number" id="price" name="price" value="{{$productData->price}}" required>
                        </div>
                        <br>
                        <p style="color: red" id="add-product-message"></p>
                        <br>
                        <input type="hidden" id="product-id" value="{{$productData->id}}">
                        <button type="button" id="edit-product-btn">Submit</button>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

        <script>
            $("#edit-product-btn").click(function(){
                var name = $('#name').val();
                var description = $('#description').val();
                var price = $('#price').val();
                var productId = $('#product-id').val();
                if (!name || !description || !price) {
                    $('#add-product-message').html('Please fill all fields');
                    setTimeout(function() {
                        $('#add-product-message').html('');
                    }, 1000);
                    return;
                }
                $.ajax({
                    type: 'POST',
                    url: "{{url('update-product')}}",
                    data: {productId: productId, name: name, description: description, price: price, _token: '{{csrf_token()}}'},
                    success: function (data) {
                        $('#add-product-message').html(data.message);
                        setTimeout(function() {
                            $('#add-product-message').html('');
                            location.reload();
                        }, 2000);
                    },
                });
            });
        </script>