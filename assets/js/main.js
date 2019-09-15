(function ($) {
    'use strict';

    $('.ps_add_to_wishlist').on('click', function(e){
        e.preventDefault();
        //alert('asd');
        var product_id = $(this).data('product-id');
        $(".ps_add_to_wishlist").text('Wait..');
        $.ajax({
            url : ps_check_obj.ajaxurl,
            type : 'post',
            datatype: 'json',
            data : {
                action : 'ps_wishlist_add',
                product_id : product_id,
                ps_security : ps_check_wishlist_obj.ajax_nonce,
            },
            success : function( response ) {
                if(response.status === 'success'){
                    alert('Product added to wishlist');
                    $(".ps_add_to_wishlist").text('Add to Wishlist');
                }else if(response.status === 'exists'){
                    alert('Product already in wishlist');
                    $(".ps_add_to_wishlist").text('Add to Wishlist');
                }else{
                    alert('Something wrong');
                    $(".ps_add_to_wishlist").text('Add to Wishlist');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log("Error: " + errorThrown);
            }
        });
    });

    //Remove wishlist
    $('.ps_remove_wishlist').on('click', function(e){
        e.preventDefault();
        //alert('asd');
        var product_id = $(this).data('product-id');
        $.ajax({
            url : ps_check_obj.ajaxurl,
            type : 'post',
            datatype: 'json',
            data : {
                action : 'ps_wishlist_remove',
                product_id : product_id,
                ps_security : ps_check_wishlist_obj.ajax_nonce,
            },
            success : function( response ) {
                //console.log(response);
                if(response.status === 'success'){
                    alert('Product successfully deleted from wishlist');
                    location.reload();
                }else{
                    alert('Something wrong');
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log("Error: " + errorThrown);
            }
        });
    });
})(jQuery);