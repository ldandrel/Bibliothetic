
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

function excerpt(text, length) {

    if (text.length <= length) {
        return text;
    }
    text = text.substring(0, length);
    last = text.lastIndexOf(" ");
    text = text.substring(0, last);
    return text + "...";
}

function filter(search,displayAvailable,categories) {
    $('.card').remove();
    $('.loader').css("display","block");

    if (!search){
        search = ' ';
    }

    $.ajax({
        type: "POST",
        url: "book/" + search + '/' + displayAvailable + '/' + categories,
        dataType: "json",
        success: function (data) {

            $('.any-results').remove();
            $('.loader').css("display", "none");

            if(data.books.length == 0){
                if ($('.any-results').length == 0) {
                    $('.grid').append('<div class="any-results"><h3>Aucun livre trouvé</h3></div>');
                }
            }

            else {
                $.each(data.books, function (i, items) {
                    if(items.available == 0) {
                        var available = 'unavailable';
                    } else {
                        var available = '';
                    }
                    $('.grid').append(
                        '<a href="/admin/livre/'+items.id+'" class="card admin-card">' +
                        '<div class="card-image">' +
                        '<div class="card-image-container">' +
                        '<img src="' + items.cover + '" alt="' + items.title + '">' +
                        '</div>' +
                        '</div>' +
                        '<div class="card-content">' +
                        '<div class="card-content-title admin '+available+'" title="' + items.title + '">' + excerpt(items.title, 35) + '</div>' +
                        '<div class="card-content-author" title="' + items.author + '">' + excerpt(items.author, 35) + '</div>' +
                        '<div class="card-content-category">' + items.category + '</div>' +
                        '</div>' +
                        '</a>'
                    );


                });
            }
        },
        error: function() {
            $('.loader').css("display", "none");

            if(categories.length === 0 ){
                if ($('.any-results').length == 0) {
                    $('.grid').append('<div class="any-results"><h3>Veuillez cocher au moins une catégorie</h3></div>');
                }
            }
            else{
                if($('.any-results').length == 0){
                    $('.grid').append('<div class="any-results"><h3>Erreur, veuillez réessayer</h3></div>');
                }
            }

        }
    });
}


