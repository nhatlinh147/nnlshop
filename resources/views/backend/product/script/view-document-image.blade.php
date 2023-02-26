<script>
    $('.product_image').on('change', function() {
        var file = $(this)[0].files[0];

        var fileReader = new FileReader();
        fileReader.onload = function() {
            var str =
                '<img class="img-thumbnail js-file-image" style="width: 100px; height: 100px">';
            $('.see_product_image').html(str);

            var imageSrc = event.target.result;

            $('.js-file-image').attr('src', imageSrc);
        };
        fileReader.readAsDataURL(file);
    });


    $('.product_document').on('change', function() {
        var file = $(this)[0].files[0];
        if (file) {
            var fileReader = new FileReader();
            fileReader.onload = function() {

                var str =
                    '<p class="view_document_temporary"><span>Tên file:</span> <a target="_blank" class="js-file-document">' +
                    file.name + '</a></p>';
                $('.see_product_document').html(str);
                $('.view_document_temporary').css({
                    'margin-top': '10px'
                });
                $('.view_document_temporary span').css({
                    'font-weight': 'bold'
                });
                var documentHref = URL.createObjectURL(file);

                $('.js-file-document').attr('href', documentHref);
            };
            fileReader.readAsDataURL(file);
        } else {
            $('.see_product_document').empty();
        }

    });
</script>
