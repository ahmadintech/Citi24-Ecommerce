$(document).ready(function () {
    //check if admin password is correct
    $("#current_pwd").keyup(function () {
        var current_pwd = $("#current_pwd").val();
        //alert(current_pwd);
        $.ajax({
            type: "post",
            url: "/admin/check-current-pwd",
            data: { current_pwd: current_pwd },
            success: function (resp) {
                if (resp == "false") {
                    $("#chkCurrentPass").html(
                        "<font color=red>Current Password is Incorrect</font>"
                    );
                } else if (resp == "true") {
                    $("#chkCurrentPass").html(
                        "<font color=green>Current Password is correct</font>"
                    );
                }
            },
            error: function () {
                alert("error");
            },
        });
    });

    //update category status
    $(".updateCategoryStatus").click(function () {
        var status = $(this).text();
        var category_id = $(this).attr("category_id");

        $.ajax({
            type: "post",
            url: "/admin/update-category-status",
            data: { status: status, category_id: category_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#category-" + category_id).html(
                        "<a class='updateCategoryStatus' id='category-{{ $category->id }}' category_id='{{ $category->id }}' href='javascript:void(0)'>Inactive</a>"
                    );
                } else if (resp["status"] == 1) {
                    $("#category-" + category_id).html(
                        "<a class='updateCategoryStatus' id='category-{{ $category->id }}' category_id='{{ $category->id }}' href='javascript:void(0)'>Active</a>"
                    );
                }
            },
            error: function () {
                alert("Error");
            },
        });
    });

    //Append categories level
    $("#section_id").change(function () {
        var section_id = $(this).val();
        //alert(section_id);
        $.ajax({
            type: "post",
            url: "/admin/append-categories-level",
            data: { section_id: section_id },
            success: function (resp) {
                $("#appendCategoriesLevel").html(resp);
            },
            error: function () {
                alert("Error");
            },
        });
    });

    //sweet alert to confirm deletion of a record
    $(".confirmDelete").click(function () {
        var record = $(this).attr("record");
        var recordid = $(this).attr("recordid");
        Swal.fire({
            title: "Are you sure ?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                //if user clicks yes then redirect to this url which will then enable the delete of the record
                window.location.href =
                    "/admin/delete-" + record + "/" + recordid;
            }
        });
    });

    //update product status
    $(".updateProductStatus").click(function () {
        var status = $(this).text();
        var product_id = $(this).attr("product_id");

        $.ajax({
            type: "post",
            url: "/admin/update-product-status",
            data: { status: status, product_id: product_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#product-" + product_id).html(
                        "<a class='updateProductStatus' id='product-{{ $product->id }}' product_id='{{ $product->id }}' href='javascript:void(0)'>Inactive</a>"
                    );
                } else if (resp["status"] == 1) {
                    $("#product-" + product_id).html(
                        "<a class='updateProductStatus' id='product-{{ $product->id }}' product_id='{{ $product->id }}' href='javascript:void(0)'>Active</a>"
                    );
                }
            },
            error: function () {
                alert("Error");
            },
        });
    });

    //update payment status
    $(".updateOrderStatus").click(function () {
        var status = $(this).text();
        var order_id = $(this).attr("order_id");

        $.ajax({
            type: "post",
            url: "/admin/update-payment-status",
            data: { status: status, order_id: order_id },
            success: function (resp) {
                $("#order-" + order_id).html(
                    "<a class='updateOrderStatus' id='order-{{ $order->id }}' order_id='{{ $order->id }}' href='javascript:void(0)'>" +
                        resp["status"] +
                        "</a>"
                );
            },
            error: function (err) {
                console.log(err);
                alert("Error");
            },
        });
    });

    $(".edit-shipping").click(function (e) {
        e.preventDefault();

        let amount = $(e.currentTarget).closest("tr").find("#shipping").val();
        let id = $(e.currentTarget).attr("shipping_id");

        $.ajax({
            type: "post",
            url: "/admin/edit-shipping",
            data: { amount: Number(amount), id: Number(id) },
            success: function (resp) {
                // console.log(resp);
                window.location.reload();
            },
            error: function (err) {
                console.log(err);
                alert("Error");
            },
        });
    });

    //Adding and removing fields
    var maxField = 10; //Input fields increment limitation
    var addButton = $(".add_button"); //Add button selector
    var wrapper = $(".field_wrapper"); //Input field wrapper
    var fieldHTML =
        '<div style="margin-top:15px"><input type="text" name="size[]" placeholder="Size"/>&nbsp;<input type="text" name="sku[]" placeholder="SKU"/>&nbsp;<input type="text" name="stock[]" placeholder="Stock"/>&nbsp;<input type="text" name="price[]" placeholder="Price"/>&nbsp;<a href="javascript:void(0);" class="remove_button">Remove</a></div>'; //New input field html
    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton).click(function () {
        //Check maximum number of input fields
        if (x < maxField) {
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });

    //Once remove button is clicked
    $(wrapper).on("click", ".remove_button", function (e) {
        e.preventDefault();
        $(this).parent("div").remove(); //Remove field html
        x--; //Decrement field counter
    });

    //update Attribute status
    $(".updateAttributeStatus").click(function () {
        var status = $(this).text();
        var attribute_id = $(this).attr("attribute_id");

        $.ajax({
            type: "post",
            url: "/admin/update-attribute-status",
            data: { status: status, attribute_id: attribute_id },
            success: function (resp) {
                if (resp["status"] == 0) {
                    $("#attribute-" + attribute_id).html(
                        "<a class='updateAttributeStatus' id='attribute-{{ $attribute->id }}' attribute_id='{{ $attribute->id }}' href='javascript:void(0)'>Inactive</a>"
                    );
                } else if (resp["status"] == 1) {
                    $("#attribute-" + attribute_id).html(
                        "<a class='updateAttributeStatus' id='attribute-{{ $attribute->id }}' attribute_id='{{ $attribute->id }}' href='javascript:void(0)'>Active</a>"
                    );
                }
            },
            error: function () {
                alert("Error");
            },
        });
    });
});
