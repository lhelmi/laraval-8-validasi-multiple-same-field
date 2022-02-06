<html>
    <head>
        <script src="{{ asset('js/app.js') }}"></script>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <title></title>
    </head>
    <body>
        <form id="form_wow">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <div id="inputFormRow">
                            <div class="ThisNumber" id="0">
                                <div class="input-group mb-3">
                                    <input type="text" name="title[]" id="field-title" class="form-control m-input" placeholder="Enter title" autocomplete="off">
                                    <div class="input-group-append">
                                        <button id="removeRow" type="button" class="btn btn-danger">Remove</button>
                                    </div>
                                    <span id="error-title" class="invalid-feedback"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="newRow"></div>
                    <button id="addRow" type="button" class="btn btn-info">Add Row</button>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </body>
    <script>
        let i = 0
        $("#addRow").click(function () {
            var html = '';
            i += 1
            html += '<div class="form-group">';
            html += '<div id="inputFormRow">';
            html += '<div class="ThisNumber" id="'+i+'">';
            html += '<div class="input-group mb-3">';
            html += '<input type="text" name="title[]" id="field-title" class="form-control m-input" placeholder="Enter title" autocomplete="off">';
            html += '<div class="input-group-append">';
            html += '<button id="removeRow" type="button" class="btn btn-danger">Remove</button>';
            html += '</div>';
            html += '<span id="error-title" class="invalid-feedback"></span>'
            html += '</div>';
            html += '</div>';
            html += '</div>';

            $('#newRow').append(html);
        });

        // remove row
        $(document).on('click', '#removeRow', function () {
            let idNumber = $(this).closest(".ThisNumber").attr("id")
            // if(idNumber < i){
            //     console.log('yes')
            //     console.log(`${idNumber} === ${i}`)
            //     let newId = idNumber
            //     let formFind = $("#form_wow").find("#"+idNumber+"")
            //     let plusId = parseInt(idNumber)+1
                // for (let index = plusId; index < i; index++) {
                //     let ini = $("#form_wow").find("#"+index+"").attr("id")
                //     console.log(ini)
                //     newId++
                // }
            // }
            $('#form_wow').find('.ThisNumber').each(function(){
                isChange = $(this).attr("id")
                if(isChange >= idNumber){
                    let newId = parseInt(isChange)-1
                    $(this).attr("id", ""+newId+"")
                }
            })

            $(this).closest('#inputFormRow').remove();
            i -= 1
        });

        $('#form_wow').on('submit', function(e) {
            e.preventDefault();
            let thisData  = $('#form_wow').serialize()
            $.ajax({
                url : '{{ route("book.store") }}',
                data: $(this).serialize(),
                type : 'POST',
                dataType:'JSON',
                success:function(response){
                    $('.is-invalid').removeClass('is-invalid');
                    if (response.code == 200) {
                        alert("okkkk")
                    } else {
                        for (control in response.message) {
                            let z = control
                            let num = z.match(/[\d\.]+/g);
                            let stri = z.replace(/\d+/g, '')
                            if (num != null){
                                let number = num.toString();
                                number = number.replaceAll('.', '');
                                stri = stri.replaceAll('.', '');
                                let on = $("#"+number+"")
                                let errorMessageID = stri+'.'+number
                                on.find('#field-' + stri).addClass('is-invalid');
                                on.find('#error-' + stri).html(response.message[errorMessageID]);
                            }

                        }
                    }
                },
                error: function (jqXHR, textStatus, errorThrown){
                    console.log(jqXHR)
                }
            })
        })
    </script>
</html>
