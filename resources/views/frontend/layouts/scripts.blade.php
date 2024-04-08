<script>
   $(document).ready(function(){
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        $('.wishlist').on('click', function(e){
            e.preventDefault(); 
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

                    }else if(data.status ==='error'){
                        toastr.error(data.message);
                    }
                },
                error: function(xhr, status, error){
                    console.log(error);

                }
            });
        });

        
    }); 
</script>