<script>
   $(document).ready(function(){
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        $('.wishlist').on('click', function(e){
            e.preventDefault();
            
            let icon = $(this).find('i'); 
            let id = $(this).data('id');
           
            $.ajax({
                url: "{{ route('user.wishlist.add-to-wishlist') }}",
                method: 'GET',
                data: {
                    id: id,
                },
                success: function(data){
                    if(data.status === 'success'){
                        toastr.success(data.message);
                        
                    updateWishlistCount();
                    icon.removeClass('fal fa-heart').addClass('fas fa-heart text-danger');



                    }else if(data.status ==='error'){
                        toastr.error(data.message);
                    }
                },
                error: function(xhr, status, error){
                    console.log(error);

                }
            });
        });

        function updateWishlistCount() {
            $.ajax({
                url: "{{ route('user.wishlist.count') }}",
                method: 'GET',
                success: function(data){
                    if(data.status === 'success'){
                        $('.wishlist-count').text(data.count);
                    } else if(data.status === 'error'){
                        console.error(data.message);
                    }
                },
                error: function(xhr, status, error){
                    console.log(error);
                }
            });
        }

        
    }); 
</script>