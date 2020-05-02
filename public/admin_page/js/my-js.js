$(document).ready(function () {
    let btnSearch = $("button#btn-search");
    let btnClearSearch = $("button#btn-clear-search");

    let $inputSearchField = $("input[name = search_field]");    
    let $inputSearchValue = $("input[name = search_value]");
    let selectChangeAttr = $("select[name = select-change-attr]");

    $("a.select-field").click(function (e) {
        // Co dinh link hien tai ////
        e.preventDefault();
        
        // Lay data = data-field ////
        let field = $(this).data('field');

        // Lay data ben trong the a ////
        let fieldName = $(this).html();

        // Gan lai vao button active ////
        $("button.btn-active-field").html(fieldName + '<span class="caret"></span>');

        // Dung gia tri value de biet la search-field=? ///
        $inputSearchField.val(field);
    });

    // button search ///
    btnSearch.click(function () {

        var pathName = window.location.pathname;

        // Lay filter_status, add vao linkURL --> search and filter
        let params = ['filter_status'];
        let searchParams = new URLSearchParams(window.location.search); //?filter_status=active

        let link = '';

        $.each(params, function(key, param){
            if(searchParams.has(param)){
                link += param + '=' + searchParams.get(param) + '&'; //filter_status=active 
            }
        });

        let search_field = $inputSearchField.val();
        let search_value = $inputSearchValue.val();

        // Chua nhap search thi alert()
        if(search_value.replace(/\s/g,"") == ""){
            alert("Nhap gia tri can tim!");
        }else{
            window.location.href = pathName + "?" + link + "search_field=" + search_field + "&search_value=" + search_value;   
        }
    });

    // button clear seach ///
    btnClearSearch.click(function(){
        var pathName = window.location.pathname;

        // Lay filter_status, add vao linkURL --> search and filter
        let params = ['filter_status'];
        let searchParams = new URLSearchParams(window.location.search);

        let link = '';
        $.each(params, function(key, param){
            if(searchParams.has(param)){
                link += param + '=' + searchParams.get(param) + '&'; //filter_status=active 
            }
        });

        window.location.href = pathName + '?' + link.slice(0, -1);

    });

    // button delete - confirm ///
    $(".btn-delete").click(function (){
        if(!confirm("Ban co muon xoa phan tu nay?")){
            return false;
        }
    });

    selectChangeAttr.on('change', function () {
        let selectVal = $(this).val();
        let url = $(this).data('url');
        // console.log(url.replace("value-new", selectVal));
        window.location.href = url.replace('value-new', selectVal);
    })
    

});