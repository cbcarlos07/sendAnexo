
$('.btn-salvar').on('click', function () {
    console.log('Salvar')

    console.log('Arquivo: '+arquivo)
    var myForm = document.getElementById('idForm');
    var formData = new FormData(myForm)
    $.ajax({
        url: 'funcao.php',
        type: 'post',
        dataType: 'json',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            if(data.status){
                alert(data.msg)
            }
        },
        fail: function (data) {
            alert(data.msg)

        }
    })


})

$('.btn_baixar').on('click', function () {
    var file = $(this).data('url')
    location.href = 'arquivo/'+file
})

$('.btn-alterar').on('click', function () {
    var item = $(this).closest('tr').find('td');
    $('#acao').val( 'U' )
    $('#codigo').val( item[0].innerHTML )
    $('#nome').val( item[1].innerHTML )
   // $('#arquivo').val( 'arquivo/'+item[2].innerHTML )
    $('.btn_cancelar').css({'display':'block'})

})

$('.btn-remover').on('click', function () {
    var url = $(this).data('url');
    var linha   = $(this).closest('tr').find('td')
    var id = linha[0].innerHTML
    if(confirm('Deseja realmente remover o arquivo associado?')){
        $.ajax({
            url: 'funcao.php',
            dataType: 'json',
            type: 'post',
            data: {
                acao: 'R',
                codigo: id,
                url: url
            },
            success: function (data) {
                console.log( data )
                if(data.status){
                    alert(data.msg)
                }
            },
            fail: function (data) {
                alert(data.msg)
            }
        })
    }
})

