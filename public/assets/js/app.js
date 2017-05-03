

    //////////////////////
    ///                ///
    ///  INTERACTIONS  ///
    ///                ///
    //////////////////////


    $('.close-icon').on('click', function(){
        $('.popup').css('display','none');
        $('.popup-return-book').css('display','none');
        $('.popup-borrow-book').css('display','none');
    });

    $(".popup").click(function(){
            $('.popup').css('display','none');
            $('.popup-borrow-book').css('display','none');

            if($('.notification').css('display') == 'block'){
                $('.notification').css('display','none');
            }
    });


    $(".popup-container").click(function(e){
        e.stopPropagation();
    });

    $(".notification").click(function(  ) {
        $(this).hide();
    });

    if($('.notification').css('display') == 'block') {
        setTimeout(function () {
            $(".notification").addClass('notification-hide');
        }, 5000);

    }


    function excerpt(text, length) {

        if (text.length <= length) {
            return text;
        }
        text = text.substring(0, length);
        last = text.lastIndexOf(" ");
        text = text.substring(0, last);
        return text + "...";
    }


    function borrow(id){

        $.ajax({
            type: 'post',
            url: 'book/' +  id,
            dataType: "json",
            success: function (data) {

                $('.popup-title').text('Emprunter un livre');
                $('.popup').css('display','flex');
                $('.popup-borrow-book').css('display','block');
                $('.popup-current-book').css('display','none');
                $('.popup-resume-image-container img').attr('src', data.book.cover);
                $('.popup-resume-content-title').text(data.book.title);
                $('.popup-resume-content-author').text(data.book.title);
                $('.popup-resume-content-category').text(data.book.category);
                $('.return-date').text(moment().add(1, 'M').format("DD/MM/YYYY"));
                $('.popup-confirmation button').attr({'value': id,'name' : 'borrow'});

            },
        });

    }

    function currentBook(id){

        $.ajax({
            type: 'post',
            url: 'book/' +  id,
            dataType: "json",
            success: function (data) {
                $('.popup-title').text('Livre en cours');
                $('.popup').css('display','flex');
                $('.popup-borrow-book').css('display','none');
                $('.popup-current-book').css('display','block');
                $('.popup-resume-image-container img').attr('src', data.book.cover);
                $('.popup-resume-content-title').text(data.book.title);
                $('.popup-resume-content-author').text(data.book.title);
                $('.popup-resume-content-category').text(data.book.category);
                $('.return-date').text(moment(data.book.date_return_planned).format("DD/MM/YYYY"));
                $('.popup-confirmation button').attr({'value': id,'name' : 'return'});
                $('.popup-confirmation label').text('Je confirme avoir bien remis le livre dans la case retour de la bibliothèque');
                $('.popup-confirmation button').text('Rendre le livre')

            },
        });

    }



    ///////////////////////////////////
    ///                             ///
    ///  SIDEBAR SEARCH AND FILTER  ///
    ///                             ///
    ///////////////////////////////////


    var categories = [];
    var displayAvailable = ['1','0'];
    var search ='';


    //Add Categories in categories array
    $('.filter input').each(function() {
        categories.push($(this).val());
    });

    $(".filter input").change(function () {
        if (this.checked) {
            categories.push($(this).val());
        }
        else {
            categories.splice($.inArray($(this).val(), categories),1);
        }
        filter(search,displayAvailable,categories);
    });

    $(".availablility-checkbox").change(function () {
        displayAvailable = ['0']
        if (this.checked) {
            displayAvailable = []
            displayAvailable.push('1');
        }
        else {
            displayAvailable.push('1');
        }
        filter(search,displayAvailable,categories);
    });



    $(".search-input").keyup(function () {
        search = $(this).val();
        filter(search,displayAvailable,categories);
    });

    function filter(search,displayAvailable,categories) {


        if (!search){
            search = ' ';
        }

        $.ajax({
            type: "POST",
            url: "book/" + search + '/' + displayAvailable + '/' + categories,
            dataType: "json",
            success: function (data) {

                $('.card').remove();
                $('.loader').css("display","block");

                $('.any-results').remove();
                $('.loader').css("display", "none");

                if(data.books.length == 0){
                    if ($('.any-results').length == 0) {
                        $('.grid').append('<div class="any-results"><h3>Aucun livre trouvé</h3></div>');
                    }
                }

                else {
                    $.each(data.books, function (i, items) {
                        if(checkCurrentBook(items.id)) {
                            var available = '<div class="button return" onclick="currentBook( id =' + items.id + ')">Rendre</div>';
                        } else if(items.available == 0) {
                            var available = ' <div class="card-content-return"> <svg viewBox="0 0 47.001 47.001"> <path d="M46.907,20.12c-0.163-0.347-0.511-0.569-0.896-0.569h-2.927C41.223,9.452,32.355,1.775,21.726,1.775 C9.747,1.775,0,11.522,0,23.501C0,35.48,9.746,45.226,21.726,45.226c7.731,0,14.941-4.161,18.816-10.857 c0.546-0.945,0.224-2.152-0.722-2.699c-0.944-0.547-2.152-0.225-2.697,0.72c-3.172,5.481-9.072,8.887-15.397,8.887 c-9.801,0-17.776-7.974-17.776-17.774c0-9.802,7.975-17.776,17.776-17.776c8.442,0,15.515,5.921,17.317,13.825h-2.904 c-0.385,0-0.732,0.222-0.896,0.569c-0.163,0.347-0.11,0.756,0.136,1.051l4.938,5.925c0.188,0.225,0.465,0.355,0.759,0.355 c0.293,0,0.571-0.131,0.758-0.355l4.938-5.925C47.018,20.876,47.07,20.467,46.907,20.12z" fill="#D80027"/> <path d="M21.726,6.713c-1.091,0-1.975,0.884-1.975,1.975v11.984c-0.893,0.626-1.481,1.658-1.481,2.83 c0,1.906,1.551,3.457,3.457,3.457c0.522,0,1.014-0.125,1.458-0.334l6.87,3.965c0.312,0.181,0.65,0.266,0.986,0.266 c0.682,0,1.346-0.354,1.712-0.988c0.545-0.943,0.222-2.152-0.724-2.697l-6.877-3.971c-0.092-1.044-0.635-1.956-1.449-2.526V8.688 C23.701,7.598,22.816,6.713,21.726,6.713z M21.726,24.982c-0.817,0-1.481-0.665-1.481-1.48c0-0.816,0.665-1.481,1.481-1.481 s1.481,0.665,1.481,1.481C23.207,24.317,22.542,24.982,21.726,24.982z" fill="#D80027"/> </svg> <span>Retour le : ' + moment(items.date_return_planned).format("DD/MM/YYYY") + '</span></div>';
                        } else {
                            var available = '<div class="button available" onclick="borrow( id =' + items.id + ')">Emprunter</div>';
                        }

                        $('.grid').append(
                            '<div class="card">' +
                                '<div class="card-image">' +
                                    '<div class="card-image-container">' +
                                         '<img src="' + items.cover + '" alt="' + items.title + '">' +
                                    '</div>' +
                                '</div>' +
                                '<div class="card-content">' +
                                    '<div class="card-content-title" title="' + items.title + '">' + excerpt(items.title, 35) + '</div>' +
                                    '<div class="card-content-author" title="' + items.author + '">' + excerpt(items.author, 35) + '</div>' +
                                    '<div class="card-content-category">' + items.category + '</div>' +
                                    '<div class="card-content-button">' + available + '</div>' +
                                '</div>' +
                            '</div>'
                        );


                    });
                }
            },
            error: function() {
                $('.loader').css("display", "none");

                if(categories.length === 0 ){
                    if ($('.any-results').length == 0) {
                        $('.card').remove();
                        $('.grid').append('<div class="any-results"><h3>Veuillez cocher au moins une catégorie</h3></div>');
                    }
                }
                else{
                    if($('.any-results').length == 0){

                    }
                }

            }
        });
    }



    function checkCurrentBook(id){
        if(id == $('.book').attr('id')){
            return true;
        } else {
            return false;
        }
    }
