<section id="wsus__brand_sleder" class="brand_slider_2">
    <div class="container">
        <div class="brand_border">
            <div class="row brand_slider">
                @foreach ($category as $item)
                    <div class="col-xl-2">
                    <div class="wsus__brand_logo">
                        <a href="" class="btn "> {{ $item->name }}</a>
                    </div>
                </div>
                @endforeach
                
                
                
            </div>
        </div>
    </div>
</section>